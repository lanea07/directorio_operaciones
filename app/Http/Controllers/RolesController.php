<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests\SaveRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:administrador');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render("roles.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create', [
            'role' => new Role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveRoleRequest $request)
    {
        $role = $request->validated();
        $role = Role::create($role);
        return redirect()->route('roles.index')->with('status', 'Entrada creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show',[
            'role' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('roles.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(SaveRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $role->update($request->validated());
        return redirect()->route('roles.index')->with('status', 'Actualización correcta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $this->authorize('destroy', $role);
            $role->delete();
            return redirect()->route('roles.index')->with('status', 'Entrada eliminada con éxito.');
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')->with('status', $th->getMessage());
        }
    }
}
