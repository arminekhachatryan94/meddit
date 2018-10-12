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

        factory(App\User::class, 5)->create()->each(function($u) {
            factory(App\UserRole::class, 1)->create(['user_id' => $u->id]);
            factory(App\Biography::class, 1)->create(['user_id' => $u->id]);
        });
    }
}
