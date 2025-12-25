<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ObjekPoint;
use App\Models\Kategori;
use App\Models\Kecamatan;

class ObjekPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get kategori dan kecamatan IDs
        $rsId = Kategori::where('nama_kategori', 'Rumah Sakit')->first()->id;
        $puskesmasId = Kategori::where('nama_kategori', 'Puskesmas')->first()->id;
        $klinikId = Kategori::where('nama_kategori', 'Klinik')->first()->id;
        $apotekId = Kategori::where('nama_kategori', 'Apotek')->first()->id;
        
        $gubengId = Kecamatan::where('nama_kecamatan', 'Gubeng')->first()->id;
        $sukoliloId = Kecamatan::where('nama_kecamatan', 'Sukolilo')->first()->id;
        $mulyorejoId = Kecamatan::where('nama_kecamatan', 'Mulyorejo')->first()->id;
        $rungkutId = Kecamatan::where('nama_kecamatan', 'Rungkut')->first()->id;
        $tegalsariId = Kecamatan::where('nama_kecamatan', 'Tegalsari')->first()->id;
        
        $objekPoints = [
            // Rumah Sakit
            [
                'nama_objek' => 'RSU Dr. Soetomo',
                'kategori_id' => $rsId,
                'latitude' => -7.2656,
                'longitude' => 112.7520,
                'deskripsi' => 'Rumah Sakit Umum Dr. Soetomo adalah rumah sakit rujukan nasional',
                'kecamatan_id' => $gubengId,
                'alamat' => 'Jl. Mayjen Prof. Dr. Moestopo No.6-8, Airlangga, Gubeng',
                'telepon' => '031-5501078'
            ],
            [
                'nama_objek' => 'RS Universitas Airlangga',
                'kategori_id' => $rsId,
                'latitude' => -7.2696,
                'longitude' => 112.7189,
                'deskripsi' => 'Rumah Sakit Pendidikan Universitas Airlangga',
                'kecamatan_id' => $mulyorejoId,
                'alamat' => 'Jl. Mayjen Prof. Dr. Moestopo No.47, Mulyorejo',
                'telepon' => '031-5916290'
            ],
            [
                'nama_objek' => 'RS Premier Surabaya',
                'kategori_id' => $rsId,
                'latitude' => -7.3240,
                'longitude' => 112.7677,
                'deskripsi' => 'Rumah Sakit Swasta dengan Fasilitas Lengkap',
                'kecamatan_id' => $rungkutId,
                'alamat' => 'Jl. Nginden Intan Barat Blok B, Rungkut',
                'telepon' => '031-8790700'
            ],
            
            // Puskesmas
            [
                'nama_objek' => 'Puskesmas Gubeng',
                'kategori_id' => $puskesmasId,
                'latitude' => -7.2650,
                'longitude' => 112.7480,
                'deskripsi' => 'Puskesmas Kecamatan Gubeng',
                'kecamatan_id' => $gubengId,
                'alamat' => 'Jl. Gubeng Kertajaya, Gubeng',
                'telepon' => '031-5021234'
            ],
            [
                'nama_objek' => 'Puskesmas Mulyorejo',
                'kategori_id' => $puskesmasId,
                'latitude' => -7.2700,
                'longitude' => 112.7200,
                'deskripsi' => 'Puskesmas Kecamatan Mulyorejo',
                'kecamatan_id' => $mulyorejoId,
                'alamat' => 'Jl. Mulyorejo Utara, Mulyorejo',
                'telepon' => '031-5920123'
            ],
            [
                'nama_objek' => 'Puskesmas Sukolilo',
                'kategori_id' => $puskesmasId,
                'latitude' => -7.2833,
                'longitude' => 112.7678,
                'deskripsi' => 'Puskesmas Kecamatan Sukolilo',
                'kecamatan_id' => $sukoliloId,
                'alamat' => 'Jl. Raya Menur, Sukolilo',
                'telepon' => '031-5931234'
            ],
            
            // Klinik
            [
                'nama_objek' => 'Klinik Pratama Galaxy',
                'kategori_id' => $klinikId,
                'latitude' => -7.2600,
                'longitude' => 112.7450,
                'deskripsi' => 'Klinik Kesehatan Umum',
                'kecamatan_id' => $gubengId,
                'alamat' => 'Jl. Dharmahusada Indah, Gubeng',
                'telepon' => '031-5941111'
            ],
            [
                'nama_objek' => 'Klinik Sejahtera Medika',
                'kategori_id' => $klinikId,
                'latitude' => -7.2750,
                'longitude' => 112.7300,
                'deskripsi' => 'Klinik 24 Jam',
                'kecamatan_id' => $mulyorejoId,
                'alamat' => 'Jl. Raya Mulyosari, Mulyorejo',
                'telepon' => '031-5982222'
            ],
            
            // Apotek
            [
                'nama_objek' => 'Apotek K24 Gubeng',
                'kategori_id' => $apotekId,
                'latitude' => -7.2630,
                'longitude' => 112.7500,
                'deskripsi' => 'Apotek 24 Jam',
                'kecamatan_id' => $gubengId,
                'alamat' => 'Jl. Gubeng Pojok, Gubeng',
                'telepon' => '031-5033333'
            ],
            [
                'nama_objek' => 'Apotek Kimia Farma ITS',
                'kategori_id' => $apotekId,
                'latitude' => -7.2820,
                'longitude' => 112.7950,
                'deskripsi' => 'Apotek di Area ITS',
                'kecamatan_id' => $sukoliloId,
                'alamat' => 'Jl. Raya ITS, Keputih, Sukolilo',
                'telepon' => '031-5994444'
            ],
            [
                'nama_objek' => 'Apotek Century Tegalsari',
                'kategori_id' => $apotekId,
                'latitude' => -7.2580,
                'longitude' => 112.7390,
                'deskripsi' => 'Apotek Modern',
                'kecamatan_id' => $tegalsariId,
                'alamat' => 'Jl. Embong Malang, Tegalsari',
                'telepon' => '031-5325555'
            ],
        ];

        foreach ($objekPoints as $point) {
            ObjekPoint::create($point);
        }
    }
}
