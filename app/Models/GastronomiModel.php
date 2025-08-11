<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastronomiModel extends Model
{
    protected $table = 'gastronomi';
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
        return $this->hasMany(NilaiKriteriaKlasterisasiModel::class, 'gastronomi_kode', 'kode')
            ->with('kriteriaKlasterisasi');
    }
}
