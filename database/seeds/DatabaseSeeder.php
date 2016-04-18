<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Products
        DB::table('products')->insert([
            'name'          => 'Product1',
            'user_id'       => 1,
            'name'          => 'Product1',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('products')->insert([
            'name'          => 'Product2',
            'user_id'       => 1,
            'name'          => 'Product2',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('products')->insert([
            'name'          => 'Product3',
            'user_id'       => 1,
            'name'          => 'Product3',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('products')->insert([
            'name'          => 'Product4',
            'user_id'       => 1,
            'name'          => 'Product4',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('products')->insert([
            'name'          => 'Product5',
            'user_id'       => 1,
            'name'          => 'Product5',
            'ip'            => '127.0.0.1'
        ]);

        //Measures
        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Kilogram',
            'multiplier'    => '1',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Gram',
            'multiplier'    => '1000',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Milligram',
            'multiplier'    => '1000000',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Microgram',
            'multiplier'    => '1000000000',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Liter',
            'multiplier'    => '1',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Milliliter',
            'multiplier'    => '1000',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Microliter',
            'multiplier'    => '1000000',
            'ip'            => '127.0.0.1'
        ]);

        DB::table('measures')->insert([
            'user_id'       => 1,
            'name'          => 'Broi',
            'multiplier'    => '1',
            'ip'            => '127.0.0.1'
        ]);


        //USERS
        DB::table('users')->insert([
            'name'       => 'Николай',
            'email'      => 'nikolay.balkandzhiyski@gmail.com',
            'password' => bcrypt('1234123')
        ]);
    }
}
