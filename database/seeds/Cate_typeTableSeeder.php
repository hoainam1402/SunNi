<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class Cate_typeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cate_type')->where('name','Category')->orWhere('name','Tag')->delete();
        DB::table('cate_type')->insert([
            'name' => 'Category',
        ]);
        DB::table('cate_type')->insert([
            'name' => 'Tag',
        ]);
    }
}
