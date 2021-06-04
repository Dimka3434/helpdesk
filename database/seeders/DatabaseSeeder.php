<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $categoriesStructurePath = database_path('seeders/categories.json');
        $categoriesData = json_decode(file_get_contents($categoriesStructurePath), true);

        foreach ($categoriesData as $category => $subcategories) {
            $categoryTitle = Str::ucfirst(
                Str::lower($category)
            );
            $category = Category::create([
                'title' => $categoryTitle,
            ]);

            foreach ($subcategories as $subcategory) {
                $subcategoryTitle = Str::ucfirst(
                    Str::lower($subcategory)
                );
                $category->subcategories()->create([
                    'title' => $subcategoryTitle,
                ]);
            }
        }

        User::create([
            'name' => 'Диспетчер',
            'email' => 'admin@admin.ru',
            'password' => Hash::make('111111'),
            'type' => User::TYPE_DISPATCHER,
        ]);
    }
}
