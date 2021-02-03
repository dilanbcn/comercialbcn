<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteReunionRequest;
use App\Models\Cliente;
use App\Models\ClienteReunion;
use Illuminate\Http\Request;

class ClienteReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(ClienteReunionRequest $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClienteReunion  $clienteReunion
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteReunion $clienteReunion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClienteReunion  $clienteReunion
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteReunion $clienteReunion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClienteReunion  $clienteReunion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClienteReunion $clienteReunion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClienteReunion  $clienteReunion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteReunion $clienteReunion)
    {
        //
    }
}
