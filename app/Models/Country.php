<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    public function states() {
        return $this->hasMany(State::class);
    }
}
