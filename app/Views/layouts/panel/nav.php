<a href="#!" class="nav-close"><i class="material-icons">menu</i></a>
<div class="nav-header">

    <h1><b>
            SISTEM KLASTERISASI<br>
            WISATA GASTRONOMI
        </b></h1>

    <div class="user-badge">
        <i class="material-icons">account_circle</i>
        <span class="user-role"><?= auth()->user()->inGroup('admin') ? 'Administrator' : (auth()->user()->inGroup('pimpinan') ? 'Pimpinan' : 'Wisatawan') ?></span>
    </div>
</div>
<div class="nav-list">
    <div class="nav-item" data-page="dashboard">
        <a href="<?= base_url('panel') ?>" class="nav-link">
            <i class="material-icons">dashboard</i>
            <span>Dashboard Utama</span>
        </a>
    </div>
    <?php if (auth()->user()->inGroup('admin')) : ?>
        <div class="nav-item" data-page="gastronomi">
            <a href="<?= base_url('panel/gastronomi') ?>" class="nav-link">
                <i class="material-icons">restaurant</i>
                <span>Data Gastronomi</span>
            </a>
        </div>

        <div class="nav-item" data-page="kriteria-klasterisasi">
            <a href="<?= base_url('panel/kriteria-klasterisasi') ?>" class="nav-link">
                <i class="material-icons">assignment</i>
                <span>Kriteria Klasterisasi</span>
            </a>
        </div>

        <div class="nav-item" data-page="nilai-kriteria-klasterisasi">
            <a href="<?= base_url('panel/nilai-kriteria-klasterisasi') ?>" class="nav-link">
                <i class="material-icons">analytics</i>
                <span>Nilai Kriteria</span>
            </a>
        </div>

        <div class="nav-item" data-page="user">
            <a href="<?= base_url('panel/user') ?>" class="nav-link">
                <i class="material-icons">people</i>
                <span>Manajemen User</span>
            </a>
        </div>
    <?php endif ?>

    <div class="nav-divider"></div>

    <div class="nav-item">
        <a href="<?= base_url('logout') ?>" class="nav-link btn-logout">
            <i class="material-icons">logout</i>
            <span>Keluar Sistem</span>
        </a>
    </div>
</div>