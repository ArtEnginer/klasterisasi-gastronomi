<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmModel extends Model
{
    protected $table = 'umkm';
    protected $fillable = [
        "id",
        "kode",
        "nama",
        "alamat",
        "deskripsi",
        "gambar",
        "latitude",
        "longitude",
        "klaster",
    ];


    // Relasi dengan eager loading untuk mendapatkan nilai beserta kriteria
    public function nilaiKriteriaKlasterisasi()
    {
        return $this->hasMany(NilaiKriteriaKlasterisasiModel::class, 'umkm_kode', 'kode')
            ->with('kriteriaKlasterisasi');
    }
}
