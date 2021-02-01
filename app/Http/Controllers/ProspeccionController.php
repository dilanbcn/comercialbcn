<?php

namespace App\Http\Controllers;

use App\Models\ClienteContacto;
use Illuminate\Http\Request;

class ProspeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactos()
    {
        $contactos = ClienteContacto::with(['cliente' => function($sql){
            return $sql->with(['tipoCliente', 'padre', 'user']);
        }])->get();

        return view('pages.prospeccion.contacto', compact('contactos'));
    }
}
