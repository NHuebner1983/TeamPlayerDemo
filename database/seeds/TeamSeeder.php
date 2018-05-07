<?php

use App\User;
use App\Data\Models\Team\Team;
use App\Data\Models\Team\Player;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $teams = factory(Team::class, 3)->create([
            'user_id' => $user->id,
        ]);

        $teams->each(function($team) use ($user)
        {
            factory(Player::class, 5)->create([
                'user_id' => $user->id,
                'team_id' => $team->id,
            ]);
        });
    }

}
