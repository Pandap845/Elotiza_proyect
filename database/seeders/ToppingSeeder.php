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
            ['nombre' => 'Crema', 'precio' => 5.00, 'imagen' => 'images/Crema.jpg'],
            ['nombre' => 'Esquite', 'precio' => 10.00, 'imagen' => 'images/Esquite.jpg'],
            ['nombre' => 'Mantequilla', 'precio' => 3.00, 'imagen' => 'images/Mantequilla.jpg'],
            ['nombre' => 'Mayonesa', 'precio' => 4.00, 'imagen' => 'images/Mayonesa.jpg'],
            ['nombre' => 'Queso', 'precio' => 7.00, 'imagen' => 'images/Queso.jpg'],
            ['nombre' => 'Sal', 'precio' => 1.00, 'imagen' => 'images/Sal.jpg'],
            ['nombre' => 'Salsa de verdad', 'precio' => 2.00, 'imagen' => 'images/Salsadeverdad.jpg'],
            ['nombre' => 'Salsa que no pica', 'precio' => 2.00, 'imagen' => 'images/Salsaquenopica.jpg'],
            // Agrega más toppings según sea necesario
        ];

        foreach ($toppings as $topping) {
            Topping::create($topping);
        }
    }
}
