<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class CommentsTableSeeder extends Seeder
{
    protected $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++){
            $uid = rand(1,5);
            $rand = rand(1,10);
            $comments = App\Comment::all()->pluck('id')->toArray();
            if( $rand % 2 == 0 && count($comments) > 0 ){
                $cid = array_rand($comments);
                factory(App\Comment::class, 1)->create(['user_id' => $uid], ['post_id' => NULL], ['comment_id' => $cid]);
            } else {
                factory(App\Comment::class, 1)->create(['user_id' => $uid], ['post_id' => $rand], ['comment_id' => NULL]);
            }
        }
    }
}
