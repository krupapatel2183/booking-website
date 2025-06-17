<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
    public function getStates($country_id) {
        return State::where('country_id', $country_id)->get();
    }

    public function getCities($state_id) {
        return City::where('state_id', $state_id)->get();
    }
}
