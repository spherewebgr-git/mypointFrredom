<?php

namespace Database\Seeders\Auth;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Σπύρος Καραγιαννης',
                'hashID' =>  Str::substr(Str::slug(Hash::make('info@sphereweb.gr'.'123Sph!@#')), 0, 32),
                'email' => 'info@sphereweb.gr',
                'password' => bcrypt('123Sph!@#'),
                'active' => true,
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Αλέξανδρος Κασσελούρης',
                'hashID' =>  Str::substr(Str::slug(Hash::make('alkasselouris@yahoo.gr'.'123Alk!@#')), 0, 32),
                'email' => 'alkasselouris@yahoo.gr',
                'password' => bcrypt('123Alk!@#'),
                'active' => true,
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('users')->insert($users);
    }
}
