<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Record;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    public function index()
    {
        return view('PaginaPrincipal.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function store(Request $request)
    // {
    //     try {
    //         $user = User::where('document', '=', $request->document)->first();
    //         auth::login($user);
    //         $record = new Record();
    //         $record->action = 'entry';
    //         $record->date = now();
    //         $record->user_id = $user->id;
    //         $record->save();
    //         return redirect('/index');

    //     } catch (\Exception $e) {
    //         $data = ['response' => 'error', $e];
    //         return redirect('/login');
    //     }
    // }
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();


        $record = new Record();
        $record->action = 'entry';
        $record->date = now();
        $record->user_id = Auth::user()->id;
        $record->save();

        return redirect()->intended(RouteServiceProvider::HOME);
    }


    public function login(Request $request)
    {
        try {
            $user = User::where('document', '=', $request->document)->first();
            auth::login($user);
            $data = ['response' => $user];
            return $data;
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
            return redirect('/');
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $type = Auth::user()->type;
        if ($type == 1) {
            $route = '/';
        } else {
            $route = '/login';
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($route);
    }
}
