<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRestOfCitiesSeeder extends Seeder
{
    public function run()
    {
        DB::table('cities_pk')->insertOrIgnore([
            'id' => 9999,
            'name' => 'Rest of Cities',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

