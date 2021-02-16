<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::get();

        auth()->user()->breadcrumbs = collect([['nombre' => 'Productos', 'ruta' => null]]);

        return view('pages.producto.index', compact('productos'));
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
    public function store(ProductoRequest $request)
    {
        $file = $request->file('archivo');
        $fileName = substr($file->getClientOriginalName(), 0, (strlen($file->getClientOriginalName()) - (strlen($file->getClientOriginalExtension()) + 1 )));
        $nameNew = Str::slug($fileName) . '-' . time() . '.' . $file->getClientOriginalExtension() ;
        
        $request->file('archivo')->move(public_path('uploads'), $nameNew);

        $ext = $file->getClientOriginalExtension();

        $arrIcono = array('pdf' => 'fas fa-file-pdf', 'xlsx' => 'fas fa-file-excel', 'doc' => 'fas fa-file-word', 'csv' => 'fas fa-file-csv');

        Producto::create([
            'user_id' => auth()->user()->id,
            'nombre' => $request->get('nombre'),
            'archivo' => $nameNew,
            'ruta' => 'uploads/' . $nameNew,
            'extension' => $ext,
            'icono' => $arrIcono[$ext],
        ]);

        return redirect()->route('producto.index')->with(['status' => 'Producto registrado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        File::delete($producto->ruta);
        $producto->delete();

        return redirect()->route('producto.index')->with(['title' => 'Exito', 'status' => 'Producto eliminado satisfactoriamente']);
    }
}
