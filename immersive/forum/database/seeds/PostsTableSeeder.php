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
        DB::table('posts')->insert([
            'user_id' => '1',
            'title' => 'Lorem ipsum dolor',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'title' => 'Mea ea apeirian abhorreant definitiones',
            'body' => 'Mea ea apeirian abhorreant definitiones, et eum nusquam efficiantur. Nisl fierent suavitate id has. Soleat consequat ut eum. Atqui singulis id quo. Cum in deleniti comprehensam vituperatoribus, idque nominavi laboramus mea ei, usu in paulo apeirian rationibus. Eos no putant eirmod facilisi, cu per ipsum dicam definiebas, eam cu quidam iuvaret salutatus.',
            'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'title' => 'Causae voluptua eu usu',
            'body' => 'Causae voluptua eu usu, mea nominavi antiopam ex, has ad quas ignota pertinacia. Cum liber abhorreant ex, mel in tale duis aeterno. Dolor semper aeterno eam ei, dolore putant sed in. Iudico quaestio facilisis ut pri, pro dolorem complectitur ad, insolens accusata erroribus vis eu. Est indoctum omittantur in. Virtute fastidii sed ut.',
            'created_at' => Carbon::today()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
