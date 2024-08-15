<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert(
            [
                [
                    'nombre' => 'Ropa',
                    'descripcion' => 'Ropa a buen precio y de calidad'
                ],
                [
                    'nombre' => 'Electronica',
                    'descripcion' => 'Articulos electronicos para telefonos, computadoras, etc'
                ]
            ]
        );
    }
}
