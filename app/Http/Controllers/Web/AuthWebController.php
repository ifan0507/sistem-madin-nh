<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthWebController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('pages.auths.index');
    }

    public function v_login()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('pages.auths.index');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'username.required' => 'Username harus diisi!',
                'password.required' => 'Password harus diisi!',
            ],
        );

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 1 || $user->role == 2) {

                $request->session()->regenerate();

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'redirect_url' => route('dashboard')
                    ]);
                }

                return redirect()->intended('dashboard');
            } else {

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $pesanError = 'Username atau Password Salah';

                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => $pesanError], 403);
                }

                return back()->withInput()->withErrors($pesanError);
            }
        }

        $pesanError = 'Username atau Password Salah';

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => $pesanError], 401);
        }

        return back()->withInput()->withErrors($pesanError);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
