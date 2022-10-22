<?php

namespace App\Http\Controllers;

use App\DataTables\DirectorioDataTable;
use App\Events\DirectorioUpdate;
use App\Http\Requests\SaveDirectorioRequest;
use App\Models\Directorio;
use App\Models\Dependencia;
use App\Models\User;
use App\Models\Area;
use App\Models\Gerencia;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DirectoriosController extends Controller
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
    public function index(DirectorioDataTable $dataTable)
    {
        return $dataTable->render("directorios.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allDependencias =Dependencia::all()->sortBy('nombre');
        $allAreas =Area::all()->sortBy('nombre');
        return view('directorios.create', [
            'directorio' => new Directorio,
            'allDependencias' => $allDependencias,
            'allAreas' => $allAreas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveDirectorioRequest $request)
    {
        $directorio = $request->validated();
        $directorio = Directorio::create($directorio);
        return redirect()->route('directorios.index')->with('status', 'Entrada creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Directorio $directorio)
    {
        return view('directorios.show',[
            'directorio' => $directorio,
            'Dependencia' => $directorio->dependencia,
            'Area' => $directorio->area,
            'Gerencia' => $directorio->area->gerencia,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Directorio $directorio)
    {
        $allDependencias =Dependencia::all()->sortBy('nombre');
        $allAreas =Area::all()->sortBy('nombre');
        return view('directorios.edit', [
            'directorio' => $directorio,
            'currentDependencia' => $directorio->dependencia,
            'currentArea' => $directorio->area,
            'allDependencias' => $allDependencias,
            'allAreas' => $allAreas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Directorio $directorio, SaveDirectorioRequest $request)
    {
        $this->authorize('update', $directorio);
        $directorio->update($request->validated());
        broadcast(new DirectorioUpdate($directorio));
        return redirect()->route('directorios.index')->with('status', 'Actualización correcta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directorio $directorio)
    {
        try {
            $this->authorize('destroy', $directorio);
            $directorio->delete();
            return redirect()->route('directorios.index')->with('status', 'Entrada eliminada con éxito.');
        } catch (\Throwable $th) {
            return redirect()->route('directorios.index')->with('status', $th->getMessage());
        }
    }
}
