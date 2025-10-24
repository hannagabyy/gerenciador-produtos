<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'titulo' => 'Camiseta',
            'preco' => 50.00,
            'quantidade' => 10,
            'conteudo' => 'Conteúdo do produto camiseta',
            'status' => 1,
        ]);

        Product::create([
            'titulo' => 'Livro didático',
            'preco' => 30.00,
            'quantidade' => 5,
            'conteudo' => 'Infantil',
            'status' => 1,
        ]);

        Product::create([
            'titulo' => 'Produto exemplo ',
            'preco' => 2678.00,
            'quantidade' => 5,
            'conteudo' => 'Conteúdo do produdo exemplo',
            'status' => 1,
        ]);
    }
}
