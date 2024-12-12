<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Guest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guest::factory()
        //cria , nos relacionamentos, com base na factory de cada model
        ->hasAddresses(5)//forma 1  -cria cinco enderecos para cada guest
        ->hasPhones(2) //forma 2     -cria dois phones para cada guest
        ->count(10) //faz tudo isso 10 vezes
        ->create();
    }
}
