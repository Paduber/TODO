<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('login', 'password');
        $remember = $request->get('remember') ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('tasks');
        }

        if(User::where('login', $request->get('login'))->exists())
        {
            $error = 'Пользователь ввел неверный пароль';
        }
        else
            $error = 'Пользователя с таким логином не существует';

        return back()->withInput()->withErrors(['login' => $error]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function getRegister()
    {
        $users = User::all();
        return view('auth.register')->with(compact('users'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'login' => 'required|unique:App\User,login',
            'password' => 'required|min:3',
            'password_confirmation' => 'same:password',
            'name' => 'required',
            'surname' => 'required',
        ]);

        User::create([
            'login' => $request->get('login'),
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'middle_name' => $request->get('middle_name'),
            'leader_id' => $request->get('leader_id'),
            'password' => Hash::make($request->get('password')),
        ]);

        $credentials = $request->only('login', 'password');

        Auth::attempt($credentials);
        return redirect()->intended('tasks');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }


}
