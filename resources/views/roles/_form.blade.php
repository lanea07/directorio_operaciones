@csrf

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control bg-light @error('name') is-invalid @else border-0 @enderror" name="name" id="name" placeholder="Nombre" value="{{ old('name', $role->name) }}" {{request()->routeIs('issues.create') ? 'disabled' : '' }}>
        <input type="hidden" class="form-control bg-light" name="role_id" id="role_id" value="{{ old('role_id', $role->id) }}">
    </div>

</div>

<div class="mb-3 mx-2 col">
    <button class="btn btn-primary w-100" type="submit">{{ $btnText }}</button>
</div>
<div class="mb-3 mx-2 col">
    <a class="btn btn-link w-100" href="{{ route('roles.index') }}">Cancelar</a>
</div>
