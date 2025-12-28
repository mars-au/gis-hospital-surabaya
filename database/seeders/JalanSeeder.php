<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jalan;

class JalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jalanData = [
            [
                'nama_jalan' => 'Jl. Raya Darmo',
                'tipe_jalan' => 'Jalan Arteri',
                'deskripsi' => 'Jalan arteri utama di Surabaya Selatan menghubungkan pusat kota ke Surabaya Selatan',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7382, -7.2690],
                        [112.7380, -7.2710],
                        [112.7378, -7.2730],
                        [112.7375, -7.2750],
                        [112.7372, -7.2770],
                        [112.7369, -7.2790],
                        [112.7366, -7.2810],
                        [112.7363, -7.2830],
                        [112.7360, -7.2850],
                        [112.7357, -7.2870],
                        [112.7354, -7.2890],
                        [112.7351, -7.2910],
                        [112.7348, -7.2930],
                        [112.7345, -7.2950],
                        [112.7342, -7.2970]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Basuki Rahmat',
                'tipe_jalan' => 'Jalan Arteri',
                'deskripsi' => 'Jalan protokol utama di pusat kota Surabaya, kawasan bisnis dan perbelanjaan',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7410, -7.2620],
                        [112.7420, -7.2610],
                        [112.7430, -7.2600],
                        [112.7440, -7.2590],
                        [112.7450, -7.2580],
                        [112.7460, -7.2570],
                        [112.7470, -7.2560],
                        [112.7480, -7.2550],
                        [112.7490, -7.2540],
                        [112.7500, -7.2530],
                        [112.7510, -7.2520]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Ahmad Yani',
                'tipe_jalan' => 'Jalan Arteri',
                'deskripsi' => 'Jalan arteri primer arah Surabaya - Sidoarjo melewati Terminal Bungurasih',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7520, -7.2950],
                        [112.7525, -7.2970],
                        [112.7530, -7.2990],
                        [112.7535, -7.3010],
                        [112.7540, -7.3030],
                        [112.7545, -7.3050],
                        [112.7550, -7.3070],
                        [112.7555, -7.3090],
                        [112.7560, -7.3110],
                        [112.7565, -7.3130],
                        [112.7570, -7.3150]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Mayjen Sungkono',
                'tipe_jalan' => 'Jalan Arteri',
                'deskripsi' => 'Jalan arteri di Surabaya Barat menuju Pakuwon dan Citraland',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7100, -7.2860],
                        [112.7130, -7.2858],
                        [112.7160, -7.2856],
                        [112.7190, -7.2854],
                        [112.7220, -7.2852],
                        [112.7250, -7.2850],
                        [112.7280, -7.2848],
                        [112.7310, -7.2846],
                        [112.7340, -7.2844]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Kertajaya',
                'tipe_jalan' => 'Jalan Kolektor',
                'deskripsi' => 'Jalan kolektor Surabaya Timur menghubungkan Gubeng ke UNAIR',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7580, -7.2680],
                        [112.7610, -7.2678],
                        [112.7640, -7.2676],
                        [112.7670, -7.2674],
                        [112.7700, -7.2672],
                        [112.7730, -7.2670],
                        [112.7760, -7.2668],
                        [112.7790, -7.2666]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Pemuda',
                'tipe_jalan' => 'Jalan Arteri',
                'deskripsi' => 'Jalan protokol menuju Tugu Pahlawan dan Balai Kota Surabaya',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7400, -7.2480],
                        [112.7420, -7.2470],
                        [112.7440, -7.2460],
                        [112.7460, -7.2450],
                        [112.7480, -7.2440],
                        [112.7500, -7.2430],
                        [112.7520, -7.2420],
                        [112.7540, -7.2410]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Dr. Soetomo',
                'tipe_jalan' => 'Jalan Kolektor',
                'deskripsi' => 'Jalan menuju RSUD Dr. Soetomo, rumah sakit terbesar di Surabaya',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7550, -7.2580],
                        [112.7560, -7.2590],
                        [112.7570, -7.2600],
                        [112.7580, -7.2610],
                        [112.7590, -7.2620],
                        [112.7600, -7.2630],
                        [112.7610, -7.2640]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Diponegoro',
                'tipe_jalan' => 'Jalan Kolektor',
                'deskripsi' => 'Jalan kolektor kawasan Tegalsari dan Darmo',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7320, -7.2680],
                        [112.7330, -7.2700],
                        [112.7340, -7.2720],
                        [112.7350, -7.2740],
                        [112.7360, -7.2760],
                        [112.7370, -7.2780]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Raya Gubeng',
                'tipe_jalan' => 'Jalan Kolektor',
                'deskripsi' => 'Jalan utama di kawasan Gubeng menuju Stasiun Gubeng',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7520, -7.2650],
                        [112.7540, -7.2640],
                        [112.7560, -7.2630],
                        [112.7580, -7.2620],
                        [112.7600, -7.2610],
                        [112.7620, -7.2600]
                    ]
                ])
            ],
            [
                'nama_jalan' => 'Jl. Wonokromo',
                'tipe_jalan' => 'Jalan Kolektor',
                'deskripsi' => 'Jalan utama kawasan Wonokromo dekat Kebun Binatang Surabaya',
                'koordinat_json' => json_encode([
                    'type' => 'LineString',
                    'coordinates' => [
                        [112.7380, -7.2920],
                        [112.7400, -7.2930],
                        [112.7420, -7.2940],
                        [112.7440, -7.2950],
                        [112.7460, -7.2960],
                        [112.7480, -7.2970]
                    ]
                ])
            ]
        ];

        foreach ($jalanData as $jalan) {
            Jalan::create($jalan);
        }
    }
}

