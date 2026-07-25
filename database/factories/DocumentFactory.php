<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'category_id' => DocumentCategory::inRandomOrder()->first()?->id ?? 1,
            'work_unit_id' => WorkUnit::inRandomOrder()->first()?->id,
            'file_name' => $this->faker->fileName() . '.pdf',
            'file_path' => 'documents/' . Str::random(10) . '.pdf',
            'file_type' => 'application/pdf',
            'file_size' => $this->faker->numberBetween(100000, 5000000),
            'document_number' => 'DOC-' . $this->faker->year() . '-' . $this->faker->randomNumber(5),
            'document_date' => $this->faker->dateTimeThisYear(),
            'created_by' => User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['admin', 'manager', 'user']);
            })->inRandomOrder()->first()?->id ?? 1,
            'visibility' => $this->faker->randomElement(['public', 'restricted', 'private']),
            'download_count' => $this->faker->numberBetween(0, 100),
            'view_count' => $this->faker->numberBetween(0, 500),
        ];
    }
}
