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

        // umkm
        $this->db->table('umkm')->insertBatch([


            [
                'kode' => '001',
                'nama' => 'UMKM Batik Solo',
                'alamat' => 'Jl. Keraton Surakarta Hadiningrat No. 1',
                'deskripsi' => 'Keraton Surakarta Hadiningrat adalah istana kerajaan yang kaya akan sejarah dan budaya Jawa.',
                'gambar' => 'keraton-surakarta.jpg',
                'latitude' => '-7.5737373',
                'longitude' => '110.825335',
                'klaster' =>  null,
            ],


            [
                'kode' => '002',
                'nama' => 'UMKM Pura Mangkunegaran',
                'alamat' => 'Jl. Pura Mangkunegaran No. 1',
                'deskripsi' => 'Pura Mangkunegaran adalah pura yang merupakan tempat tinggal keluarga kerajaan Mangkunegaran.',
                'gambar' => 'pura-mangkunegaran.jpg',
                'latitude' => '-7.5668958',
                'longitude' => '110.8203116',
                'klaster' =>  null,
            ],

            [
                'kode' => '003',
                'nama' => 'UMKM Kampung Batik Laweyan',
                'alamat' => 'Jl. Batik Laweyan No. 1',
                'deskripsi' => 'Kampung Batik Laweyan adalah kawasan yang terkenal dengan kerajinan batiknya.',
                'gambar' => 'kampung-batik-laweyan.jpg',
                'latitude' => '-7.5696487',
                'longitude' => '110.7951318',
                'klaster' =>  null,
            ],
            [
                'kode' => '004',
                'nama' => 'UMKM Masjid Agung Keraton Surakarta',
                'alamat' => 'Jl. Masjid Agung No. 1',
                'deskripsi' => 'Masjid Agung Keraton Surakarta adalah masjid yang terletak di kompleks Keraton Surakarta.',
                'gambar' => 'masjid-agung-keraton-surakarta.jpg',
                'latitude' => '-7.574398',
                'longitude' => '110.8240187',
                'klaster' =>  null,
            ],
            [
                'kode' => '005',
                'nama' => 'UMKM Taman Balekambang',
                'alamat' => 'Jl. Taman Balekambang No. 1',
                'deskripsi' => 'Taman Balekambang adalah taman kota yang indah dan cocok untuk bersantai.',
                'gambar' => 'taman-balekambang.jpg',
                'latitude' => '-7.5523052',
                'longitude' => 110.8050936,
                'klaster' =>  null,
            ],
            [
                'kode' => "006",
                "nama" => "UMKM Solo Safari",
                "alamat" => "Jl. Solo Safari No. 1",
                "deskripsi" => "Solo Safari adalah taman safari yang menawarkan pengalaman melihat satwa liar secara langsung.",
                "gambar" => "solo-safari.jpg",
                "latitude" => "-7.5646417",
                "longitude" => "110.856022",
                'klaster' =>  null,
            ],
            [
                'kode' => "007",
                "nama" => "UMKM Taman Sriwedari",
                "alamat" => "Jl. Taman Sriwedari No. 1",
                "deskripsi" => "Taman Sriwedari adalah taman yang sering digunakan untuk pertunjukan seni dan budaya.",
                "gambar" => "taman-sriwedari.jpg",
                "latitude" => "-7.5685598",
                "longitude" => "110.8104205",
                'klaster' =>  null,
            ],
            [
                'kode' => "008",
                "nama" => "UMKM The Heritage Palace",
                "alamat" => "Jl. The Heritage Palace No. 1",
                "deskripsi" => "The Heritage Palace adalah museum yang menampilkan koleksi seni dan budaya Jawa.",
                "gambar" => "the-heritage-palace.jpg",
                "latitude" => "-7.5547544",
                "longitude" => "110.7522454",
                'klaster' =>  null,
            ],
            [
                'kode' => "009",
                "nama" => "UMKM Tumurun Private Museum",
                "alamat" => "Jl. Tumurun No. 1",
                "deskripsi" => "Tumurun Private Museum adalah museum pribadi yang menyimpan koleksi seni yang berharga.",
                "gambar" => "tumurun-private-museum.jpg",
                "latitude" => "-7.5704012",
                "longitude" => "110.8138152",
                'klaster' =>  null,
            ],
            [
                'kode' => '010',
                'nama' => 'UMKM Masjid Raya Sheikh Zayed',
                'alamat' => 'Jl. Masjid Raya Sheikh Zayed No. 1',
                'deskripsi' => 'Masjid Raya Sheikh Zayed adalah masjid megah yang menjadi salah satu ikon kota.',
                'gambar' => 'masjid-raya-sheikh-zayed.jpg',
                'latitude' => '-7.5547278',
                'longitude' => '110.8241381',
                'klaster' =>  null,
            ],

        ]);


        $this->db->table('kriteria_klasterisasi')->insertBatch([
            [
                'kode' => 'K001',
                'nama' => 'Omset',
                'deskripsi' => 'Pendapatan usaha dalam juta rupiah per bulan',
            ],
            [
                'kode' => 'K002',
                'nama' => 'Modal Awal',
                'deskripsi' => 'Jumlah modal awal dalam juta rupiah',
            ],
            [
                'kode' => 'K003',
                'nama' => 'Akses Pembiayaan',
                'deskripsi' => 'Tingkat akses terhadap pembiayaan (skala 1-5)',
            ],
            [
                'kode' => 'K004',
                'nama' => 'Biaya Sertifikasi',
                'deskripsi' => 'Biaya untuk proses sertifikasi dalam juta rupiah',
            ],
            [
                'kode' => 'K005',
                'nama' => 'Skala Produksi',
                'deskripsi' => 'Jumlah unit yang diproduksi per bulan',
            ],
            [
                'kode' => 'K006',
                'nama' => 'Tenaga Kerja',
                'deskripsi' => 'Jumlah tenaga kerja yang dimiliki',
            ],
            [
                'kode' => 'K007',
                'nama' => 'Teknologi',
                'deskripsi' => 'Tingkat penggunaan teknologi (skala 1-5)',
            ],
            [
                'kode' => 'K008',
                'nama' => 'Segmen Pasar',
                'deskripsi' => 'Kekuatan segmen pasar (skala 1-5)',
            ],
            [
                'kode' => 'K009',
                'nama' => 'Distribusi',
                'deskripsi' => 'Kemampuan distribusi produk (skala 1-5)',
            ],
            [
                'kode' => 'K010',
                'nama' => 'Jangkauan Pasar',
                'deskripsi' => 'Luas jangkauan pasar (skala 1-5)',
            ],
            [
                'kode' => 'K011',
                'nama' => 'Sistem Jaminan Halal',
                'deskripsi' => 'Kualitas sistem jaminan halal (skala 1-5)',
            ],
            [
                'kode' => 'K012',
                'nama' => 'Pemahaman Regulasi',
                'deskripsi' => 'Tingkat pemahaman terhadap regulasi (skala 1-5)',
            ],
        ]);

        $this->db->table('nilai_kriteria_klasterisasi')->insertBatch([
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '001',
                'nilai' => 50,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '001',
                'nilai' => 20,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '001',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '001',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '001',
                'nilai' => 100,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '001',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '001',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '001',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '001',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '001',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '001',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '001',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '002',
                'nilai' => 60,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '002',
                'nilai' => 30,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '002',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '002',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '002',
                'nilai' => 150,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '002',
                'nilai' => 15,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '002',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '002',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '002',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '002',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '002',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '002',
                'nilai' => 5,
            ],

            // UMKM 003 - Kampung Batik Laweyan
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '003',
                'nilai' => 45,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '003',
                'nilai' => 15,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '003',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '003',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '003',
                'nilai' => 120,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '003',
                'nilai' => 12,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '003',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '003',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '003',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '003',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '003',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '003',
                'nilai' => 3,
            ],

            // UMKM 004 - Masjid Agung Keraton Surakarta
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '004',
                'nilai' => 35,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '004',
                'nilai' => 25,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '004',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '004',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '004',
                'nilai' => 80,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '004',
                'nilai' => 8,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '004',
                'nilai' => 2,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '004',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '004',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '004',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '004',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '004',
                'nilai' => 4,
            ],

            // UMKM 005 - Taman Balekambang
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '005',
                'nilai' => 25,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '005',
                'nilai' => 10,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '005',
                'nilai' => 2,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '005',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '005',
                'nilai' => 50,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '005',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '005',
                'nilai' => 2,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '005',
                'nilai' => 2,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '005',
                'nilai' => 2,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '005',
                'nilai' => 2,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '005',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '005',
                'nilai' => 2,
            ],

            // UMKM 006 - Solo Safari
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '006',
                'nilai' => 80,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '006',
                'nilai' => 50,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '006',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '006',
                'nilai' => 15,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '006',
                'nilai' => 200,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '006',
                'nilai' => 25,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '006',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '006',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '006',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '006',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '006',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '006',
                'nilai' => 5,
            ],

            // UMKM 007 - Taman Sriwedari
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '007',
                'nilai' => 40,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '007',
                'nilai' => 18,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '007',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '007',
                'nilai' => 6,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '007',
                'nilai' => 90,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '007',
                'nilai' => 7,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '007',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '007',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '007',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '007',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '007',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '007',
                'nilai' => 3,
            ],

            // UMKM 008 - The Heritage Palace
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '008',
                'nilai' => 70,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '008',
                'nilai' => 40,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '008',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '008',
                'nilai' => 12,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '008',
                'nilai' => 180,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '008',
                'nilai' => 20,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '008',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '008',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '008',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '008',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '008',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '008',
                'nilai' => 4,
            ],

            // UMKM 009 - Tumurun Private Museum
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '009',
                'nilai' => 55,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '009',
                'nilai' => 35,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '009',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '009',
                'nilai' => 9,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '009',
                'nilai' => 140,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '009',
                'nilai' => 18,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '009',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '009',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '009',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '009',
                'nilai' => 3,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '009',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '009',
                'nilai' => 3,
            ],

            // UMKM 010 - Masjid Raya Sheikh Zayed
            [
                'kriteria_klasterisasi_kode' => 'K001',
                'umkm_kode' => '010',
                'nilai' => 65,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K002',
                'umkm_kode' => '010',
                'nilai' => 45,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K003',
                'umkm_kode' => '010',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K004',
                'umkm_kode' => '010',
                'nilai' => 12,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K005',
                'umkm_kode' => '010',
                'nilai' => 170,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K006',
                'umkm_kode' => '010',
                'nilai' => 22,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K007',
                'umkm_kode' => '010',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K008',
                'umkm_kode' => '010',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K009',
                'umkm_kode' => '010',
                'nilai' => 4,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K010',
                'umkm_kode' => '010',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K011',
                'umkm_kode' => '010',
                'nilai' => 5,
            ],
            [
                'kriteria_klasterisasi_kode' => 'K012',
                'umkm_kode' => '010',
                'nilai' => 5,
            ],
        ]);
    }
}
