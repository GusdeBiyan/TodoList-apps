<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Data yang akan dimasukkan ke dalam tabel categories
        $categories = [
            ['name' => 'Todo'],
            ['name' => 'InProgress'],
            ['name' => 'Testing'],
            ['name' => 'Done'],
            ['name' => 'Pending'],
        ];

        // Menyisipkan data ke dalam tabel categories
        DB::table('categories')->insert($categories);
    }
}
