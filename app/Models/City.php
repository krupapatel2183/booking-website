<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    public function state() {
        return $this->belongsTo(State::class);
    }
}
