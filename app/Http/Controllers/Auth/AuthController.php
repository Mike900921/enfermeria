<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\Users\Instructor;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // LOGIN NORMAL (si aplica)
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('consulta');
        }

        // LOGIN INSTRUCTOR (personalizado)
        $instructor = Instructor::where('email', $request->email)->first();
        $instructor->password = Hash::make($request->password);

        if (
            $instructor &&
            Hash::check($request->password, $instructor->password) &&
            $instructor->participante->rol_id == 2 &&
            $instructor->estado == 1 // ajusta según tu estado activo
        ) {
            Auth::guard('instructor')->login($instructor);
            $request->session()->regenerate();

            return redirect()->intended('consulta')
                ->with('success', 'Instructor logueado correctamente');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // usuario normal
        Auth::guard('instructor')->logout(); // instructor

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
