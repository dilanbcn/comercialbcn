<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Rol;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $comerciales = User::where('id', '<>', $user->id)->get();
        return view('pages.usuario.index', compact('comerciales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $roles = Rol::where(['activo' => 1])->get();
        return view('pages.usuario.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $rules = [
            'rut' => 'unique:users,id_number',
            'email' => 'unique:users,email'
        ];

        $customMessages = ['unique' => 'El :attribute ya se encuentra registrado.'];
        $this->validate($request, $rules, $customMessages);

        User::create([
            'rol_id' => $request->get('rol'),
            'username' => Rut::parse($request->get('rut'))->number(),
            'id_number' => Rut::parse($request->get('rut'))->format(Rut::FORMAT_WITH_DASH),
            'name' => $request->get('nombre'),
            'last_name' => $request->get('apellido'),
            'email' => $request->get('email'),
        ]);

        return redirect()->route('user.index')->with(['status' => 'Comercial creado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Rol::where(['activo' => 1])->orderBy('nombre', 'asc')->get();
        $usuario = $user;
        $usuario->rut_format = Rut::parse($usuario->id_number)->format(Rut::FORMAT_WITH_DASH);

        return view('pages.usuario.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if ($request->get('rut') != $user->id_number) {
            $rules = ['rut' => 'unique:users,id_number'];
            $customMessages = ['unique' => 'El :attribute ya se encuentra registrado.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != $user->email) {
            $rules = ['email' => 'unique:users,email'];
            $customMessages = ['unique' => 'El :attribute ya se encuentra registrado.'];
            $this->validate($request, $rules, $customMessages);
        }
        
        $user->fill([
            'rol_id' => $request->get('rol'),
            'username' => Rut::parse($request->get('rut'))->number(),
            'id_number' => Rut::parse($request->get('rut'))->format(Rut::FORMAT_WITH_DASH),
            'name' => $request->get('nombre'),
            'last_name' => $request->get('apellido'),
            'email' => $request->get('email'),
            'activo' => ($request->activo) ? 1 : 0,
        ]);

        if ($user->isDirty()) {
            $user->save();
        }

        return redirect()->route('user.index')->with(['status' => 'Registro modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with(['title' => 'Exito', 'status' => 'Registro eliminado satisfactoriamente']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function reset(User $user)
    {
        // $pass = User::createPass(8);

        // $user->password = Hash::make($pass);

        // $user->save();

        // retry(5, function () use ($user, $pass) {
        //     Mail::to($user->email)->send(new NuevaClave($user, $pass));
        // }, 100);

        // return redirect()->route('user.index')->with(['title' => 'Exito', 'status' => 'Se ha enviado la clave al correo ' . $user->email . ' satisfactoriamente']);
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function perfil()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function perfilUpdate(Request $request, User $user)
    {
        //
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function renew(Request $request)
    {
        // $pass = $request->get('password');

        // $user = User::find(auth()->user()->id);

        // $user->password = Hash::make($pass);
        // $user->save();

        // retry(5, function () use ($user, $pass) {
        //     Mail::to($user->email)->send(new NuevaClave($user, $pass));
        // }, 100);

        // return redirect()->route('user.change')->with(['title' => 'Exito', 'status' => 'Clave actualizada satisfactoriamente']);
    }

    public function cambiar()
    {
        return view('pages.usuario.clave');
    }
}
