<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Elote;
class EloteSeeder extends Seeder
{

//Elotes 
    public function run()
    {

        //Elotes de ejemplo
        $elotes = [
            ['nombre' => 'Elote Cocido', 'precio' => 20.00, 'imagen' => '/storage/images/Cocido.jpg', 'cantidad' => 10],
            ['nombre' => 'Elote Hervido', 'precio' => 25.00, 'imagen' => '/storage/images/Hervido.jpg','cantidad' => 10],
            ['nombre' => 'Esquite', 'precio' => 30.00, 'imagen' => '/storage/images/Esquite.jpg','cantidad' => 10]
            
            
        ];

        foreach ($elotes as $elote) {
            Elote::create($elote);
        }
    }
}
