<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<h1 class="page-title">Model Klasterisasi gastronomi</h1>
<div style="overflow:auto">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s2"><a href="#map-tab">Peta</a></li>
                    <li class="tab col s2"><a href="#cluster-tab">Klasterisasi</a></li>

                </ul>
            </div>

            <div id="map-tab" class="col s12">
                <div id="map" style="height: 500px;"></div>
            </div>

            <div id="cluster-tab" class="col s12">
                <a class="waves-effect waves-light btn green" id="btn-cluster">Klasterisasi (K-Means)</a>
                <div id="cluster-results" class="section"></div>
                <div id="cluster-details" class="section"></div>
                <div id="calculation-steps" class="card-panel grey lighten-3"></div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>