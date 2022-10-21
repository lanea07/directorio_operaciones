@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        {{$dataTable->table(['class' => 'table table-sm table-hover'])}}
    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
