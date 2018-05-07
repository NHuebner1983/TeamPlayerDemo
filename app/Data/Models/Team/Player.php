<?php

namespace App\Data\Models\Team;

use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends BaseTeamModel {

    use SoftDeletes;

    protected $table = "team_player";

    protected $fillable = [
        'team_id',
        'user_id',
        'first_name',
        'last_name',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
