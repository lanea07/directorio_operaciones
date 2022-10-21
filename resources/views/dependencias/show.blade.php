@extends('layouts.app')

@section('title', 'Directorio | '.$dependencia->nombre)

@section('content')
    <div class="container">
        <div class="bg-white p-5 shadow rounded">

            <div class="row">
                <h1>{{ $dependencia->nombre }}</h1>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h4>Dirección</h4>
                    {{ $dependencia->direccion }}
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h4>Teléfono</h4>
                    {{ $dependencia->telefono }}
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h6 class="text-muted">Creado</h6>
                    <p class="text-black-50">{{ $dependencia->created_at->diffForHumans() }} ({{$dependencia->created_at->format('d/m/Y')}})</p>
                </div>
                <div class="col-4">
                    <h6 class="text-muted">Actualizado</h6>
                    <p class="text-black-50">{{ $dependencia->updated_at->diffForHumans() }} ({{$dependencia->updated_at->format('d/m/Y')}})</p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('dependencias.index') }}">Regresar</a>
                @auth
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('dependencias.edit', $dependencia) }}">Editar</a>
                        <a class="btn btn-danger" href="#" onclick="document.getElementById('delete-dependencia').submit()">Eliminar</a>
                    </div>
                    <form class="d-none" id="delete-dependencia" action="{{ route('dependencias.destroy', $dependencia) }}" method="post">
                        @csrf @method('DELETE')
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
