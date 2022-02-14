<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:4', 'max:255', 'unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => ['required', 'min:3', 'max:255']
        ]);
        //todo decrypt password menggunakan bcrypt
        $validatedData['password'] = bcrypt($validatedData['password']);

        //todo Menambahkan ke dalam database
        User::create($validatedData);

        //todo Membuat alert
        // $request->session()->flash('success', 'Anda berhasil melakukan registrasi!');
        // todo cara diatas adalah salah satu cara, ada cara lain seperti yang ada dibawah

        //todo Mengarahkan user ke halaman login, apabila semua kondisi diatas bernilai true
        // * nantinya akan menampilkan hasil yang sama seperti menggunakan flash
        return redirect('/login')->with('success', 'Anda berhasil melakukan registrasi!');
    }
}
