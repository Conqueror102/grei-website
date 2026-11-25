<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Property;
use App\Models\Stay;
use Illuminate\Database\Seeder;

/**
 * Sample content so every page has something to show. All names, locations,
 * prices and descriptions are placeholders for GREI to replace. Images are
 * Unsplash photo ids (free under the Unsplash License).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (require __DIR__.'/data/properties.php' as $i => $row) {
            Property::updateOrCreate(['slug' => $row['slug']], $row + ['sort' => $i]);
        }
        foreach (require __DIR__.'/data/projects.php' as $i => $row) {
            Project::updateOrCreate(['slug' => $row['slug']], $row + ['sort' => $i]);
        }
        foreach (require __DIR__.'/data/stays.php' as $i => $row) {
            Stay::updateOrCreate(['slug' => $row['slug']], $row + ['sort' => $i]);
        }
    }
}
