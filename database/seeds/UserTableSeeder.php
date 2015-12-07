<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
            DB::table('users')->insert([
                'name' => 'Javier Jesús Alvarez Montenegro',
                'email' => 'jalvarez@honeysoft.pe',
                'password' => bcrypt('root'),
                'estado' => 1,
                'role_id' => 1,
                'store_id' => 1,
                'image' => '/images/users/default.jpg',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);


            DB::table('users')->insert([
                'name' => 'soporte',
                'email' => 'soporte@honeysoft.pe',
                'password' => bcrypt('soporte'),
                'estado' => 1,
                'role_id' => 1,
                'store_id' => 1,
                'image' => '/images/users/default.jpg',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);

            DB::table('users')->insert([
                'name' => 'Usuario Pirkas',
                'email' => 'pirkas@pirkas.com.pe',
                'password' => bcrypt('123456'),
                'estado' => 1,
                'role_id' => 1,
                'store_id' => 1,
                'image' => '/images/users/default.jpg',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);


    }
}
