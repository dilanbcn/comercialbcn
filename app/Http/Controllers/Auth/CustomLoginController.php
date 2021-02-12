<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequests;
use App\Models\CruceDepartamento;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CustomLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequests $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            Auth::user();
            $user = auth()->user();
            $ruta = ($user->rol_id == 4 || $user->rol_id == 5) ? 'cliente-comunicacion.calendario' : 'home.comercial';
            return redirect()->route($ruta);
        }

        return redirect()->route('login')->withInput($request->input())->withError('Credenciales inválidas');
    }

    
}
