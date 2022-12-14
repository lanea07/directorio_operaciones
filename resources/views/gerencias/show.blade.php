@extends('layouts.app')

@section('title', 'Gerencia | '.$gerencia->nombre)

@section('content')
<div class="container">
    <div class="bg-white p-5 shadow rounded">

        <div class="row">
            <h1>{{ $gerencia->nombre }}</h1>
        </div>

        <div class="row mb-4 d-md-flex flex-column flex-md-row">
            <div class="col-md-4 me-md-5">
                <h6 class="text-muted">Creado</h6>
                <p class="text-black-50">{{ $gerencia->created_at->diffForHumans() }} ({{$gerencia->created_at->format('d/m/Y')}})</p>
            </div>
            <div class="col-md-4 me-md-5">
                <h6 class="text-muted">Actualizado</h6>
                <p class="text-black-50">{{ $gerencia->updated_at->diffForHumans() }} ({{$gerencia->updated_at->format('d/m/Y')}})</p>
            </div>
        </div>

        <div class="align-items-center d-flex flex-column-reverse flex-md-row justify-content-between">
            <a href="{{ route('gerencias.index') }}">Regresar</a>
            @auth
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ route('gerencias.edit', $gerencia) }}">Editar</a>
                <a class="btn btn-danger" href="#"
                    onclick="document.getElementById('delete-gerencia').submit()">Eliminar</a>
            </div>
            <form class="d-none" id="delete-gerencia" action="{{ route('gerencias.destroy', $gerencia) }}"
                method="post">
                @csrf @method('DELETE')
            </form>
            @endauth
        </div>

        @if ($areas->isNotEmpty())
            <div class="container mt-5 bg-light rounded p-3">
                <h3>Areas pertenecientes a esta gerencia</h3>
                <table class="table table-sm table-hover no-footer">
                    <thead class="table-dark">
                        <tr>
                            <th>Area</th>
                            <th>Relacionado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $area)
                        <tr>
                            <td>
                                <a href="{{ route('areas.show', $area->id) }}" class="link-primary">{{ $area->nombre }}</a>
                            </td>
                            <td>
                                <a href="{{ route('directorios.index', [ 'searchInputTrigger' => $area->nombre]) }}" class="link-primary">Ver personas pertenecientes a esta ??rea (b??squeda aproximada)</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="container mt-5">
                <h3>Esta Gerencia no tiene ??reas registradas</h3>
            </div>
        @endif

    </div>
</div>
@endsection
