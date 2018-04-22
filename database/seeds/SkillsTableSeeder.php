<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     $faker = Faker\Factory::create();
     foreach (range(1,50) as $index) {
      $data = [
       'skill' => $faker->name,
       'id' => $faker->unique()->id
      ];
      User::create($data);
     }
    }
}
