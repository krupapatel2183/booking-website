<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $countries = Country::all(); 
        return \View::make('auth.register', compact('countries'));
    }

    public function postRegisterForm(request $request)
    {
        $postData = $request->all();

        $validator = Validator::make($postData, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string|max:500',
            'gender' => 'required|in:male,female,other',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        } else {
            User::create([
                'id' => Str::uuid(),
                'name' => $postData['name'],
                'email' => $postData['email'],
                'mobile' => $postData['mobile'],
                'country_id' => $postData['country'],
                'state_id' => $postData['state'],
                'city_id' => $postData['city'],
                'address' => $postData['address'],
                'gender' => $postData['gender'],
                'password' => Hash::make($postData['password']),
            ]);
            return redirect()->route('login')->with('success', 'Registration successful!');
        }
    }
}
