<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++){
            $rand = rand(1,5);
            factory(App\Post::class, 1)->create(['user_id' => $rand]);
        }
    }
}
