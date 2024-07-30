<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            'first_name' => 'Aykhan',
            'last_name' => 'Alizada',
            'username' => 'aykhanalizada',
            'email' => 'ayxan.alizade89@gmail.com',
            'password' => Hash::make('1234'),
            'fk_id_media' => null,
            'is_admin' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
