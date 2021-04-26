<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'description' => $faker->text,
        'assigned_user_id' =>null,
        'user_id' => 1,
        'task_id' => null,
        'type'=>null,
        
    ];
});
