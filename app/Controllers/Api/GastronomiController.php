<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\GastronomiModel;

class GastronomiController extends BaseApi
{
    protected $modelName = GastronomiModel::class;
    protected $load = ['nilaiKriteriaKlasterisasi'];
    public function validateCreate(&$request)

    {
        return $this->validate([
            'nama' => 'required',
            'kode' => 'required|is_unique[gastronomi.kode]',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
        ]);
    }


    public function beforeCreate(&$request)
    {
        $image = $this->request->getFile('gambar');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $namagambar = $image->getRandomName();
            $image->move(WRITEPATH . 'uploads', $namagambar);
            $request->gambar = $namagambar;
        }
    }


    public function beforeUpdate(&$request)
    {
        $image = $this->request->getFile('gambar');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $namagambar = $image->getRandomName();
            $image->move(WRITEPATH . 'uploads', $namagambar);
            $request->gambar = $namagambar;
        }
    }
}
