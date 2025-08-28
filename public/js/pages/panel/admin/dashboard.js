$(document).ready(function () {
  // Initialize Materialize tabs
  var tabs = document.querySelectorAll(".tabs");
  M.Tabs.init(tabs);

  let map;
  let markers = [];
  let gastronomiData = [];
  let klasterisasiCriteria = [];
  let manualCentroids = null;

  // Initialize map with OpenStreetMap and Nominatim for geocoding
  function initMap() {
    // Check if map container exists
    if (!document.getElementById("map")) return;

    map = L.map("map").setView([-7.5838902875197, 110.81321640838382], 14);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    // Initialize Nominatim geocoder
    geocoder = L.Control.geocoder({
      defaultMarkGeocode: false,
      position: "topleft",
      placeholder: "Cari lokasi...",
      errorMessage: "Lokasi tidak ditemukan",
      geocoder: new L.Control.Geocoder.Nominatim(),
    })
      .on("markgeocode", function (e) {
        const { center, name } = e.geocode;
        setUserLocation(center.lat, center.lng);
        $("#user-lat").val(center.lat);
        $("#user-lng").val(center.lng);
        $("#location-name").val(name);
        map.fitBounds(e.geocode.bbox);
      })
      .addTo(map);

    // Add click event for map
    map.on("click", function (e) {
      setUserLocation(e.latlng.lat, e.latlng.lng);
      $("#user-lat").val(e.latlng.lat);
      $("#user-lng").val(e.latlng.lng);

      // Reverse geocode to get location name
      fetch(
        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`
      )
        .then((response) => response.json())
        .then((data) => {
          const name = data.display_name || "Lokasi terpilih";
          $("#location-name").val(name);
        })
        .catch((error) => console.error("Geocoding error:", error));
    });

    // Add event listener for tab change
    $("ul.tabs").on("click", "a", function () {
      setTimeout(() => {
        map.invalidateSize();
        if (gastronomiData.length > 0) {
          plotgastronomiOnMap(gastronomiData);
        }
      }, 100);
    });
  }

  // Set user location on map
  function setUserLocation(lat, lng) {
    // Clear existing user marker if any
    if (window.userMarker) {
      map.removeLayer(window.userMarker);
    }

    window.userMarker = L.marker([lat, lng], {
      icon: L.divIcon({
        className: "user-marker",
        html: '<div style="background-color: blue; width: 20px; height: 20px; border-radius: 50%;"></div>',
        iconSize: [20, 20],
      }),
    })
      .addTo(map)
      .bindPopup("Lokasi Anda")
      .openPopup();
  }

  // Load data
  function loadData() {
    cloud
      .add(baseUrl + "/api/gastronomi", {
        name: "gastronomi",
      })
      .then((gastronomi) => {
        gastronomiData = gastronomi;
        console.log("gastronomi data loaded", gastronomi);
        plotgastronomiOnMap(gastronomi);
        populateCentroidOptions(gastronomi);
        updateClusterButton();
      })
      .catch((error) => console.error("Error loading gastronomi data:", error));

    cloud
      .add(baseUrl + "/api/kriteria-klasterisasi", {
        name: "kriteria-klasterisasi",
      })
      .then((kriteria) => {
        klasterisasiCriteria = kriteria;
        console.log("Kriteria Klasterisasi data loaded", kriteria);
      })
      .catch((error) => console.error("Error loading criteria data:", error));
  }

  // Plot gastronomi on map with cluster colors
  function plotgastronomiOnMap(gastronomi) {
    if (!map || !gastronomi || gastronomi.length === 0) return;

    // Clear existing markers
    clearMarkers();

    // Define cluster colors
    const clusterColors = [
      "#FF0000",
      "#00FF00",
      "#0000FF",
      "#FFFF00",
      "#FF00FF",
    ]; // Red, Green, Blue, Yellow, Purple

    // Add markers for each gastronomi
    gastronomi.forEach((item) => {
      const lat = parseFloat(item.latitude);
      const lng = parseFloat(item.longitude);

      if (isNaN(lat) || isNaN(lng)) {
        console.error("Invalid coordinates for", item.nama);
        return;
      }

      // Determine color based on cluster or default to green
      const color =
        item.klaster !== undefined
          ? clusterColors[item.klaster % clusterColors.length]
          : "#00FF00";

      const marker = L.marker([lat, lng], {
        icon: L.divIcon({
          className: "gastronomi-marker",
          html: `<div style="background-color: ${color}; width: 20px; height: 20px; border-radius: 50%;"></div>`,
          iconSize: [20, 20],
        }),
        riseOnHover: true,
      })
        .addTo(map)
        .bindPopup(createPopupContent(item));

      markers.push(marker);
    });

    // Fit bounds to show all markers if there are any
    if (markers.length > 0) {
      const group = new L.featureGroup(markers);
      map.fitBounds(group.getBounds().pad(0.1));
    }
  }

  // Create popup content for markers
  function createPopupContent(item) {
    let content = `<b>${item.nama}</b><br>${item.deskripsi || ""}`;

    if (item.klaster !== undefined) {
      const clusterNames = ["Sangat Bagus", "Cukup Bagus", "Kurang Bagus"];
      content += `<br><b>Klaster:</b> ${
        clusterNames[item.klaster] || item.klaster
      }`;
    }

    if (item.nilai_kriteria_klasterisasi) {
      content += "<br><b>Kriteria:</b><ul>";
      item.nilai_kriteria_klasterisasi.forEach((kriteria) => {
        content += `<li>${kriteria.kriteria_klasterisasi.nama}: ${kriteria.nilai}</li>`;
      });
      content += "</ul>";
    }

    return content;
  }

  // Clear all markers from map
  function clearMarkers() {
    markers.forEach((marker) => map.removeLayer(marker));
    markers = [];
  }

  // Initialize map and load data when ready
  $(window).on("load", function () {
    initMap();
    loadData();
    initCentroidForm();
  });

  // Reinitialize map when tab changes
  $("ul.tabs").on("click", "a", function () {
    setTimeout(function () {
      if (map) {
        map.invalidateSize();
      } else if ($("#map-tab").is(":visible")) {
        initMap();
      }
    }, 100);
  });

  // Populate centroid selection options
  function populateCentroidOptions(gastronomi) {
    const centroidSelects = ["#centroid-1", "#centroid-2", "#centroid-3"];

    centroidSelects.forEach((selectId) => {
      const select = $(selectId);
      select.empty();
      select.append(
        '<option value="" disabled selected>Pilih Destinasi</option>'
      );

      gastronomi.forEach((item, index) => {
        select.append(`<option value="${index}">${item.nama}</option>`);
      });
    });

    // Initialize Materialize select
    $("select").formSelect();
  }

  // Handle centroid method change
  function initCentroidForm() {
    $('input[name="centroid-method"]').change(function () {
      if ($(this).val() === "manual") {
        $("#manual-centroid-form").slideDown();
        // Reset form when switching to manual
        $("#centroid-1, #centroid-2, #centroid-3").val("").formSelect();
        $("#centroid-preview").html("");
        manualCentroids = null;
      } else {
        $("#manual-centroid-form").slideUp();
        manualCentroids = null;
        // Reset map to show normal markers
        plotgastronomiOnMap(gastronomiData);
      }
      updateClusterButton();
    });

    // Handle centroid selection change
    $("#centroid-1, #centroid-2, #centroid-3").change(function () {
      updateCentroidPreview();
      updateClusterButton();
    });
  }

  // Update cluster button state
  function updateClusterButton() {
    const centroidMethod = $('input[name="centroid-method"]:checked').val();
    const btn = $("#btn-cluster");

    if (centroidMethod === "manual") {
      if (manualCentroids && manualCentroids.length === 3) {
        btn.removeClass("disabled").removeAttr("disabled");
        btn.find("i").text("play_arrow");
        btn.find(".btn-text").text("Jalankan Klasterisasi K-Means");
      } else {
        btn.addClass("disabled").attr("disabled", true);
        btn.find("i").text("warning");
        btn.find(".btn-text").text("Pilih 3 Centroid Terlebih Dahulu");
      }
    } else {
      btn.removeClass("disabled").removeAttr("disabled");
      btn.find("i").text("play_arrow");
      btn.find(".btn-text").text("Jalankan Klasterisasi K-Means");
    }
  }

  // Update centroid preview
  function updateCentroidPreview() {
    const centroid1Index = $("#centroid-1").val();
    const centroid2Index = $("#centroid-2").val();
    const centroid3Index = $("#centroid-3").val();

    if (!centroid1Index || !centroid2Index || !centroid3Index) {
      $("#centroid-preview").html("");
      manualCentroids = null;
      // Re-plot map without centroid highlights
      plotgastronomiOnMap(gastronomiData);
      return;
    }

    // Check for duplicates
    const selectedIndices = [centroid1Index, centroid2Index, centroid3Index];
    const uniqueIndices = [...new Set(selectedIndices)];

    if (uniqueIndices.length !== 3) {
      $("#centroid-preview").html(
        '<div class="red-text">Error: Tidak boleh memilih destinasi yang sama untuk centroid berbeda!</div>'
      );
      manualCentroids = null;
      return;
    }

    const selectedGastronomi = [
      gastronomiData[parseInt(centroid1Index)],
      gastronomiData[parseInt(centroid2Index)],
      gastronomiData[parseInt(centroid3Index)],
    ];

    // Extract centroid values
    manualCentroids = selectedGastronomi.map((item) =>
      item.nilai_kriteria_klasterisasi.map((nilai) => parseFloat(nilai.nilai))
    );

    // Highlight selected centroids on map
    highlightCentroidsOnMap(selectedIndices);

    // Show preview
    let html = "<h6>Preview Centroid Terpilih:</h6>";
    html +=
      '<div class="green-text" style="margin-bottom: 10px;"><i class="material-icons tiny">check_circle</i> Centroid berhasil dipilih!</div>';
    html +=
      '<table class="table table-bordered"><thead><tr><th>Centroid</th><th>Destinasi</th>';
    klasterisasiCriteria.forEach((crit) => {
      html += `<th>${crit.nama}</th>`;
    });
    html += "</tr></thead><tbody>";

    selectedGastronomi.forEach((item, idx) => {
      const clusterNames = ["Sangat Bagus", "Cukup Bagus", "Kurang Bagus"];
      const clusterColors = ["#FF0000", "#00FF00", "#0000FF"];
      html += `<tr><td><strong style="color: ${clusterColors[idx]}">${clusterNames[idx]}</strong></td><td>${item.nama}</td>`;
      item.nilai_kriteria_klasterisasi.forEach((nilai) => {
        html += `<td>${nilai.nilai}</td>`;
      });
      html += "</tr>";
    });

    html += "</tbody></table>";
    html +=
      '<p class="grey-text"><i class="material-icons tiny">info</i> Centroid ini akan digunakan sebagai titik awal klasterisasi K-Means. Lihat titik yang disorot di peta.</p>';
    $("#centroid-preview").html(html);
  }

  // Highlight selected centroids on map
  function highlightCentroidsOnMap(centroidIndices) {
    if (!map || !gastronomiData || gastronomiData.length === 0) return;

    // Clear existing markers
    clearMarkers();

    // Define cluster colors for centroids
    const centroidColors = ["#FF0000", "#00FF00", "#0000FF"]; // Red, Green, Blue

    // Add markers for each gastronomi
    gastronomiData.forEach((item, index) => {
      const lat = parseFloat(item.latitude);
      const lng = parseFloat(item.longitude);

      if (isNaN(lat) || isNaN(lng)) {
        console.error("Invalid coordinates for", item.nama);
        return;
      }

      // Check if this is a selected centroid
      const centroidIndex = centroidIndices.indexOf(index.toString());
      const isCentroid = centroidIndex !== -1;

      // Determine marker style
      let markerStyle, markerSize;
      if (isCentroid) {
        const color = centroidColors[centroidIndex];
        markerStyle = `background-color: ${color}; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);`;
        markerSize = [30, 30];
      } else {
        markerStyle = `background-color: #808080; width: 15px; height: 15px; border-radius: 50%; opacity: 0.6;`;
        markerSize = [15, 15];
      }

      const marker = L.marker([lat, lng], {
        icon: L.divIcon({
          className: isCentroid ? "centroid-marker" : "gastronomi-marker",
          html: `<div style="${markerStyle}"></div>`,
          iconSize: markerSize,
        }),
        riseOnHover: true,
      })
        .addTo(map)
        .bindPopup(createCentroidPopupContent(item, isCentroid, centroidIndex));

      markers.push(marker);
    });

    // Fit bounds to show all markers if there are any
    if (markers.length > 0) {
      const group = new L.featureGroup(markers);
      map.fitBounds(group.getBounds().pad(0.1));
    }
  }

  // Create popup content for centroid markers
  function createCentroidPopupContent(item, isCentroid, centroidIndex) {
    let content = `<b>${item.nama}</b><br>${item.deskripsi || ""}`;

    if (isCentroid) {
      const clusterNames = ["Sangat Bagus", "Cukup Bagus", "Kurang Bagus"];
      content += `<br><b style="color: #ff6600;">🎯 CENTROID ${
        centroidIndex + 1
      }</b>`;
      content += `<br><b>Klaster:</b> ${clusterNames[centroidIndex]}`;
    }

    if (item.nilai_kriteria_klasterisasi) {
      content += "<br><b>Kriteria:</b><ul>";
      item.nilai_kriteria_klasterisasi.forEach((kriteria) => {
        content += `<li>${kriteria.kriteria_klasterisasi.nama}: ${kriteria.nilai}</li>`;
      });
      content += "</ul>";
    }

    return content;
  }

  // K-Means Clustering implementation with manual centroid option
  function kMeansClustering(
    data,
    k = 3,
    maxIterations = 100,
    initialCentroids = null
  ) {
    // Extract features for clustering
    const features = data.map((item) => {
      return item.nilai_kriteria_klasterisasi.map((nilai) =>
        parseFloat(nilai.nilai)
      );
    });

    // Step 1: Initialize centroids
    let centroids = [];

    if (initialCentroids && initialCentroids.length === k) {
      // Use manual centroids
      centroids = initialCentroids.map((centroid) => [...centroid]);
    } else {
      // Use random centroids (original behavior)
      const randomIndices = [];
      while (randomIndices.length < k) {
        const randomIndex = Math.floor(Math.random() * data.length);
        if (!randomIndices.includes(randomIndex)) {
          randomIndices.push(randomIndex);
          centroids.push([...features[randomIndex]]);
        }
      }
    }

    let clusters = Array(data.length).fill(-1);
    let prevClusters = Array(data.length).fill(-2);
    let iterations = 0;
    let steps = [];

    const initMethod = initialCentroids ? "manual" : "acak";
    steps.push({
      title: "Inisialisasi Awal",
      description: `Memilih ${k} centroid secara ${initMethod}:`,
      centroids: [...centroids],
      clusters: [...clusters],
      method: initMethod,
    });

    while (!arraysEqual(clusters, prevClusters) && iterations < maxIterations) {
      prevClusters = [...clusters];

      // Step 2: Assign each point to the nearest centroid
      const assignments = [];
      for (let i = 0; i < features.length; i++) {
        let minDist = Infinity;
        let bestCluster = -1;
        let distances = [];

        for (let j = 0; j < centroids.length; j++) {
          const dist = euclideanDistance(features[i], centroids[j]);
          distances.push(dist);
          if (dist < minDist) {
            minDist = dist;
            bestCluster = j;
          }
        }

        clusters[i] = bestCluster;
        assignments.push({
          point: features[i],
          distances: distances,
          cluster: bestCluster,
        });
      }

      steps.push({
        title: `Iterasi ${iterations + 1} - Penugasan Klaster`,
        description:
          "Menghitung jarak setiap titik ke centroid dan menetapkan ke klaster terdekat:",
        centroids: [...centroids],
        clusters: [...clusters],
        assignments: [...assignments],
      });

      // Step 3: Update centroids
      const clusterSums = Array(k)
        .fill()
        .map(() => Array(features[0].length).fill(0));
      const clusterCounts = Array(k).fill(0);

      for (let i = 0; i < features.length; i++) {
        const cluster = clusters[i];
        clusterCounts[cluster]++;

        for (let j = 0; j < features[i].length; j++) {
          clusterSums[cluster][j] += features[i][j];
        }
      }

      const newCentroids = [];
      for (let i = 0; i < k; i++) {
        newCentroids.push([]);
        if (clusterCounts[i] > 0) {
          for (let j = 0; j < features[0].length; j++) {
            newCentroids[i][j] = clusterSums[i][j] / clusterCounts[i];
          }
        } else {
          // If a cluster has no points, keep the previous centroid
          newCentroids[i] = [...centroids[i]];
        }
      }

      steps.push({
        title: `Iterasi ${iterations + 1} - Pembaruan Centroid`,
        description:
          "Menghitung centroid baru sebagai rata-rata titik dalam setiap klaster:",
        oldCentroids: [...centroids],
        newCentroids: [...newCentroids],
        clusterCounts: [...clusterCounts],
      });

      centroids = newCentroids;
      iterations++;
    }

    // Calculate silhouette score for validation
    const silhouetteScore = calculateSilhouetteScore(
      features,
      clusters,
      centroids
    );

    return {
      clusters: clusters,
      centroids: centroids,
      silhouetteScore: silhouetteScore,
      steps: steps,
      iterations: iterations,
    };
  }

  // Check if two arrays are equal
  function arraysEqual(a, b) {
    if (a === b) return true;
    if (a == null || b == null) return false;
    if (a.length !== b.length) return false;

    for (let i = 0; i < a.length; ++i) {
      if (a[i] !== b[i]) return false;
    }
    return true;
  }

  // Calculate Euclidean distance between two points
  function euclideanDistance(a, b) {
    let sum = 0;
    for (let i = 0; i < a.length; i++) {
      sum += Math.pow(a[i] - b[i], 2);
    }
    return Math.sqrt(sum);
  }

  // Calculate silhouette score for clustering validation
  function calculateSilhouetteScore(features, clusters, centroids) {
    let totalScore = 0;

    for (let i = 0; i < features.length; i++) {
      const currentCluster = clusters[i];

      // Calculate a(i) - average distance to other points in same cluster
      let a = 0;
      let sameClusterCount = 0;

      for (let j = 0; j < features.length; j++) {
        if (i !== j && clusters[j] === currentCluster) {
          a += euclideanDistance(features[i], features[j]);
          sameClusterCount++;
        }
      }

      a = sameClusterCount > 0 ? a / sameClusterCount : 0;

      // Calculate b(i) - smallest average distance to other clusters
      let b = Infinity;

      for (let k = 0; k < centroids.length; k++) {
        if (k !== currentCluster) {
          let distSum = 0;
          let count = 0;

          for (let j = 0; j < features.length; j++) {
            if (clusters[j] === k) {
              distSum += euclideanDistance(features[i], features[j]);
              count++;
            }
          }

          const avgDist = count > 0 ? distSum / count : Infinity;
          if (avgDist < b) {
            b = avgDist;
          }
        }
      }

      // Calculate silhouette for this point
      const s = (b - a) / Math.max(a, b);
      totalScore += isNaN(s) ? 0 : s;
    }

    return totalScore / features.length;
  }

  // Interpret silhouette score values
  function interpretSilhouetteScore(score) {
    if (score > 0.7) return "Struktur klaster kuat";
    if (score > 0.5) return "Struktur klaster masuk akal";
    if (score > 0.25) return "Struktur klaster lemah";
    return "Tidak ada struktur klaster yang substansial";
  }

  // Event handlers
  $("#btn-cluster").click(function () {
    if (gastronomiData.length === 0 || klasterisasiCriteria.length === 0) {
      M.toast({
        html: "Data gastronomi atau kriteria klasterisasi belum dimuat!",
        classes: "red",
      });
      return;
    }

    // Check centroid method
    const centroidMethod = $('input[name="centroid-method"]:checked').val();
    let initialCentroids = null;

    if (centroidMethod === "manual") {
      if (!manualCentroids || manualCentroids.length !== 3) {
        M.toast({
          html: "Silakan pilih 3 destinasi untuk centroid awal!",
          classes: "orange",
        });
        return;
      }
      initialCentroids = manualCentroids;
    }

    // Show loading state
    const btn = $(this);
    const originalHtml = btn.html();
    btn.html(
      '<i class="material-icons left">hourglass_empty</i><span class="btn-text">Memproses...</span>'
    );
    btn.addClass("disabled").attr("disabled", true);

    // Run clustering with a slight delay to show loading state
    setTimeout(() => {
      try {
        const result = kMeansClustering(
          gastronomiData,
          3,
          100,
          initialCentroids
        );

        // Update gastronomi data with new clusters
        gastronomiData.forEach((item, index) => {
          item.klaster = result.clusters[index];
        });

        // Plot with new clusters
        plotgastronomiOnMap(gastronomiData);

        // Show clustering results
        showClusterResults(result);

        // Show success message
        const methodText =
          centroidMethod === "manual" ? "centroid manual" : "centroid acak";
        M.toast({
          html: `Klasterisasi berhasil dengan ${methodText}! (${result.iterations} iterasi)`,
          classes: "green",
        });

        console.log("Clustering completed", result);
      } catch (error) {
        console.error("Clustering error:", error);
        M.toast({
          html: "Terjadi kesalahan saat melakukan klasterisasi!",
          classes: "red",
        });
      } finally {
        // Restore button state
        btn.html(originalHtml);
        btn.removeClass("disabled").removeAttr("disabled");
        updateClusterButton();
      }
    }, 500);
  });

  // Show cluster results with detailed steps
  function showClusterResults(result) {
    const clusterNames = ["Sangat Bagus", "Cukup Bagus", "Kurang Bagus"];
    const clusterCounts = Array(result.centroids.length).fill(0);

    // Group gastronomi by cluster
    const gastronomiByCluster = Array(result.centroids.length).fill().map(() => []);
    
    result.clusters.forEach((clusterIndex, gastronomiIndex) => {
      clusterCounts[clusterIndex]++;
      gastronomiByCluster[clusterIndex].push(gastronomiData[gastronomiIndex].nama);
    });

    let html = "<h4>Hasil Klasterisasi K-Means</h4>";

    // Show initialization method
    const centroidMethod = $('input[name="centroid-method"]:checked').val();
    if (centroidMethod === "manual") {
      html +=
        '<div class="blue-text" style="margin-bottom: 15px;"><i class="material-icons tiny">info</i> <strong>Metode:</strong> Centroid Manual (dipilih oleh pengguna)</div>';
    } else {
      html +=
        '<div class="blue-text" style="margin-bottom: 15px;"><i class="material-icons tiny">shuffle</i> <strong>Metode:</strong> Centroid Acak (otomatis)</div>';
    }

    html += `<p><strong>Jumlah Iterasi:</strong> ${result.iterations}</p>`;
    html += `<p><strong>Silhouette Score:</strong> ${result.silhouetteScore.toFixed(
      4
    )} (${interpretSilhouetteScore(result.silhouetteScore)})</p>`;
    html +=
      '<table class="table table-bordered"><thead><tr><th>Klaster</th><th>Jumlah gastronomi</th><th>Centroid Akhir</th><th>Nama Wisata Gastronomi</th></tr></thead><tbody>';

    result.centroids.forEach((centroid, idx) => {
      html += `<tr><td><strong>${clusterNames[idx]}</strong></td><td>${clusterCounts[idx]}</td><td>`;
      centroid.forEach((val, i) => {
        html += `${klasterisasiCriteria[i].nama}: ${val.toFixed(2)}<br>`;
      });
      html += "</td><td>";
      
      // Add gastronomi names for this cluster
      if (gastronomiByCluster[idx].length > 0) {
        gastronomiByCluster[idx].forEach((nama, index) => {
          html += `${index + 1}. ${nama}`;
          if (index < gastronomiByCluster[idx].length - 1) {
            html += "<br>";
          }
        });
      } else {
        html += "<em>Tidak ada wisata gastronomi</em>";
      }
      
      html += "</td></tr>";
    });

    html += "</tbody></table>";

    $("#cluster-results").html(html);

    // Show cluster details
    html =
      '<h4>Detail Klaster</h4><table class="table table-bordered"><thead><tr><th>No</th><th>gastronomi</th><th>Klaster</th>';
    klasterisasiCriteria.forEach((crit) => {
      html += `<th>${crit.nama}</th>`;
    });
    html += "</tr></thead><tbody>";

    gastronomiData.forEach((item, idx) => {
      html += `<tr><td>${idx + 1}</td><td>${item.nama}</td><td>${
        clusterNames[result.clusters[idx]]
      }</td>`;
      item.nilai_kriteria_klasterisasi.forEach((nilai) => {
        html += `<td>${nilai.nilai}</td>`;
      });
      html += "</tr>";
    });

    html += "</tbody></table>";
    $("#cluster-details").html(html);

    // Show detailed calculation steps
    showCalculationSteps(result);
    if (result.silhouetteScore !== undefined) {
      // Jika sedang di tab akurasi, update chart
      if ($("#accuracy-tab:visible").length) {
        showAccuracyChart();
      }
    }
  }

  // Interpret silhouette score
  function interpretSilhouetteScore(score) {
    if (score > 0.7) return "Struktur klaster kuat";
    if (score > 0.5) return "Struktur klaster masuk akal";
    if (score > 0.25) return "Struktur klaster lemah";
    return "Tidak ada struktur klaster yang substansial";
  }

  // Show detailed calculation steps for K-Means
  function showCalculationSteps(result) {
    let html = "<h4>Perhitungan Detail K-Means</h4>";

    result.steps.forEach((step, stepIdx) => {
      html += `<div class="mb-4"><h5>${step.title}</h5>`;
      html += `<p>${step.description}</p>`;

      if (step.assignments) {
        html += '<table class="table table-bordered"><thead><tr><th>Titik</th>';
        for (let i = 0; i < result.centroids.length; i++) {
          html += `<th>Jarak ke Centroid ${i + 1}</th>`;
        }
        html += "<th>Klaster Terdekat</th></tr></thead><tbody>";

        step.assignments.forEach((assignment, idx) => {
          html += `<tr><td>${gastronomiData[idx].nama}</td>`;
          assignment.distances.forEach((dist) => {
            html += `<td>${dist.toFixed(2)}</td>`;
          });
          html += `<td>${assignment.cluster + 1}</td></tr>`;
        });

        html += "</tbody></table>";
      }

      if (step.centroids) {
        html +=
          '<h6>Centroid:</h6><table class="table table-bordered"><thead><tr><th>Centroid</th>';
        klasterisasiCriteria.forEach((crit) => {
          html += `<th>${crit.nama}</th>`;
        });
        html += "</tr></thead><tbody>";

        step.centroids.forEach((centroid, idx) => {
          html += `<tr><td>${idx + 1}</td>`;
          centroid.forEach((val) => {
            html += `<td>${val.toFixed(2)}</td>`;
          });
          html += "</tr>";
        });

        html += "</tbody></table>";
      }

      if (step.newCentroids && step.oldCentroids) {
        html +=
          '<h6>Perubahan Centroid:</h6><table class="table table-bordered"><thead><tr><th>Centroid</th>';
        klasterisasiCriteria.forEach((crit) => {
          html += `<th>${crit.nama}</th>`;
        });
        html += "<th>Jumlah Anggota</th></tr></thead><tbody>";

        step.newCentroids.forEach((centroid, idx) => {
          html += `<tr><td>${idx + 1}</td>`;
          centroid.forEach((val) => {
            html += `<td>${val.toFixed(2)}</td>`;
          });
          html += `<td>${
            step.clusterCounts ? step.clusterCounts[idx] : "-"
          }</td></tr>`;
        });

        html += "</tbody></table>";
      }

      html += "</div>";
    });

    $("#calculation-steps").html(html);
  }
});
