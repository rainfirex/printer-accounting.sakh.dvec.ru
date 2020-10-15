<?php

namespace App\Models;

use App\ActionEvent;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PrintLog extends Model
{
    protected $fillable = [
        'host',
        'user_id',
        'event_id',
        'data'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function event() {
        return $this->hasOne(ActionEvent::class, 'id', 'event_id');
    }
}
