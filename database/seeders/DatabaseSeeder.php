<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name'=>'User One',
            'email'=>'userone@gmail.com',
            'password'=>Hash::make('password'),
            'image'=>'image/user.png',
        ]);

        Language::create([
            'slug'=>'javascript',
            'name'=>'Javascript',
        ]);

        Language::create([
            'slug'=>'PHP',
            'name'=>'PHP',
        ]);

        Language::create([
            'slug'=>'Nodejs',
            'name'=>'Nodejs',
        ]);

        Category::create([
            'slug'=>'web-dev',
            'name'=>'Web Development',
        ]);

        Category::create([
            'slug'=>'web-design',
            'name'=>'Web Design',
        ]);

        Category::create([
            'slug'=>'mobile-dev',
            'name'=>'Mobile Development',
        ]);
    }
}
