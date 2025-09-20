<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Game extends Model
{
     use HasUuid;

     protected $fillable = [
         'team_home', 'team_away', 'score_home', 'score_away', 'pickem_id'
     ];

     public function pickem()
     {
         return $this->belongsTo(Pickem::class);
     }
}
