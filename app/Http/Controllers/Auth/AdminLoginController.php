<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
      return view('auth.admin-login');
    }

    public function login(Request $request)
    {
      //Validate the form data
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:6|max:15'
      ]);

      //Attempt to log in the user
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        //if sucessful then redirect to intented page
        return redirect()->intended(route('admin.dashboard'));
      }

      //if unsuccessful then redirect to form with data
      return redirect()->back()->withInput($request)->only('email', 'remember');
    }
}
