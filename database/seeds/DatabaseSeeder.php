<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'usr_nombre' => 'demo',
            'usr_mail' => 'demo@demo.com',
            'usr_clave' => Hash::make('demo123')
        ]);

    }
}
