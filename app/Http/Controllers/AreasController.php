<?php

namespace App\Http\Controllers;

use App\DataTables\AreaDataTable;
use App\Http\Requests\SaveAreaRequest;
use App\Models\Area;
use App\Models\Gerencia;
use Illuminate\Http\Request;

class AreasController extends Controller
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
    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render("areas.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gerencias = Gerencia::orderBy('nombre', 'asc')->get();
        return view('areas.create', [
            'area' => new Area,
            'gerencias' => $gerencias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveAreaRequest $request)
    {
        $area = $request->validated();
        $area = Area::create($area);
        return redirect()->route('areas.index')->with('status', 'Entrada creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        return view('areas.show', [
            'area' => $area,
            'gerencia' => $area->gerencia,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        $gerencias =Gerencia::all()->sortBy('nombre');
        return view('areas.edit', [
            'area' => $area,
            'gerencias' => $gerencias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(SaveAreaRequest $request, Area $area)
    {
        $this->authorize('update', $area);
        $area->update($request->validated());
        return redirect()->route('areas.index')->with('status', 'Actualización correcta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $this->authorize('destroy', $area);
        $area->delete();
        return redirect()->route('areas.index')->with('status', 'Entrada eliminada con éxito.');
    }
}
