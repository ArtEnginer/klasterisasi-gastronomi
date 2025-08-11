<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\NilaiKriteriaKlasterisasiModel;

class NilaiKriteriaKlasterisasiController extends BaseApi
{
    protected $modelName = NilaiKriteriaKlasterisasiModel::class;
    protected $load = ['kriteriaKlasterisasi', 'gastronomi'];

    public function store()
    {
        $gastronomi_kodes = $this->request->getPost('gastronomi_kode');
        $nilai_data = $this->request->getPost('nilai');

        foreach ($gastronomi_kodes as $kode_gastronomi) {
            foreach ($nilai_data[$kode_gastronomi] as $kode_kriteria => $nilai) {
                NilaiKriteriaKlasterisasiModel::updateOrCreate(
                    [
                        'kriteria_klasterisasi_kode' => $kode_kriteria,
                        'gastronomi_kode' => $kode_gastronomi,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }
    }


    public function storeupdate()
    {
        $gastronomiKode = $this->request->getPost('gastronomi_kode');
        $nilaiData = $this->request->getPost('nilai');

        if (!$gastronomiKode || !$nilaiData) {
            return $this->failValidationErrors("Data tidak lengkap.");
        }

        // Hapus semua nilai lama dulu
        NilaiKriteriaKlasterisasiModel::where('gastronomi_kode', $gastronomiKode)->delete();

        // Insert baru pakai create (Eloquent-style)
        foreach ($nilaiData as $kriteriaKode => $nilai) {
            NilaiKriteriaKlasterisasiModel::create([
                'gastronomi_kode' => $gastronomiKode,
                'kriteria_klasterisasi_kode' => $kriteriaKode,
                'nilai' => $nilai,
            ]);
        }

        return $this->respond([
            'status' => 'success',
            'message' => 'Nilai berhasil diperbarui',
        ]);
    }



    public function grouped()
    {

        $data = NilaiKriteriaKlasterisasiModel::with(['kriteriaKlasterisasi', 'gastronomi'])
            ->get()
            ->groupBy('gastronomi.kode')
            ->map(function ($items, $kode_gastronomi) {
                $gastronomi = $items->first()->gastronomi;
                $nilai = $items->pluck('nilai', 'kriteriaKlasterisasi.kode')->toArray();
                return [
                    'nama' => $gastronomi->nama,
                    'kode' => $kode_gastronomi,
                    'nilai' => $nilai,
                ];
            })->values();

        return $this->respond($data);
    }
}
