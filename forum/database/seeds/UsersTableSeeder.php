<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user 1
        DB::table('users')->insert([
            'first_name' => 'Armine',
            'last_name' => 'Khachatryan',
            'username' => 'armine',
            'email' => 'armine@gmail.com',
            'password' => bcrypt('secret'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('user_roles')->insert([
            'user_id' => '1',
            'role' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('biographies')->insert([
            'user_id' => '1',
            'description' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        // user 2
        DB::table('users')->insert([
            'first_name' => 'Lily',
            'last_name' => 'Mily',
            'username' => 'lily',
            'email' => 'lily@gmail.com',
            'password' => bcrypt('secret'),
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('user_roles')->insert([
            'user_id' => '2',
            'role' => '0',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('biographies')->insert([
            'user_id' => '2',
            'description' => '',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
    }
}
