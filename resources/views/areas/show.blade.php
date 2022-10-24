@extends('layouts.app')

@section('title', 'Gerencia | '.$area->nombre)

@section('content')
<div class="container">
    <div class="bg-white p-5 shadow rounded">

        <div class="row">
            <h1>{{ $area->nombre }}</h1>
            <p class="text-secondary">Pertenece a Gerencia: {{ $area->gerencia->nombre }}</p>
        </div>

        <div class="row mb-4 d-md-flex flex-column flex-md-row">
            <div class="col-md-4 me-md-5">
                <h6 class="text-muted">Creado</h6>
                <p class="text-black-50">{{ $area->created_at->diffForHumans() }} ({{$area->created_at->format('d/m/Y')}})</p>
            </div>
            <div class="col-md-4 me-md-5">
                <h6 class="text-muted">Actualizado</h6>
                <p class="text-black-50">{{ $area->updated_at->diffForHumans() }} ({{$area->updated_at->format('d/m/Y')}})</p>
            </div>
        </div>

        <div class="align-items-center d-flex flex-column-reverse flex-md-row justify-content-between">
            <a href="{{ route('areas.index') }}">Regresar</a>
            @auth
                <div class="btn-group">
                    <a class="btn btn-primary" href="{{ route('areas.edit', $gerencia) }}">Editar</a>
                    <a class="btn btn-info" href="{{ route('directorios.index', [ 'searchInputTrigger' => $area->nombre ]) }}" title="Busqueda Aproximada">Ver Relacionados</a>
                    <a class="btn btn-danger" href="#"
                        onclick="document.getElementById('delete-gerencia').submit()">Eliminar</a>
                </div>
                <form class="d-none" id="delete-gerencia" action="{{ route('areas.destroy', $gerencia) }}"
                    method="post">
                    @csrf @method('DELETE')
                </form>
            @else
                <div class="btn-group">
                    <a class="btn btn-info" href="{{ route('directorios.index', [ 'searchInputTrigger' => $area->nombre ]) }}" title="Busqueda Aproximada">Ver Relacionados</a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
