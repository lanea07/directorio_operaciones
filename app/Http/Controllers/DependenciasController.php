<?php

namespace App\Http\Controllers;

use App\DataTables\DependenciaDataTable;
use App\Http\Requests\SaveDependenciaRequest;
use App\Models\Dependencia;
use Illuminate\Http\Request;

class DependenciasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('roles:administrador', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DependenciaDataTable $dataTable)
    {
        return $dataTable->render("dependencias.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dependencias.create', [
            'dependencia' => new Dependencia,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveDependenciaRequest $request)
    {
        $dependencia = $request->validated();
        $dependencia = Dependencia::create($dependencia);
        return redirect()->route('dependencias.index')->with('status', 'Entrada creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dependencia  $dependencia
     * @return \Illuminate\Http\Response
     */
    public function show(Dependencia $dependencia)
    {
        return view('dependencias.show',[
            'dependencia' => $dependencia,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dependencia  $dependencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Dependencia $dependencia)
    {
        return view('dependencias.edit', [
            'dependencia' => $dependencia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dependencia  $dependencia
     * @return \Illuminate\Http\Response
     */
    public function update(SaveDependenciaRequest $request, Dependencia $dependencia)
    {
        $this->authorize('update', $dependencia);
        $dependencia->update($request->validated());
        return redirect()->route('dependencias.index')->with('status', 'Actualización correcta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dependencia  $dependencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dependencia $dependencia)
    {
        try {
            $this->authorize('destroy', $dependencia);
            $dependencia->delete();
            return redirect()->route('dependencias.index')->with('status', 'Entrada eliminada con éxito.');
        } catch (\Throwable $th) {
            return redirect()->route('dependencias.index')->with('status', $th->getMessage());
        }
    }
}
