<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Arsip',
                'password' => Hash::make('0000'),
            ]
        );

        $data = [
            'Bacukiki' => [
                'Lompoe' => '1004',
                'Watang Bacukiki' => '1005',
                'Lemoe' => '1009',
                'Galung Maloang' => '1010',
            ],
            'Ujung' => [
                'Labukkang' => '1001',
                'Ujung Sabbang' => '1002',
                'Ujung Bulu' => '1003',
                'Lapadde' => '1004',
                'Mallusetasi' => '1005',
            ],
            'Soreang' => [
                'Lakessi' => '1001',
                'Ujung Baru' => '1002',
                'Watang Soreang' => '1003',
                'Kampung Pisang' => '1004',
                'Ujung Lare' => '1005',
                'Bukit Indah' => '1006',
                'Bukit Harapan' => '1007',
            ],
            'Bacukiki Barat' => [
                'Kampung Baru' => '1001',
                'Cappa Galung' => '1002',
                'Lumpue' => '1003',
                'Tiro Sompe' => '1004',
                'Sumpang Minangae' => '1005',
                'Bumi Harapan' => '1006',
            ],
        ];

        foreach ($data as $kecamatanName => $kelurahans) {
            $kecamatan = Kecamatan::firstOrCreate(['name' => $kecamatanName]);

            foreach ($kelurahans as $kelurahanName => $code) {
                $kecamatan->kelurahans()->updateOrCreate(
                    ['name' => $kelurahanName],
                    ['code' => $code]
                );
            }
        }
    }
}
