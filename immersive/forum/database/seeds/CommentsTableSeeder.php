<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'post_id' => '1',
            'comment_id' => NULL,
            'user_id' => '2',
            'body' => 'Praesent pede quisque, iaculis quam. Cras orci cras placerat aliquam ultrices lectus, ullamcorper morbi cursus urna, molestie at elit id mauris vivamus, risus est convallis molestie tincidunt, dictumst sollicitudin eu eu quis augue libero. Felis lorem lobortis vestibulum dictum, convallis fames curabitur eget etiam ipsum sapien, pellentesque viverra fringilla vehicula gravida, ac pellentesque in. Laoreet tincidunt ligula a, maecenas proin nulla et ac dapibus laoreet, sed ornare habitasse, massa sed risus et enim nisl. Sed semper fusce, ligula rutrum pellentesque ac, suspendisse libero est facilisi duis dui, sagittis morbi, sit at unde erat quam fusce. Feugiat suscipit fermentum turpis donec, mattis eget duis scelerisque curabitur sed consectetuer. Nonummy porttitor, neque quam vulputate donec. Aliquam et gravida, sagittis odio accumsan, sed in, sit sem nec metus mattis dolor. Ipsum nullam enim nunc lorem lacinia, habitant ut, lectus viverra.',
            'belongs_to' => '1',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('comments')->insert([
            'post_id' => '1',
            'comment_id' => NULL,
            'user_id' => '2',
            'body' => 'Second comment.',
            'belongs_to' => '0',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('comments')->insert([
            'post_id' => NULL,
            'comment_id' => '1',
            'user_id' => '1',
            'body' => 'Orci vitae nulla nec, non fusce mus, duis cubilia a ullamcorper amet ac. In semper dolor suspendisse tristique sed in. Neque velit, porttitor fringilla dignissim tellus, arcu vitae ut, netus porta faucibus mattis nulla tincidunt, in netus id metus. Bibendum dolor nec eros urna, felis viverra vestibulum sodales mattis vitae, mauris luctus venenatis ac nec, rutrum fermentum. Pulvinar morbi pede sit arcu porttitor, tempus ut pellentesque quam. Nisl tellus ullamcorper integer non, urna diam donec diam lectus wisi ut, praesent donec lectus adipiscing, sociosqu arcu adipiscing in tellus quisque. Diam lorem fringilla. Suscipit urna, arcu volutpat, arcu amet amet tellus, harum leo, felis mi vel arcu. Mauris etiam dapibus, et ac, mauris gravida in varius nulla ante urna, tincidunt ut diam in, elementum turpis feugiat pellentesque magnis ut.',
            'belongs_to' => '0',
            'created_at' => Carbon::today()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::today()->format('Y-m-d H:i:s')
        ]);
        DB::table('comments')->insert([
            'post_id' => NULL,
            'comment_id' => '3',
            'user_id' => '1',
            'body' => 'Venenatis interdum odio eu euismod donec viverra, mauris orci porttitor urna ac, aliquam quis at. Congue tristique mi et wisi, ultrices nonummy eget vulputate ut elit, aenean a eu, ultricies aspernatur sed, tincidunt nullam quam viverra conubia. Justo sit, scelerisque curabitur at. Magna arcu suspendisse. Quam nihil, eu at veritatis sed nunc parturient, quam sem quisque molestie pharetra aliquid, tellus torquent pellentesque. Consectetuer habitant quia integer consectetuer dolor, lectus velit consequat et lectus, urna a, massa pellentesque lorem duis quam amet. Neque quisque sit ac erat nisl tincidunt, dui aenean facilisis, consectetuer curabitur diam sem mattis, ut interdum integer ut ac vivamus rutrum, nisi urna facilisi.',
            'belongs_to' => '0',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('comments')->insert([
            'post_id' => NULL,
            'comment_id' => '4',
            'user_id' => '1',
            'body' => 'Commenting a comment... Commented!',
            'belongs_to' => '0',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('comments')->insert([
            'post_id' => NULL,
            'comment_id' => '5',
            'user_id' => '1',
            'body' => 'Another nexted comment. Last one.',
            'belongs_to' => '0',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
    }
}
