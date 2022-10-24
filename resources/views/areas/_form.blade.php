@csrf

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control bg-light @error('nombre') is-invalid @else border-0 @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $area->nombre) }}">
    </div>
</div>

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="gerencia" class="form-label">Gerencia</label>
        <select name="gerencia_id" id="gerencia" class="form-select bg-light @error('gerencia_id') is-invalid @else border-0 @enderror" aria-label="Default select example">
            @foreach ($gerencias as $gerencia)
                <option value="{{ old('gerencia_id', $gerencia->id) }}" @isset($area->gerencia) {{ $area->gerencia->id == $gerencia->id ? 'selected' : '' }} @endisset>{{ $gerencia->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3 mx-2 col">
    <button class="btn btn-primary w-100" type="submit">{{ $btnText }}</button>
</div>
<div class="mb-3 mx-2 col">
    <a class="btn btn-link w-100" href="{{ route('areas.index') }}">Cancelar</a>
</div>
