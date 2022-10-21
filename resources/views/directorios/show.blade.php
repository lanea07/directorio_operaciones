@extends('layouts.app')

@section('title', 'Directorio | '.$directorio->nombre)

@section('content')
    <div class="container">
        <div class="bg-white p-5 shadow rounded">

            <div class="row">
                <h1>{{ $directorio->nombre }}</h1>
                <p class="text-secondary">{{ $directorio->usuario_de_red }} || Pertenece a Gerencia: {{ $directorio->area->gerencia->nombre }}</p>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h4>Correo</h4>
                    <a href="mailto:{{ $directorio->correo }}">{{ $directorio->correo }}</a>
                </div>
                <div class="col-4">
                    <h4>Número de contacto</h4>
                    <a href="tel:60{{ $directorio->dependencia->telefono }}">{{ $directorio->dependencia->telefono }} - Ext. {{ $directorio->extension}}</a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h4>Dependencia</h4>
                    {{ $directorio->dependencia->nombre }}
                </div>
                <div class="col-4">
                    <h4>Área</h4>
                    {{ $directorio->area->nombre }}
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h6 class="text-muted">Creado</h6>
                    <p class="text-black-50">{{ $directorio->created_at->diffForHumans() }} ({{$directorio->created_at->format('d/m/Y')}})</p>
                </div>
                <div class="col-4">
                    <h6 class="text-muted">Actualizado</h6>
                    <p class="text-black-50">{{ $directorio->updated_at->diffForHumans() }} ({{$directorio->updated_at->format('d/m/Y')}})</p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('directorios.index') }}">Regresar</a>
                @auth
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('directorios.edit', $directorio) }}">Editar</a>
                        <a class="btn btn-danger" href="#" onclick="document.getElementById('delete-directorio').submit()">Eliminar</a>
                    </div>
                    <form class="d-none" id="delete-directorio" action="{{ route('directorios.destroy', $directorio) }}" method="post">
                        @csrf @method('DELETE')
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
