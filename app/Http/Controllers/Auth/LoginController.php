<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function post(LoginRequest $request)
    {
        $request->validated();

        if (! Auth::attempt($request->only(['email', 'password']), isset($request->remember))) {
            toastr()->error('Email atau password salah!');

            return back();
        }

        return redirect()->route('dashboard.index');
    }
}
