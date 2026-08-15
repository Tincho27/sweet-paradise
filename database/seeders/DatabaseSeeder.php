<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sweetparadise.test'],
            [
                'name' => 'Admin',
                'lastname' => 'Admin',
                'phone' => '+54 9 11 5555-1234',
                'email_verified_at' => now(),
                'password' => '12345678',
                'is_admin' => true,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'tortas'],
            ['nombre' => 'Tortas', 'orden' => 1, 'activo' => true]
        );

        $tartas = Category::updateOrCreate(
            ['slug' => 'tartas'],
            ['nombre' => 'Tartas', 'orden' => 2, 'activo' => true]
        );

        $minis = Category::updateOrCreate(
            ['slug' => 'minis'],
            ['nombre' => 'Minis', 'orden' => 3, 'activo' => true]
        );

        $shots = Category::updateOrCreate(
            ['slug' => 'shots'],
            ['nombre' => 'Shots', 'orden' => 4, 'activo' => true]
        );

        Category::updateOrCreate(
            ['slug' => 'promociones'],
            ['nombre' => 'Promociones', 'orden' => 5, 'activo' => true]
        );

        $products = [
            [
                'nombre' => 'Alfajores',
                'category_id' => $minis->id,
                'descripcion' => 'Caja surtida de alfajores premium.',
                'image' => 'images/alfajores.jpg',
                'variants' => [
                    ['nombre' => 'Chica', 'descripcion' => 'Caja chica de 8 alfajores.', 'precio' => 14900, 'stock' => 20, 'sku' => 'SP-ALF-CH'],
                    ['nombre' => 'Mediana', 'descripcion' => 'Caja mediana de 12 alfajores.', 'precio' => 18900, 'stock' => 20, 'sku' => 'SP-ALF-MD'],
                    ['nombre' => 'Grande', 'descripcion' => 'Caja grande de 16 alfajores.', 'precio' => 22900, 'stock' => 20, 'sku' => 'SP-ALF-GR'],
                ],
            ],
            [
                'nombre' => 'Tartas',
                'category_id' => $tartas->id,
                'descripcion' => 'Tarta frutal con crema pastelera y frutas frescas.',
                'image' => 'images/tartas.jpg',
                'variants' => [
                    ['nombre' => 'Chica', 'descripcion' => 'Tarta chica de 20 cm.', 'precio' => 17900, 'stock' => 20, 'sku' => 'SP-TAR-CH'],
                    ['nombre' => 'Mediana', 'descripcion' => 'Tarta mediana de 24 cm.', 'precio' => 23900, 'stock' => 20, 'sku' => 'SP-TAR-MD'],
                    ['nombre' => 'Grande', 'descripcion' => 'Tarta grande de 28 cm.', 'precio' => 29900, 'stock' => 20, 'sku' => 'SP-TAR-GR'],
                ],
            ],
            [
                'nombre' => 'Shots',
                'category_id' => $shots->id,
                'descripcion' => 'Shots dulces individuales para eventos.',
                'image' => 'images/shots.jpg',
                'variants' => [
                    ['nombre' => 'Chica', 'descripcion' => 'Vaso chico con 6 shots individuales.', 'precio' => 15900, 'stock' => 20, 'sku' => 'SP-SHO-CH'],
                    ['nombre' => 'Mediana', 'descripcion' => 'Vaso mediano con 10 shots individuales.', 'precio' => 21900, 'stock' => 20, 'sku' => 'SP-SHO-MD'],
                    ['nombre' => 'Grande', 'descripcion' => 'Vaso grande con 15 shots individuales.', 'precio' => 28900, 'stock' => 20, 'sku' => 'SP-SHO-GR'],
                ],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'category_id' => $data['category_id'],
                    'descripcion' => $data['descripcion'],
                    'destacado_home' => true,
                    'promo' => false,
                    'activo' => true,
                ]
            );

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'url' => $data['image']],
                ['orden' => 1]
            );

            foreach ($data['variants'] as $variant) {
                ProductVariant::updateOrCreate(
                    ['sku' => $variant['sku']],
                    [
                        'product_id' => $product->id,
                        'nombre' => $variant['nombre'],
                        'descripcion' => $variant['descripcion'],
                        'precio' => $variant['precio'],
                        'stock' => $variant['stock'],
                        'activo' => true,
                    ]
                );
            }
        }

        $settings = [
            'direccion' => 'Dirección a confirmar',
            'whatsapp' => '515181581516',
            'ciudad_contacto' => 'Mar del Plata, Buenos Aires',
            'telefono_contacto' => '+54 11 5555-4444',
            'alias' => 'sweet.paradise',
            'cbu' => '0000003100000000000000',
            'titular' => 'Sweet Paradise',
            'instagram' => '@sweetparadise',
            'instagram_url' => 'https://www.instagram.com/sweetparadise.azul/',
            'email_contacto' => 'contacto@sweetparadise.com',
            'nosotros_titulo' => '¿Por qué elegirnos?',
            'nosotros_personalizacion' => 'Cada pedido es único.',
            'nosotros_delivery' => 'Entregas rápidas y seguras.',
            'nosotros_calidad' => 'Ingredientes seleccionados.',
            'nosotros_experiencia' => 'Cientos de clientes felices.',
            'opinion_1_texto' => 'La torta quedó increíble y superó nuestras expectativas.',
            'opinion_1_autor' => 'María G.',
            'opinion_2_texto' => 'Excelente atención y productos deliciosos.',
            'opinion_2_autor' => 'Juan P.',
            'opinion_3_texto' => 'Los cupcakes fueron un éxito en el evento.',
            'opinion_3_autor' => 'Sofía R.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'tipo' => 'texto']
            );
        }
    }
}
