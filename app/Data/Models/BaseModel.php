<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeOfUserId($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

}
