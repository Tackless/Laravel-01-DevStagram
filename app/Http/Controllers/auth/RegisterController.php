<?php

namespace App\Http\Controllers\auth;

/* Importing the `Controller` class from the `App\Http\Controllers` namespace. */
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        /* Returning the view `auth.register` */
        return view('auth.register');
    }

    public function store(Request $request) 
    {
        // dd($request); Todos los elementos
        // dd($request->get('username')); 1 SOLO elemento

        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validacion
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        /* Logging the user in. */
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // Otra forma de validar
        auth()->attempt($request->only('email', 'password'));


        /* Redirecting the user to the `post.index` route. */
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
