@extends('layouts.app')

@section('title', 'Editar Área')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 py-4">
            @include('partials.validation-errors')

            <form class="bg-white shadow rounded py-3 px-4" method="POST" action="{{ route('areas.update',$area) }}">
                @method('PATCH')
                <h1 class="display-4">Editar Área</h1>
                <hr>
                @include('areas._form', ['btnText' => 'Actualizar'])
            </form>
        </div>
    </div>
</div>

@endsection
