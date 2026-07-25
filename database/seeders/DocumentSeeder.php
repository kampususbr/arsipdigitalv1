<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\WorkUnit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@usbr.ac.id')->first();
        $manager = User::where('email', 'manager@usbr.ac.id')->first();
        $user = User::where('email', 'user@usbr.ac.id')->first();

        $categories = DocumentCategory::all();
        $units = WorkUnit::all();

        if ($categories->isEmpty()) return;
        if ($units->isEmpty()) return;

        // Create sample documents for testing
        for ($i = 1; $i <= 20; $i++) {
            Document::factory()->create([
                'category_id' => $categories->random()->id,
                'work_unit_id' => $units->random()->id,
                'created_by' => [$admin->id, $manager->id, $user->id][array_rand([$admin->id, $manager->id, $user->id])],
                'visibility' => ['public', 'restricted', 'private'][array_rand(['public', 'restricted', 'private'])],
            ]);
        }
    }
}
