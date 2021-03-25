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

        if ($user->rol_id == 2) {
            $comerciales = User::whereIn('rol_id', [1, 2])->get();

            $comerciales = $comerciales->map(function ($item) {
                $arrdata = $this->getEstadoClientes($item);
                $item->total_general = $arrdata['totalGral'];
                return $item;
            });

            $user->breadcrumbs = collect([['nombre' => 'Comerciales', 'ruta' => null], ['nombre' => 'Lista Comerciales', 'ruta' => null]]);

            return view('pages.usuario.index', compact('comerciales'));
        } else {

            $comerciales = User::whereIn('rol_id', [4, 5])->get();

            $user->breadcrumbs = collect([['nombre' => 'Prospectores', 'ruta' => null]]);

            return view('pages.usuario.index', compact('comerciales'));
            // return redirect()->route('cliente.index')->with(['status' => 'No tiene acceso a esa vista', 'title' => 'Error', 'estilo' => 'error']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        if ($user->rol_id == 2) {
            $roles = Rol::where(['activo' => 1])->whereIn('id', [1, 2])->get();
            $user->breadcrumbs = collect([['nombre' => 'Comerciales', 'ruta' => route('user.index')], ['nombre' => 'Nuevo Comercial', 'ruta' => null]]);
        } else {
            $roles = Rol::where(['activo' => 1])->whereIn('id', [4, 5])->get();
            $user->breadcrumbs = collect([['nombre' => 'Prospectores', 'ruta' => route('user.index')], ['nombre' => 'Nuevo Prospector', 'ruta' => null]]);
        }
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
        $usuario = $user;
        $usuario->rut_format = Rut::parse($usuario->id_number)->format(Rut::FORMAT_WITH_DASH);

        $user = auth()->user();
        if ($user->rol_id == 2) {
            $roles = Rol::where(['activo' => 1])->whereIn('id', [1, 2])->get();
            $user->breadcrumbs = collect([['nombre' => 'Comerciales', 'ruta' => route('user.index')], ['nombre' => 'Editar Comercial', 'ruta' => null]]);
        } else {
            $roles = Rol::where(['activo' => 1])->whereIn('id', [4, 5])->get();
            $user->breadcrumbs = collect([['nombre' => 'Prospectores', 'ruta' => route('user.index')], ['nombre' => 'Editar Prospector', 'ruta' => null]]);
        }

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
     * Show the users for a graphics.
     *
     * @return \Illuminate\Http\Response
     */
    public function grafico()
    {
        $usuarios = User::where(['activo' => 1])->whereIn('rol_id', [1, 2])->get();
        $user = auth()->user();

        if ($user->rol_id == 2) {
            $users = $usuarios->map(function ($item) {
                $arrdata = $this->getEstadoClientes($item);
                $item->activos = $arrdata['activo'];
                $item->inactivos = $arrdata['inactivo'];
                $item->prospectos = $arrdata['prospectos'];
                $item->clientes = $arrdata['clientes'];
                $item->pct_activos = ($arrdata['clientes'] > 0) ? round((($arrdata['activo'] / $arrdata['clientes']) * 100), 1) : 0;
                $total = $arrdata['prospectos'] + $arrdata['clientes'];
                $item->efectividad = ($total > 0) ? round((($arrdata['clientes'] / $total) * 100), 1) : 0;
                $item->width_efectividad = 'width: ' . $item->efectividad . '%';
                $item->efect_color = ($item->efectividad < 33) ? 'bg-danger' : (($item->efectividad > 33 && $item->efectividad < 66) ? 'bg-warning' : 'bg-success');
                return $item;
            });

            $user->breadcrumbs = collect([['nombre' => 'Comerciales', 'ruta' => null], ['nombre' => 'Detalle Comerciales', 'ruta' => null]]);

            return view('pages.usuario.index-grafico', compact('users'));
        } else {
            return redirect()->route('cliente.index')->with(['status' => 'No tiene acceso a esa vista', 'title' => 'Error', 'estilo' => 'error']);
        }
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
