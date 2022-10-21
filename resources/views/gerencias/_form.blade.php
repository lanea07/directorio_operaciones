@csrf

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control bg-light @error('nombre') is-invalid @else border-0 @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $gerencia->nombre) }}">
    </div>
</div>

<div class="mb-3 mx-2 col-12">
    <button class="btn btn-primary w-100" type="submit">{{ $btnText }}</button>
</div>
<div class="mb-3 mx-2 col-12">
    <a class="btn btn-link w-100" href="{{ route('directorios.index') }}">Cancelar</a>
</div>
