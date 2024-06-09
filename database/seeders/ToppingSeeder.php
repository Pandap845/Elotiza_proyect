<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topping;

class ToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $toppings = [
            ['nombre' => 'Crema', 'precio' => 5.00, 'imagen' => '/storage/images/Crema.jpg', 'cantidad' => 10],
            ['nombre' => 'Esquite', 'precio' => 10.00, 'imagen' => '/storage/images/Esquite.jpg','cantidad' => 10],
            ['nombre' => 'Mantequilla', 'precio' => 3.00, 'imagen' => '/storage/images/Mantequilla.jpg','cantidad' => 10],
            ['nombre' => 'Mayonesa', 'precio' => 4.00, 'imagen' => '/storage/images/Mayonesa.jpg','cantidad' => 10],
            ['nombre' => 'Queso', 'precio' => 7.00, 'imagen' => '/storage/images/Queso.jpg','cantidad' => 10],
            ['nombre' => 'Sal', 'precio' => 1.00, 'imagen' => '/storage/images/Sal.jpg','cantidad' => 10],
            ['nombre' => 'Salsa de verdad', 'precio' => 2.00, 'imagen' => '/storage/images/Salsadeverdad.jpg','cantidad' => 10],
            ['nombre' => 'Salsa que no pica', 'precio' => 2.00, 'imagen' => '/storage/images/Salsaquenopica.jpg','cantidad' => 10],
            // Agrega más toppings según sea necesario
        ];

        foreach ($toppings as $topping) {
            Topping::create($topping);
        }
    }
}
