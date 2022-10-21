@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">
                @include('partials.validation-errors')

                        <form class="bg-white shadow rounded py-3 px-4" method="POST" action="{{ route('users.update', $user) }}">
                            @method('PATCH')
                            <h1 class="display-4">Editar Usuario</h1>
                            <hr>
                            @include('users._form', ['btnText' => 'Guardar'])
                        </form>

            </div>
        </div>
    </div>
@endsection
