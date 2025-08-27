<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<div class="dashboard-header">
    <h1 class="page-title">
        <i class="material-icons">restaurant</i>
        Sistem Klasterisasi Wisata Gastronomi
    </h1>
    <p class="page-subtitle">
        Platform Digital untuk Pelestarian Kuliner Tradisional Indonesia
    </p>
</div>
<div style="overflow:auto">
    <div class="">
        <div class="row">
            <div class="col s12">
                <ul class="tabs gastronomy-tabs">
                    <li class="tab col s2">
                        <a href="#map-tab">
                            <i class="material-icons">map</i>
                            Peta Wisata
                        </a>
                    </li>
                    <li class="tab col s2">
                        <a href="#cluster-tab">
                            <i class="material-icons">analytics</i>
                            Analisis Klaster
                        </a>
                    </li>
                </ul>
            </div>

            <div id="map-tab" class="col s12">
                <div class="map-container">
                    <h3 class="tab-title">
                        <i class="material-icons">place</i>
                        Peta Sebaran Wisata Gastronomi
                    </h3>
                    <div id="map" style="height: 500px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"></div>
                </div>
            </div>

            <div id="cluster-tab" class="col s12">
                <div class="cluster-container">
                    <h3 class="tab-title">
                        <i class="material-icons">analytics</i>
                        Analisis Klasterisasi K-Means
                    </h3>
                    <p class="tab-description">
                        Sistem ini menggunakan algoritma K-Means untuk mengelompokkan destinasi wisata gastronomi berdasarkan kriteria tertentu guna mendukung pelestarian kuliner tradisional.
                    </p>

                    <!-- Centroid Configuration Form -->
                    <div class="card-panel centroid-config-card" style="margin-bottom: 20px;">
                        <h5 class="card-title">
                            <i class="material-icons left">settings</i>
                            Konfigurasi Centroid Awal
                        </h5>

                        <div class="row centroid-method-options">
                            <div class="col s12 m6">
                                <label>
                                    <input type="radio" name="centroid-method" value="random" checked />
                                    <span>Centroid Acak (Otomatis)</span>
                                </label>
                            </div>
                            <div class="col s12 m6">
                                <label>
                                    <input type="radio" name="centroid-method" value="manual" />
                                    <span>Centroid Manual</span>
                                </label>
                            </div>
                        </div>

                        <div id="manual-centroid-form" style="display: none;">
                            <h6>Pilih Titik Centroid Awal</h6>
                            <p class="grey-text">Pilih 3 destinasi sebagai centroid awal untuk klasterisasi:</p>

                            <div class="row">
                                <div class="col s12 m4 centroid-select-wrapper">
                                    <div class="input-field">
                                        <select id="centroid-1">
                                            <option value="" disabled selected>Pilih Centroid 1</option>
                                        </select>
                                        <label>Centroid 1 (Sangat Bagus)</label>
                                    </div>
                                </div>
                                <div class="col s12 m4 centroid-select-wrapper">
                                    <div class="input-field">
                                        <select id="centroid-2">
                                            <option value="" disabled selected>Pilih Centroid 2</option>
                                        </select>
                                        <label>Centroid 2 (Cukup Bagus)</label>
                                    </div>
                                </div>
                                <div class="col s12 m4 centroid-select-wrapper">
                                    <div class="input-field">
                                        <select id="centroid-3">
                                            <option value="" disabled selected>Pilih Centroid 3</option>
                                        </select>
                                        <label>Centroid 3 (Kurang Bagus)</label>
                                    </div>
                                </div>
                            </div>

                            <div id="centroid-preview" class="section">
                                <!-- Preview centroid values will be shown here -->
                            </div>
                        </div>
                    </div>

                    <a class="waves-effect waves-light btn gastronomy-btn" id="btn-cluster">
                        <i class="material-icons left">play_arrow</i>
                        <span class="btn-text">Jalankan Klasterisasi K-Means</span>
                    </a>
                    <div id="cluster-results" class="section results-container"></div>
                    <div id="cluster-details" class="section details-container"></div>
                    <div id="calculation-steps" class="card-panel calculation-panel"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>