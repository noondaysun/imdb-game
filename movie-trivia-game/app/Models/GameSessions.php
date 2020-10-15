<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSessions extends Model
{
    use HasFactory;

    /**
     * @return Model
     */
    public function getAvailableChallengerSlot(): Model
    {
        return Model::whereNull('session_id_challenger')
            ->firstOrFail();
    }
}
