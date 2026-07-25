<?php

namespace Database\Seeders;

use App\Models\WorkUnit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@usbr.ac.id')->first();

        $units = [
            [
                'name' => 'Rektorat',
                'description' => 'Kantor Rektorat',
                'head_name' => 'Prof. Dr. Bambang',
                'head_email' => 'rektor@usbr.ac.id',
                'phone' => '0274-511414',
            ],
            [
                'name' => 'Biro Administrasi',
                'description' => 'Biro Administrasi Akademik',
                'head_name' => 'Drs. Ahmad',
                'head_email' => 'biroakademik@usbr.ac.id',
                'phone' => '0274-511415',
            ],
            [
                'name' => 'Biro Keuangan',
                'description' => 'Biro Perencanaan dan Keuangan',
                'head_name' => 'Ir. Siti',
                'head_email' => 'birokeuangan@usbr.ac.id',
                'phone' => '0274-511416',
            ],
            [
                'name' => 'Perpustakaan',
                'description' => 'Pusat Perpustakaan',
                'head_name' => 'Nur Hidayah, S.Pd',
                'head_email' => 'perpustakaan@usbr.ac.id',
                'phone' => '0274-511417',
            ],
            [
                'name' => 'Pusat Teknologi Informasi',
                'description' => 'Pusat Teknologi Informasi dan Komunikasi',
                'head_name' => 'Supriyanto, S.Kom',
                'head_email' => 'pti@usbr.ac.id',
                'phone' => '0274-511418',
            ],
        ];

        foreach ($units as $unit) {
            WorkUnit::firstOrCreate(
                ['slug' => Str::slug($unit['name'])],
                [
                    'name' => $unit['name'],
                    'description' => $unit['description'],
                    'head_name' => $unit['head_name'],
                    'head_email' => $unit['head_email'],
                    'phone' => $unit['phone'],
                    'status' => 'active',
                    'sort_order' => 0,
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
