@extends('layouts.app')

@section('content')

    <div class="container">
        {{$dataTable->table(['class' => 'table table-sm table-hover display responsive nowrap'])}}
    </div>

@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
