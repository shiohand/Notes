<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $param = [
      'person_id' => '1',
      'title' => '投稿１',
      'message' => '内容１',
    ];
    DB::table('boards')->insert($param);
    $param = [
      'person_id' => '2',
      'title' => '投稿2',
      'message' => '内容2',
    ];
    DB::table('boards')->insert($param);
    $param = [
      'person_id' => '1',
      'title' => '投稿3',
      'message' => '内容3',
    ];
    DB::table('boards')->insert($param);
  }
}
