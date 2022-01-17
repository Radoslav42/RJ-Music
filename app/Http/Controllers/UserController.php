<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function existUser(string $nameOrEmail) : bool
    {
        return (User::all()->where('username', '=', $nameOrEmail)->count() > 0
            || User::all()->where('email', '=', $nameOrEmail)->count()) > 0;
    }

    public function beforeLogin()
    {
        $view = view('login', ['titleText' => "Prihlásenie", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        session()->put('sessionMessage', "");
        return $view;
    }

    public function beforeRegistration()
    {
        $view = view('registration', ['titleText' => "Registrácia", 'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        session()->put('sessionMessage', "");
        return $view;
    }
    public function login()
    {
        if ($this->existUser(request('user_name_mail')))
        {
            session()->put('sessionMessage', "Login was successful!");
            return redirect('/beforeLogin');
        }
        else {
            session()->put('sessionMessage', "Wrong username or password!");
            return redirect('/beforeLogin');
        }
//https://laravel.com/docs/5.0/hashing
    }

    public function register()
    {
        $username = request('user_name');
        $email = request('email');
        if (!$this->existUser($username) && !$this->existUser($email))
        {
            $hashedPassword = Hash::make(request('password'));
            $user = new User();
            $user->setAttribute('username', $username );
            $user->setAttribute('email', $email );
            $user->setAttribute('password', $hashedPassword );
            $user->save();
        }
        else
        {
            session()->put('sessionMessage', "User already exists!");
            return redirect('/beforeRegistration');
        }
    }

    public function getUser()
    {

    }

}
