<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areaData = [
            [
                'nama_area' => 'Gubeng',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan di pusat kota Surabaya, terdapat Stasiun Gubeng dan RSUD Dr. Soetomo',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7450, -7.2500],
                        [112.7700, -7.2500],
                        [112.7700, -7.2700],
                        [112.7450, -7.2700],
                        [112.7450, -7.2500]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Wonokromo',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan di Surabaya Selatan, terdapat Kebun Binatang Surabaya',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7200, -7.2800],
                        [112.7550, -7.2800],
                        [112.7550, -7.3100],
                        [112.7200, -7.3100],
                        [112.7200, -7.2800]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Tegalsari',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan di pusat kota Surabaya, kawasan bisnis dan perkantoran',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7200, -7.2550],
                        [112.7450, -7.2550],
                        [112.7450, -7.2800],
                        [112.7200, -7.2800],
                        [112.7200, -7.2550]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Genteng',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan pusat perdagangan, terdapat Tunjungan Plaza',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7350, -7.2400],
                        [112.7600, -7.2400],
                        [112.7600, -7.2600],
                        [112.7350, -7.2600],
                        [112.7350, -7.2400]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Sukolilo',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan di Surabaya Timur, terdapat ITS dan UNAIR',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7750, -7.2650],
                        [112.8100, -7.2650],
                        [112.8100, -7.3000],
                        [112.7750, -7.3000],
                        [112.7750, -7.2650]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Sawahan',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan di Surabaya Barat, kawasan perumahan padat',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7000, -7.2600],
                        [112.7300, -7.2600],
                        [112.7300, -7.2900],
                        [112.7000, -7.2900],
                        [112.7000, -7.2600]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Bubutan',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan Bubutan di pusat kota Surabaya',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7300, -7.2400],
                        [112.7500, -7.2400],
                        [112.7500, -7.2600],
                        [112.7300, -7.2600],
                        [112.7300, -7.2400]
                    ]]
                ])
            ],
            [
                'nama_area' => 'Rungkut',
                'tipe_area' => 'Kecamatan',
                'deskripsi' => 'Kecamatan Rungkut, kawasan industri Surabaya Timur',
                'polygon_json' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [112.7700, -7.3000],
                        [112.8000, -7.3000],
                        [112.8000, -7.3300],
                        [112.7700, -7.3300],
                        [112.7700, -7.3000]
                    ]]
                ])
            ]
        ];

        foreach ($areaData as $area) {
            Area::create($area);
        }
    }
}

