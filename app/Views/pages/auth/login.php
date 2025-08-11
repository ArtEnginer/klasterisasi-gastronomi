<?php

/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/auth/main') ?>
<?= $this->section('main') ?>

<div class="auth-card">
    <div class="auth-header">

        <h1 class="title">
            Sistem Klasterisasi Wisata Gastronomi
        </h1>
        <p class="subtitle">
            Platform Digital untuk Pelestarian Kuliner Tradisional Indonesia
        </p>
        <div class="auth-divider"></div>
        <h2 class="login-title">
            Masuk ke Sistem
        </h2>
    </div>
    <br>
    <div class="row card-body">
        <form class="col s12" action="#!" id="login" method="post">
            <?= csrf_field() ?>
            <div class="row mb-0">
                <div class="input-field col s12">
                    <input id="cred" name="cred" type="email" class="validate" value="<?= old('cred') ?>"
                        required>
                    <label for="cred"><i class="material-icons left">email</i>Alamat Email</label>
                </div>
            </div>
            <div class="row mb-0">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate" required>
                    <label for="password"><i class="material-icons left">lock</i>Kata Sandi</label>
                </div>
            </div>

            <button type="submit" class="btn waves-effect waves-light btn-auth">
                <i class="material-icons left">login</i>
                Masuk ke Sistem
            </button>

            <div class="auth-footer">
                <p class="center-align grey-text">
                    <i class="material-icons tiny">security</i>
                    Akses terbatas untuk pengelola sistem
                </p>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>