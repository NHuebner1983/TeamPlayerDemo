<?php

namespace App\Data\Models\Team;

use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends BaseTeamModel {

    use SoftDeletes;

    protected $table = "team";

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function player()
    {
        return $this->hasOne(Player::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

}
