<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('pages.auth.forgot-password');
    }

    public function post(ForgotPasswordRequest $request)
    {
        $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            toastr()->success($status);

            return redirect()->route('login');
        } else {
            toastr()->error($status);

            return back();
        }
    }
}
