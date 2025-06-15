<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Validator;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return \View::make('auth.register');
    }

    public function postRegisterForm(request $request)
    {
        $postData = $request->all();

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
        );

        $messsages = array(
            'first_name.required' => 'First Name field is required.',
            'last_name.required' => 'Last Name field is required.',
            'email.required' => 'Email address field is required.',
            'password.required' => 'Password Field is required.'
        );

        $validator = Validator::make($postData, $rules, $messsages);
        if ($validator->fails()) {
            return Redirect::to(route('register'))
                ->withErrors($validator);
        } else {
            $user = User::create([
                'id' => Str::uuid(),
                'first_name' => $postData['first_name'],
                'last_name' => $postData['last_name'],
                'email' => $postData['email'],
                'password' => $postData['password']
            ]);
            return redirect()->route('login')->with('success', 'Registration successful!');
        }
    }
}
