<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Rumah Sakit',
                'deskripsi' => 'Rumah sakit umum dan khusus',
                'icon' => 'hospital'
            ],
            [
                'nama_kategori' => 'Puskesmas',
                'deskripsi' => 'Pusat kesehatan masyarakat',
                'icon' => 'clinic'
            ],
            [
                'nama_kategori' => 'Klinik',
                'deskripsi' => 'Klinik kesehatan swasta',
                'icon' => 'medical'
            ],
            [
                'nama_kategori' => 'Apotek',
                'deskripsi' => 'Apotek dan toko obat',
                'icon' => 'pharmacy'
            ],
            [
                'nama_kategori' => 'Lab Kesehatan',
                'deskripsi' => 'Laboratorium kesehatan',
                'icon' => 'lab'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
