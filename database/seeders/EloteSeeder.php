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
            ['nombre' => 'Elote Cocido', 'precio' => 20.00, 'imagen' => 'images/Cocido.jpg'],
            ['nombre' => 'Elote Hervido', 'precio' => 25.00, 'imagen' => 'images/Hervido.jpg'],
            ['nombre' => 'Esquite', 'precio' => 30.00, 'imagen' => 'images/Esquite.jpg']
            
            
        ];

        foreach ($elotes as $elote) {
            Elote::create($elote);
        }
    }
}
