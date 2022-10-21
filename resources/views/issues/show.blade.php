@extends('layouts.app')

@section('title', 'Directorio | Resolver Novedad')

@section('content')
    <div class="container">
        <div class="bg-white p-5 shadow rounded">

            <div class="row">
                <h1>{{ $issue->directorio->nombre }}</h1>
                <p class="text-secondary">Reportado desde {{ $issue->ip_issue_sender }}</p>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label for="text" class="form-label">Novedad</label>
                    <textarea type="email" class="form-control" name="text" id="text" disabled>{{ old('text', $issue->text) }}</textarea>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <h6 class="text-muted">Creado</h6>
                    <p class="text-black-50">{{ $issue->created_at->diffForHumans() }} ({{$issue->created_at->format('d/m/Y')}})</p>
                </div>
                <div class="col-4">
                    <h6 class="text-muted">Actualizado</h6>
                    <p class="text-black-50">{{ $issue->updated_at->diffForHumans() }} ({{$issue->updated_at->format('d/m/Y')}})</p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('issues.index') }}">Regresar</a>
                @auth
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('directorios.edit', $issue->directorio->id) }}">Editar</a>
                        <a class="btn btn-danger" href="#" onclick="document.getElementById('delete-issue').submit()">Eliminar</a>
                    </div>
                    <form class="d-none" id="delete-issue" action="{{ route('issues.destroy', $issue) }}" method="post">
                        @csrf @method('DELETE')
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
