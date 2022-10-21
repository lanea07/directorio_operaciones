@extends('layouts.app')

@section('title', 'Usuario | '.$user->name)

@section('content')

    <div class="container">
        <div class="bg-white p-5 shadow rounded">

            <div class="mb-2">
                <img class="img-fluid img-thumbnail" src="https://ui-avatars.com/api/?name={{ $user->name }}&size=128&format=svg" >
            </div>

            <div class="row">
                <h1>{{ $user->name }}</h1>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h4>Correo</h4>
                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h4>Permisos / Roles</h4>
                    {{ mb_convert_case($user->roles->pluck('name')->implode(' - '), MB_CASE_TITLE) }}
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h6 class="text-muted">Creado</h6>
                    <p class="text-black-50">{{ $user->created_at->diffForHumans() }} ({{$user->created_at->format('d/m/Y')}})</p>
                </div>
                <div class="col-4">
                    <h6 class="text-muted">Actualizado</h6>
                    <p class="text-black-50">{{ $user->updated_at->diffForHumans() }} ({{$user->updated_at->format('d/m/Y')}})</p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('users.index') }}">Regresar</a>
                @auth
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('users.edit', $user) }}">Editar</a>
                        @if($user->id <> 1)
                            <a class="btn btn-danger" href="#" onclick="document.getElementById('delete-user').submit()">Eliminar</a>
                        @endif
                    </div>
                    @if($user->id <> 1)
                        <form class="d-none" id="delete-user" action="{{ route('users.destroy', $user) }}" method="post">
                            @csrf @method('DELETE')
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

@endsection
