@extends('layouts.app')

@section('title', 'Directorio | Ver Rol')

@section('content')
    <div class="container">
        <div class="bg-white p-5 shadow rounded">

            <div class="row">
                <h1>{{ $role->name }}</h1>
            </div>

            <div class="row mb-4 d-md-flex flex-column flex-md-row">
                <div class="col-md-4 me-md-5">
                    <h6 class="text-muted">Creado</h6>
                    <p class="text-black-50">{{ $role->created_at->diffForHumans() }} ({{$role->created_at->format('d/m/Y')}})</p>
                </div>
                <div class="col-md-4 me-md-5">
                    <h6 class="text-muted">Actualizado</h6>
                    <p class="text-black-50">{{ $role->updated_at->diffForHumans() }} ({{$role->updated_at->format('d/m/Y')}})</p>
                </div>
            </div>

            <div class="align-items-center d-flex flex-column-reverse flex-md-row justify-content-between">
                <a href="{{ route('roles.index') }}">Regresar</a>
                @auth
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Editar</a>
                        <a class="btn btn-danger" href="#" onclick="document.getElementById('delete-role').submit()">Eliminar</a>
                    </div>
                    <form class="d-none" id="delete-role" action="{{ route('roles.destroy', $role) }}" method="post">
                        @csrf @method('DELETE')
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
