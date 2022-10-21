@extends('layouts.app')

@section('title', 'Editar Dependencia')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 py-4">
            @include('partials.validation-errors')

            <form class="bg-white shadow rounded py-3 px-4" method="POST" action="{{ route('dependencias.update',$dependencia) }}">
                @method('PATCH')
                <h1 class="display-4">Editar Dependencia</h1>
                <hr>
                @include('dependencias._form', ['btnText' => 'Actualizar'])
            </form>
        </div>
    </div>
</div>

@endsection
