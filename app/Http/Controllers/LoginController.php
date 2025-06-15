<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // if (Auth::guard('admin')->check()) {
        //     // return redirect()->intended(route('admin.dashboard'));
        // } else {
        // }
        return \View::make('auth.login');
    }

    public function postLogin(Request $request)
    {
        $postData = $request->all();
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:5',
        );
        $messsages = array(
            'email.required' => 'Email address field is required.',
            'password.required' => 'Password Field is required.'
        );
        $validator = Validator::make($postData, $rules, $messsages);
        if ($validator->fails()) {
            return Redirect::to(route('login'))
                ->withErrors($validator);
        } else {
            $userdata = array(
                'email' => $postData['email'],
                'password' => $postData['password'],
            );
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                return redirect(route('dashboard'));
            } else {
                return back()->with('error', 'Email address or password is not valid.');
            }
        }
    }

    public function adminPostLogout()
    { 
        Auth::logout();
        return redirect(route('login'));
    }
}
