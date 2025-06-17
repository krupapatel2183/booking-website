<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function cities() {
        return $this->hasMany(City::class);
    }
}
