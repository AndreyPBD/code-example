<?php

declare(strict_types=1);

use App\Models\BodyStats;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Muscle;
use App\Models\Post;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    public function run()
    {
        factory(Muscle::class, 20)->create();
        $muscles = Muscle::all();

        factory(Equipment::class, 20)->create();
        $equipments = Equipment::all();

        factory(BodyStats::class, 5)->create();
        factory(Post::class, 5)->create();

        /** @var Exercise $exercise */
        factory(Exercise::class, 5)->create()->each(function ($exercise) use ($equipments) {
            $exercise->equipments()->attach(
                $equipments->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
