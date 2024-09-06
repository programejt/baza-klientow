<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
  public function index() {
    return view('admin');
  }

  public function auth(Request $req) {
    if ($req->input('login') == 'admin' && $req->input('password') == 'admin') {
      session(['admin' => 'true']);
      return redirect('/clients');
    }

    return redirect('/admin')->with([
      'login' => $req->input('login'),
      'password' => $req->input('password'),
      'loginError' => 'Niepoprawne dane logowania'
    ]);
  }

  public function logout() {
    session()->forget('admin');
    return redirect('/admin');
  }
}
