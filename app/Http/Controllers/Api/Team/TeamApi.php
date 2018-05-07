<?php

namespace App\Http\Controllers\Api\Team;

use Auth;
use App\Data\Models\Team\Team;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TeamsCollection;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class TeamApi extends ApiController {

    /**
     * Get all of my Teams.
     * Note: Best practice we should use some pagination.
     *
     * @return \App\Http\Resources\TeamsCollection All of my Teams.
     */
    public function get()
    {
        $teams = Team::ofUserId(Auth::user()->id)->get();

        return new TeamsCollection($teams);
    }

    /**
     * Create a new Team.
     *
     * @return \App\Http\Resources\TeamResource The newly created Team.
     */
    public function put()
    {
        $team = Team::firstOrCreate([
            'user_id' => Auth::user()->id,
            'name'    => request('name'),
        ]);

        return new TeamResource($team);
    }

}
