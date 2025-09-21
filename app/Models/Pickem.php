<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Game;
use App\Models\User;

class Pickem extends Model
{
    use HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';

     protected $fillable = [
         'name', 'desc', 'ends_at', 'is_public', 'user_id'
     ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

}
