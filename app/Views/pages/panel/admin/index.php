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
    <div class="container">
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
                    <a class="waves-effect waves-light btn gastronomy-btn" id="btn-cluster">
                        <i class="material-icons left">play_arrow</i>
                        Jalankan Klasterisasi K-Means
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