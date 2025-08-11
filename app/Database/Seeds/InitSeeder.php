<?php

namespace App\Database\Seeds;

use App\Models\PenggunaModel;
use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {

        PenggunaModel::create([
            'username' => 'admin',
            'name' => 'Admin',
        ])->setEmailIdentity([
            'email' => 'admin@gmail.com',
            'password' => "password",
        ])->addGroup('admin')->activate();
        PenggunaModel::create([
            'username' => 'pimpinan',
            'name' => 'pimpinan',
        ])->setEmailIdentity([
            'email' => 'pimpinan@gmail.com',
            'password' => "password",
        ])->addGroup('pimpinan')->activate();
        PenggunaModel::create([
            'username' => 'wisatawan',
            'name' => 'wisatawan',
        ])->setEmailIdentity([
            'email' => 'wisatawan@gmail.com',
            'password' => "password",
        ])->addGroup('wisatawan')->activate();

        $this->db->table('gastronomi')->insertBatch([
            [
                'kode' => '001',
                'nama' => 'Pasar Gede',
                'alamat' => 'Jl. Pasar Gede No. 1',
                'deskripsi' => 'Pasar Gede adalah pasar tradisional yang terkenal dengan berbagai makanan khas Solo.',
                'gambar' => 'pasar-gede.jpg',
                'latitude' => '-7.5737373',
                'longitude' => '110.825335',
                'klaster' => null,
            ],
            [
                'kode' => '002',
                'nama' => 'Gelabo',
                'alamat' => 'Jl. Urip Sumoharjo No. 88',
                'deskripsi' => 'Pusat kuliner modern dengan berbagai makanan khas Solo',
                'gambar' => 'gelabo.jpg',
                'latitude' => '-7.565892',
                'longitude' => '110.832456',
                'klaster' => null,
            ],
            [
                'kode' => '003',
                'nama' => 'Pracima Tuin',
                'alamat' => 'Jl. Slamet Riyadi No. 275',
                'deskripsi' => 'Restoran dengan konsep taman dan budaya Jawa',
                'gambar' => 'pracima-tuin.jpg',
                'latitude' => '-7.560123',
                'longitude' => '110.805678',
                'klaster' => null,
            ],
            [
                'kode' => '004',
                'nama' => 'Ono Solo Ngarsopuro',
                'alamat' => 'Jl. Diponegoro No. 10',
                'deskripsi' => 'Kawasan kuliner malam dengan live music',
                'gambar' => 'ono-solo.jpg',
                'latitude' => '-7.566789',
                'longitude' => '110.812345',
                'klaster' => null,
            ],
            [
                'kode' => '005',
                'nama' => 'Kusumasari',
                'alamat' => 'Jl. Kusumasari No. 15',
                'deskripsi' => 'Tempat makan tradisional dengan suasana Jawa',
                'gambar' => 'kusumasari.jpg',
                'latitude' => '-7.572345',
                'longitude' => '110.818901',
                'klaster' => null,
            ],
            [
                'kode' => '006',
                'nama' => 'Kuliner Balong-Jagalan',
                'alamat' => 'Jl. Balong, Jagalan',
                'deskripsi' => 'Kawasan kuliner tradisional di jantung Solo',
                'gambar' => 'balong-jagalan.jpg',
                'latitude' => '-7.575678',
                'longitude' => '110.828901',
                'klaster' => null,
            ],
            [
                'kode' => '007',
                'nama' => 'Kuliner Gajahan',
                'alamat' => 'Jl. Gajahan No. 25',
                'deskripsi' => 'Pusat jajanan tradisional Solo',
                'gambar' => 'gajahan.jpg',
                'latitude' => '-7.569012',
                'longitude' => '110.821234',
                'klaster' => null,
            ],
            [
                'kode' => '008',
                'nama' => 'Selat Mbak Lies',
                'alamat' => 'Jl. Veteran No. 45',
                'deskripsi' => 'Tempat makan terkenal dengan menu selat solo',
                'gambar' => 'selat-mbak-lies.jpg',
                'latitude' => '-7.567890',
                'longitude' => '110.819876',
                'klaster' => null,
            ],
            [
                'kode' => '009',
                'nama' => 'Sate Kambing Pak Manto',
                'alamat' => 'Jl. Adisucipto No. 78',
                'deskripsi' => 'Tempat makan sate kambing legendaris',
                'gambar' => 'sate-pak-manto.jpg',
                'latitude' => '-7.558765',
                'longitude' => '110.823456',
                'klaster' => null,
            ],
            [
                'kode' => '010',
                'nama' => 'Kuliner Notosuman',
                'alamat' => 'Jl. Notosuman No. 30',
                'deskripsi' => 'Kawasan kuliner dengan berbagai makanan khas',
                'gambar' => 'notosuman.jpg',
                'latitude' => '-7.571234',
                'longitude' => '110.817890',
                'klaster' => null,
            ],
            [
                'kode' => '011',
                'nama' => 'Kuliner Keprabon',
                'alamat' => 'Jl. Keprabon No. 12',
                'deskripsi' => 'Tempat makan dengan suasana tradisional',
                'gambar' => 'keprabon.jpg',
                'latitude' => '-7.568901',
                'longitude' => '110.826543',
                'klaster' => null,
            ],
            [
                'kode' => '012',
                'nama' => 'Kawasan Manahan',
                'alamat' => 'Jl. Manahan No. 5',
                'deskripsi' => 'Area olahraga dengan berbagai kuliner sekitar',
                'gambar' => 'manahan.jpg',
                'latitude' => '-7.557812',
                'longitude' => '110.812345',
                'klaster' => null,
            ],
            [
                'kode' => '013',
                'nama' => 'Kuliner Kota Barat',
                'alamat' => 'Jl. Kota Barat No. 20',
                'deskripsi' => 'Kawasan kuliner di bagian barat Solo',
                'gambar' => 'kota-barat.jpg',
                'latitude' => '-7.563456',
                'longitude' => '110.798765',
                'klaster' => null,
            ],
            [
                'kode' => '014',
                'nama' => 'Pasar Klewer',
                'alamat' => 'Jl. Dr. Radjiman No. 1',
                'deskripsi' => 'Pasar tekstil dengan area kuliner tradisional',
                'gambar' => 'pasar-klewer.jpg',
                'latitude' => '-7.574321',
                'longitude' => '110.827654',
                'klaster' => null,
            ],
            [
                'kode' => '015',
                'nama' => 'Timlo Sastro Penumping',
                'alamat' => 'Jl. Penumping No. 15',
                'deskripsi' => 'Tempat makan terkenal dengan menu timlo',
                'gambar' => 'timlo-sastro.jpg',
                'latitude' => '-7.569876',
                'longitude' => '110.815678',
                'klaster' => null,
            ],
            [
                'kode' => '016',
                'nama' => 'Sate Mbok Galak',
                'alamat' => 'Jl. Yosodipuro No. 33',
                'deskripsi' => 'Tempat makan sate terkenal di Solo',
                'gambar' => 'sate-mbok-galak.jpg',
                'latitude' => '-7.562345',
                'longitude' => '110.814567',
                'klaster' => null,
            ],
            [
                'kode' => '017',
                'nama' => 'Soto Gading',
                'alamat' => 'Jl. Gading No. 8',
                'deskripsi' => 'Tempat makan soto khas Solo',
                'gambar' => 'soto-gading.jpg',
                'latitude' => '-7.571111',
                'longitude' => '110.811111',
                'klaster' => null,
            ],
            [
                'kode' => '018',
                'nama' => 'Es Krim Tentrem',
                'alamat' => 'Jl. Tentrem No. 18',
                'deskripsi' => 'Tempat es krim tradisional legendaris',
                'gambar' => 'es-tentrem.jpg',
                'latitude' => '-7.564444',
                'longitude' => '110.813333',
                'klaster' => null,
            ],
            [
                'kode' => '019',
                'nama' => 'Wedangan Mbah Wiryo',
                'alamat' => 'Jl. Sumpah Pemuda No. 22',
                'deskripsi' => 'Tempat minum wedang dengan suasana Jawa',
                'gambar' => 'wedangan-mbah-wiryo.jpg',
                'latitude' => '-7.566667',
                'longitude' => '110.816667',
                'klaster' => null,
            ],
            [
                'kode' => '020',
                'nama' => 'Bakmi Toprak Yu Nani',
                'alamat' => 'Jl. Sutan Syahrir No. 7',
                'deskripsi' => 'Tempat makan bakmi terkenal',
                'gambar' => 'bakmi-toprak.jpg',
                'latitude' => '-7.568888',
                'longitude' => '110.818888',
                'klaster' => null,
            ],
            [
                'kode' => '021',
                'nama' => 'Sate Kere Yu Rebi',
                'alamat' => 'Jl. RE. Martadinata No. 12',
                'deskripsi' => 'Tempat makan sate kere (ekonomis)',
                'gambar' => 'sate-kere.jpg',
                'latitude' => '-7.563333',
                'longitude' => '110.820000',
                'klaster' => null,
            ]
        ]);

        $this->db->table('kriteria_klasterisasi')->insertBatch([
            [
                'kode' => 'K001',
                'nama' => 'KULINER',
                'deskripsi' => 'Kualitas kuliner yang ditawarkan',
            ],
            [
                'kode' => 'K002',
                'nama' => 'BUDAYA',
                'deskripsi' => 'Nilai-nilai budaya yang diusung oleh produk',
            ],
            [
                'kode' => 'K003',
                'nama' => 'EKONOMI',
                'deskripsi' => 'Aspek ekonomi yang mempengaruhi produk',
            ],
            [
                'kode' => 'K004',
                'nama' => 'INFRASTRUKTUR',
                'deskripsi' => 'Bentuk dan kondisi infrastruktur yang mendukung produk',
            ],
        ]);

        $this->db->table('nilai_kriteria_klasterisasi')->insertBatch([
            // Pasar Gede
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '001',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '001',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '001',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '001',
                'nilai' => 10,
            ],

            // Gelabo
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '002',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '002',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '002',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '002',
                'nilai' => 8,
            ],

            // Pracima Tuin
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '003',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '003',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '003',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '003',
                'nilai' => 10,
            ],

            // Ono Solo Ngarsopuro
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '004',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '004',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '004',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '004',
                'nilai' => 10,
            ],

            // Kusumasari
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '005',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '005',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '005',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '005',
                'nilai' => 10,
            ],

            // Kuliner Balong-Jagalan
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '006',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '006',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '006',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '006',
                'nilai' => 8,
            ],

            // Kuliner Gajahan
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '007',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '007',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '007',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '007',
                'nilai' => 7,
            ],

            // Selat Mbak Lies
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '008',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '008',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '008',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '008',
                'nilai' => 8,
            ],

            // Sate Kambing Pak Manto
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '009',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '009',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '009',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '009',
                'nilai' => 8,
            ],

            // Kuliner Notosuman
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '010',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '010',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '010',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '010',
                'nilai' => 8,
            ],

            // Kuliner Keprabon
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '011',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '011',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '011',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '011',
                'nilai' => 8,
            ],

            // Kawasan Manahan
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '012',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '012',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '012',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '012',
                'nilai' => 7,
            ],

            // Kuliner Kota Barat
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '013',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '013',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '013',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '013',
                'nilai' => 9,
            ],

            // Pasar Klewer
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '014',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '014',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '014',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '014',
                'nilai' => 9,
            ],

            // Timlo Sastro Penumping
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '015',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '015',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '015',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '015',
                'nilai' => 9,
            ],

            // Sate Mbok Galak
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '016',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '016',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '016',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '016',
                'nilai' => 9,
            ],

            // Soto Gading
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '017',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '017',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '017',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '017',
                'nilai' => 7,
            ],

            // Es Krim Tentrem
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '018',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '018',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '018',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '018',
                'nilai' => 9,
            ],

            // Wedangan Mbah Wiryo
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '019',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '019',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '019',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '019',
                'nilai' => 8,
            ],

            // Bakmi Toprak Yu Nani
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '020',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '020',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '020',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '020',
                'nilai' => 6,
            ],

            // Sate Kere Yu Rebi
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'gastronomi_kode' => '021',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'gastronomi_kode' => '021',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'gastronomi_kode' => '021',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'gastronomi_kode' => '021',
                'nilai' => 7,
            ],
        ]);
    }
}
