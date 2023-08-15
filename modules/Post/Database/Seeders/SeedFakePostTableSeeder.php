<?php

namespace Modules\Post\Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Post\Entities\Post;
use Illuminate\Database\Eloquent\Model;

class SeedFakePostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            Post::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'user_id' => $faker->randomElement($userIds),
                'publish_time' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'is_published' => $faker->boolean(99),
                'status' => 1,
            ]);
        }
    }

    // php artisan module:seed --class=SeedFakePostTableSeeder Post
}
