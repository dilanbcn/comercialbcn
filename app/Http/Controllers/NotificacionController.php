<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Notificacion;
use App\Models\TipoNotificacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $usuarios = User::whereNotIn('id', [$user->id])->orderBy('name')->get();
        $groupCliente = $usuarios->groupBy('activo');
        $clientes = Cliente::where(['activo' => 1])->orderBy('razon_social')->get();
        $tipoNotificacion = TipoNotificacion::where(['activo' => 1])->get();

        $user->breadcrumbs = collect([['nombre' => 'Notificaciones', 'ruta' => null]]);

        return view('pages.notificacion.index', compact('usuarios', 'clientes', 'tipoNotificacion'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJSON()
    {
        $hoy = Carbon::today();
        $user = auth()->user();

        $notificaciones = Notificacion::where('user_id', $user->id)
            ->whereDate('created_at', '<', $hoy)
            ->with(['tipoNotificacion', 'origen', 'user', 'cliente'])
            ->orderByDesc('created_at')->get();

        $arrayNotificaciones = array();
        foreach ($notificaciones as $notificacion) {
            $fN = Carbon::parse($notificacion->created_at);

            $arrayNotificaciones[] = array(
                ($fN->isCurrentYear()) ? $fN->format('d') . ' ' . $fN->locale('es')->shortMonthName : $fN->format('d/m/Y'),
                $notificacion->tipoNotificacion->nombre,
                $notificacion->origen->name . ' ' . $notificacion->origen->last_name,
                $notificacion->cliente->razon_social,
                $notificacion->contenido,
                $notificacion->id,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrayNotificaciones), 'recordsFiltered' => count($arrayNotificaciones), 'data' => $arrayNotificaciones);

        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recientesJSON()
    {
        $hoy = Carbon::today();
        $user = auth()->user();

        $notificaciones = Notificacion::where(['user_id' => $user->id])->whereDate('created_at', $hoy)
            ->with(['tipoNotificacion', 'origen'])
            ->orderByDesc('created_at')->get();

        $arrayNotificaciones = array();
        foreach ($notificaciones as $notificacion) {

            $fN = Carbon::parse($notificacion->created_at);

            $arrayNotificaciones[] = array(
                $fN->format('H:i'),
                $notificacion->tipoNotificacion->badge,
                $notificacion->contenido,
                $notificacion->id,
                '<p class="mb-0 text-muted text-notif-footer">'.$notificacion->origen->name . ' ' . $notificacion->origen->last_name.'</p><p class="text-muted text-notif-footer pr-5">'.$notificacion->cliente->razon_social.'</p>',
                '<span class="text-muted text-notif-footer pr-4">'.$fN->locale('es')->diffForHumans().'</span>',
            );
        }

        $response = array('success' => 'ok', 'data' => $arrayNotificaciones);

        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pushJSON()
    {
        $user = auth()->user();

        $notificaciones = Notificacion::where(['user_id' => $user->id, 'lectura' => null])->count();

        $response = array('total' => $notificaciones);

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function marcar(Request $request)
    {
        $user = auth()->user();

        Notificacion::where(['user_id' => $user->id, 'lectura' => null])->update(['lectura' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $destinos = $request->get('usuario');

        foreach($destinos as $key => $usuario) {
            Notificacion::create([
                'origen_user_id' => $user->id,
                'cliente_id' => $request->get('cliente'),
                'user_id' => $usuario,
                'contenido' => $request->get('contenido'),
                'tipo_notificacion_id' => 1,
            ]);
        }

        return redirect()->route('notificacion.index')->with(['status' => 'Notificación creada satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function show(Notificacion $notificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
