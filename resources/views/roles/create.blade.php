@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 py-4">
            @include('partials.validation-errors')

            <form class="bg-white shadow rounded py-3 px-4" method="POST"action="{{ route('roles.store') }}">
                <h1 class="display-4">Crear Rol</h1>
                <hr>
                @include('roles._form', ['btnText' => 'Guardar'])
            </form>
        </div>
    </div>
</div>
@endsection
