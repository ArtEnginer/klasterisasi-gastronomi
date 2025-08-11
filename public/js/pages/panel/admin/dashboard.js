$(document).ready(function () {
  // Initialize Materialize tabs
  var tabs = document.querySelectorAll(".tabs");
  M.Tabs.init(tabs);

  let map;
  let markers = [];
  let gastronomiData = [];
  let klasterisasiCriteria = [];

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
      .add(origin + "/api/gastronomi", {
        name: "gastronomi",
      })
      .then((gastronomi) => {
        gastronomiData = gastronomi;
        console.log("gastronomi data loaded", gastronomi);
        plotgastronomiOnMap(gastronomi);
      })
      .catch((error) => console.error("Error loading gastronomi data:", error));

    cloud
      .add(origin + "/api/kriteria-klasterisasi", {
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
      const clusterNames = ["Rendah", "Sedang", "Tinggi"];
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

  // K-Means Clustering implementation with detailed steps
  function kMeansClustering(data, k = 3, maxIterations = 100) {
    // Extract features for clustering
    const features = data.map((item) => {
      return item.nilai_kriteria_klasterisasi.map((nilai) =>
        parseFloat(nilai.nilai)
      );
    });

    // Step 1: Initialize centroids randomly
    let centroids = [];
    const randomIndices = [];
    while (randomIndices.length < k) {
      const randomIndex = Math.floor(Math.random() * data.length);
      if (!randomIndices.includes(randomIndex)) {
        randomIndices.push(randomIndex);
        centroids.push([...features[randomIndex]]);
      }
    }

    let clusters = Array(data.length).fill(-1);
    let prevClusters = Array(data.length).fill(-2);
    let iterations = 0;
    let steps = [];

    steps.push({
      title: "Inisialisasi Awal",
      description: `Memilih ${k} centroid acak dari data:`,
      centroids: [...centroids],
      clusters: [...clusters],
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
      alert("Data gastronomi atau kriteria klasterisasi belum dimuat!");
      return;
    }

    const result = kMeansClustering(gastronomiData);

    // Update gastronomi data with new clusters
    gastronomiData.forEach((item, index) => {
      item.klaster = result.clusters[index];
    });

    // Plot with new clusters
    plotgastronomiOnMap(gastronomiData);

    // Show clustering results
    showClusterResults(result);

    console.log("Clustering completed", result);
  });

  // Show cluster results with detailed steps
  function showClusterResults(result) {
    const clusterNames = ["Tinggi", "Sedang", "Rendah"];
    const clusterCounts = Array(result.centroids.length).fill(0);

    result.clusters.forEach((c) => clusterCounts[c]++);

    let html = "<h4>Hasil Klasterisasi</h4>";
    html += `<p>Jumlah Iterasi: ${result.iterations}</p>`;
    html += `<p>Silhouette Score: ${result.silhouetteScore.toFixed(
      4
    )} (${interpretSilhouetteScore(result.silhouetteScore)})</p>`;
    html +=
      '<table class="table table-bordered"><thead><tr><th>Klaster</th><th>Jumlah gastronomi</th><th>Centroid</th></tr></thead><tbody>';

    result.centroids.forEach((centroid, idx) => {
      html += `<tr><td>${clusterNames[idx]}</td><td>${clusterCounts[idx]}</td><td>`;
      centroid.forEach((val, i) => {
        html += `${klasterisasiCriteria[i].nama}: ${val.toFixed(2)}<br>`;
      });
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
