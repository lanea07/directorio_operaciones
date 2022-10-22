<?php

namespace App\Http\Controllers;

use App\DataTables\GerenciaDataTable;
use App\Http\Requests\SaveGerenciaRequest;
use App\Models\Gerencia;
use Illuminate\Http\Request;

class GerenciasController extends Controller
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
    public function index(GerenciaDataTable $dataTable)
    {
        return $dataTable->render("gerencias.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gerencias.create', [
            'gerencia' => new Gerencia,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveGerenciaRequest $request)
    {
        $gerencia = $request->validated();
        $gerencia = Gerencia::create($gerencia);
        return redirect()->route('gerencias.index')->with('status', 'Entrada creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function show(Gerencia $gerencia)
    {
        return view('gerencias.show', [
            'gerencia' => $gerencia,
            'areas' => $gerencia->area,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Gerencia $gerencia)
    {
        return view('gerencias.edit', [
            'gerencia' => $gerencia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function update(Gerencia $gerencia, SaveGerenciaRequest $request)
    {
        $this->authorize('update', $gerencia);
        $gerencia->update($request->validated());
        return redirect()->route('gerencias.index')->with('status', 'Actualización correcta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gerencia $gerencia)
    {
        try {
            $this->authorize('destroy', $gerencia);
            $gerencia->delete();
            return redirect()->route('gerencias.index')->with('status', 'Entrada eliminada con éxito.');
        } catch (\Throwable $th) {
            return redirect()->route('gerencias.index')->with('status', $th->getMessage());
        }
    }
}
