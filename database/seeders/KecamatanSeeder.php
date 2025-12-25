<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = [
            ['nama_kecamatan' => 'Asemrowo', 'deskripsi' => 'Kecamatan Asemrowo'],
            ['nama_kecamatan' => 'Benowo', 'deskripsi' => 'Kecamatan Benowo'],
            ['nama_kecamatan' => 'Bubutan', 'deskripsi' => 'Kecamatan Bubutan'],
            ['nama_kecamatan' => 'Bulak', 'deskripsi' => 'Kecamatan Bulak'],
            ['nama_kecamatan' => 'Dukuh Pakis', 'deskripsi' => 'Kecamatan Dukuh Pakis'],
            ['nama_kecamatan' => 'Gayungan', 'deskripsi' => 'Kecamatan Gayungan'],
            ['nama_kecamatan' => 'Genteng', 'deskripsi' => 'Kecamatan Genteng'],
            ['nama_kecamatan' => 'Gubeng', 'deskripsi' => 'Kecamatan Gubeng'],
            ['nama_kecamatan' => 'Gunung Anyar', 'deskripsi' => 'Kecamatan Gunung Anyar'],
            ['nama_kecamatan' => 'Jambangan', 'deskripsi' => 'Kecamatan Jambangan'],
            ['nama_kecamatan' => 'Karang Pilang', 'deskripsi' => 'Kecamatan Karang Pilang'],
            ['nama_kecamatan' => 'Kenjeran', 'deskripsi' => 'Kecamatan Kenjeran'],
            ['nama_kecamatan' => 'Krembangan', 'deskripsi' => 'Kecamatan Krembangan'],
            ['nama_kecamatan' => 'Lakarsantri', 'deskripsi' => 'Kecamatan Lakarsantri'],
            ['nama_kecamatan' => 'Mulyorejo', 'deskripsi' => 'Kecamatan Mulyorejo'],
            ['nama_kecamatan' => 'Pabean Cantian', 'deskripsi' => 'Kecamatan Pabean Cantian'],
            ['nama_kecamatan' => 'Pakal', 'deskripsi' => 'Kecamatan Pakal'],
            ['nama_kecamatan' => 'Rungkut', 'deskripsi' => 'Kecamatan Rungkut'],
            ['nama_kecamatan' => 'Sambikerep', 'deskripsi' => 'Kecamatan Sambikerep'],
            ['nama_kecamatan' => 'Sawahan', 'deskripsi' => 'Kecamatan Sawahan'],
            ['nama_kecamatan' => 'Semampir', 'deskripsi' => 'Kecamatan Semampir'],
            ['nama_kecamatan' => 'Simokerto', 'deskripsi' => 'Kecamatan Simokerto'],
            ['nama_kecamatan' => 'Sukolilo', 'deskripsi' => 'Kecamatan Sukolilo'],
            ['nama_kecamatan' => 'Sukomanunggal', 'deskripsi' => 'Kecamatan Sukomanunggal'],
            ['nama_kecamatan' => 'Tambaksari', 'deskripsi' => 'Kecamatan Tambaksari'],
            ['nama_kecamatan' => 'Tandes', 'deskripsi' => 'Kecamatan Tandes'],
            ['nama_kecamatan' => 'Tegalsari', 'deskripsi' => 'Kecamatan Tegalsari'],
            ['nama_kecamatan' => 'Tenggilis Mejoyo', 'deskripsi' => 'Kecamatan Tenggilis Mejoyo'],
            ['nama_kecamatan' => 'Wiyung', 'deskripsi' => 'Kecamatan Wiyung'],
            ['nama_kecamatan' => 'Wonocolo', 'deskripsi' => 'Kecamatan Wonocolo'],
            ['nama_kecamatan' => 'Wonokromo', 'deskripsi' => 'Kecamatan Wonokromo']
        ];

        foreach ($kecamatans as $kecamatan) {
            Kecamatan::create($kecamatan);
        }
    }
}
