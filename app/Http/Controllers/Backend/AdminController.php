<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller

{
    
    protected function guard()
    {
        return Auth::guard('admin_user');
    }
    public function LoginForm()
    {
        return view('backend.admin-login');
    }

    public function Login(LoginRequest $request): RedirectResponse
    {
        $request->admin_authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
    }

    public function Dashboard()
    {
        return view('backend.admin_dashboard');
    }

    public function Destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin_user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    public function show(){
        
    }
     /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->ip=$request->id;
        $user->user_agent=$request->server('HTTP_USER_AGENT');
        $user->update();
        return redirect()->route('admin-user.index');
    }
}
