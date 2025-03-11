<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
  public function index()
  {
    return view('login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'password' => 'required'
    ], [
      'username.required' => 'Username wajib diisi',
      'password.required' => 'Password wajib diisi'
    ]);

    $infoLogin = [
      'username' => $request->username,
      'password' => $request->password
    ];

    if (Auth::attempt($infoLogin)) {
      if (Auth::user()->level == 'super_admin') {
        return redirect('/dashboard');
      } elseif (Auth::user()->level == 'admin') {
        return redirect('/dashboard');
      } elseif (Auth::user()->level == 'qc') {
        return redirect('/dashboard');
      }
    } else {
      return redirect('/')->withErrors('Username / Password salah')->withInput();
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}
