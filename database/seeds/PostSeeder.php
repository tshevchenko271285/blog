<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++) {

            $title = ( $i ? $i . ' ' : '' ) . 'Lorem Ipsum is simply dummy';
            $slug = Str::slug($title);
            $description = ( $i ? $i . ' ' : '' ) . 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.';

            DB::table('posts')->insert([
                'slug' => $slug,
                'title' => $title,
                'description' => $description,
            ]);

        }
    }
}
