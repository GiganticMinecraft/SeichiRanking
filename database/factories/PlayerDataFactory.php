<?php

use Faker\Generator as Faker;

$factory->define(App\PlayerData::class, function (Faker $faker) {
    return [
        'name' => 'test_user',
        'uuid' => '75f6e1bc-1a06-4470-a67b-2654ea4bf0c2',
        'lastquit' => \Carbon\Carbon::now()->subMonth(),   // 1カ月前
        'totalbreaknum' => 50,
        'build_count' => 50,
        'p_vote' => 1
    ];
});
