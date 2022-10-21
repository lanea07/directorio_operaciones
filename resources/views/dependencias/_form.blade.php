@csrf

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control bg-light @error('nombre') is-invalid @else border-0 @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $dependencia->nombre) }}">
    </div>
</div>

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="Direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control bg-light @error('direccion') is-invalid @else border-0 @enderror" name="direccion" id="direccion" placeholder="Direccion" value="{{ old('direccion', $dependencia->direccion) }}">
    </div>
</div>

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" class="form-control bg-light @error('telefono') is-invalid @else border-0 @enderror" name="telefono" id="telefono" placeholder="Telefono" value="{{ old('telefono', $dependencia->telefono) }}">
    </div>
</div>

<div class="mb-3 mx-2 col-12">
    <button class="btn btn-primary w-100" type="submit">{{ $btnText }}</button>
</div>
<div class="mb-3 mx-2 col-12">
    <a class="btn btn-link w-100" href="{{ route('dependencias.index') }}">Cancelar</a>
</div>
