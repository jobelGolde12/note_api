<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('notes')->insert([
            [
                'title'       => 'Welcome Note',
                'content'     => 'This is your first seeded note. Feel free to edit or delete it.',
                'favorite'    => 0,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
                'deleted_at'  => null,
            ],
            [
                'title'       => 'Second Sample Note',
                'content'     => 'Another note added to demonstrate seeding data in Laravel.',
                'favorite'    => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
                'deleted_at'  => null,
            ],
            [
                'title'       => 'Archived Example',
                'content'     => 'This note is soft-deleted to show how restore works.',
                'favorite'    => 0,
                'created_at'  => Carbon::now()->subDays(2),
                'updated_at'  => Carbon::now()->subDays(2),
                'deleted_at'  => Carbon::now()->subDay(), // soft deleted!
            ]
        ]);
    }
}
