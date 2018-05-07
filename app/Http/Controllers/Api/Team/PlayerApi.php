<?php

namespace App\Http\Controllers\Api\Team;

use Auth;
use App\Data\Models\Team\Player;
use App\Data\Models\Team\Team;
use App\Http\Resources\PlayerResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class PlayerApi extends ApiController {

    /**
     * Create a new Player for one of my Teams.
     *
     * @return \App\Http\Resources\PlayerResource The newly created Player.
     */
    public function put()
    {
        $team = Team::find(request('team_id'));

        if ( ! isset($team->id) )
        {
            return $this->error('The team does not exist.');
        }

        $player = Player::firstOrCreate([
            'user_id'    => Auth::user()->id,
            'team_id'    => request('team_id'),
            'first_name' => request('first_name'),
            'last_name'  => request('last_name'),
        ]);

        return new PlayerResource($player);
    }

    /**
     * Update an existing Player for one of my Teams.
     *
     * @param $team_id   The Team my Player is on.
     * @param $player_id The Player to update.
     *
     * @return \App\Http\Resources\PlayerResource The updated Player.
     */
    public function patch($team_id, $player_id)
    {
        $team   = Team::find($team_id);
        $player = Player::find($player_id);

        if ( ! isset($team->id) )
        {
            return $this->error('The team does not exist.');
        }

        if ( ! isset($player->id) )
        {
            return $this->error('The player does not exist.');
        }

        $player->update([
            'team_id'    => $team_id,
            'first_name' => request('first_name'),
            'last_name'  => request('last_name'),
        ]);

        return new PlayerResource($player);
    }

}
