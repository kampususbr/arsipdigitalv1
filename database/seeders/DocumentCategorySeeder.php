<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@usbr.ac.id')->first();

        $categories = [
            [
                'name' => 'Laporan Keuangan',
                'description' => 'Dokumen laporan keuangan dan pertanggungjawaban',
                'icon' => 'fa-file-invoice-dollar',
            ],
            [
                'name' => 'Surat Masuk',
                'description' => 'Arsip surat masuk dari berbagai pihak',
                'icon' => 'fa-envelope-open',
            ],
            [
                'name' => 'Surat Keluar',
                'description' => 'Arsip surat keluar yang telah dikirim',
                'icon' => 'fa-envelope',
            ],
            [
                'name' => 'Arsip Proyek',
                'description' => 'Dokumentasi proyek dan hasil kegiatan',
                'icon' => 'fa-folder-open',
            ],
            [
                'name' => 'Peraturan & Kebijakan',
                'description' => 'Peraturan, kebijakan, dan standar operasional',
                'icon' => 'fa-gavel',
            ],
            [
                'name' => 'Notulen Rapat',
                'description' => 'Catatan hasil rapat dan kesimpulannya',
                'icon' => 'fa-notes-medical',
            ],
            [
                'name' => 'Laporan Akademik',
                'description' => 'Laporan akademik dan pembelajaran',
                'icon' => 'fa-graduation-cap',
            ],
            [
                'name' => 'Sertifikat & Penghargaan',
                'description' => 'Dokumen sertifikat dan penghargaan',
                'icon' => 'fa-certificate',
            ],
        ];

        foreach ($categories as $category) {
            DocumentCategory::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'icon' => $category['icon'],
                    'status' => 'active',
                    'sort_order' => 0,
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}
