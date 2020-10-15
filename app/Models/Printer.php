<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    protected $fillable = [
        'product',
        'model',
        'serial',
        'mac',
        'inventory',
        'cartridge',
        'location',
        'cabinet',
        'username',
    ];
}
