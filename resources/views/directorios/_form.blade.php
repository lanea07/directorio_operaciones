@csrf

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control bg-light @error('nombre') is-invalid @else border-0 @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $directorio->nombre) }}">
    </div>
    <div class="mb-3 mx-2 col">
        <label for="usuario_de_red" class="form-label">Usuario de Red</label>
        <input type="text" class="form-control bg-light @error('usuario_de_red') is-invalid @else border-0 @enderror" name="usuario_de_red" id="usuario_de_red" placeholder="Nombre" value="{{ old('usuario_de_red', $directorio->usuario_de_red) }}">
    </div>
</div>

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control bg-light @error('correo') is-invalid @else border-0 @enderror" name="correo" id="correo" placeholder="Correo" value="{{ old('correo', $directorio->correo) }}">
    </div>
    <div class="mb-3 mx-2 col">
        <label for="extension" class="form-label">Extension</label>
        <input type="tel" class="form-control bg-light @error('extension') is-invalid @else border-0 @enderror" name="extension" id="extension" placeholder="Extension" value="{{ old('extension', $directorio->extension) }}">
    </div>
</div>



<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="dependencia" class="form-label">Dependencia</label>
        <select name="dependencia_id" id="dependencia" class="form-select bg-light @error('dependencia_id') is-invalid @else border-0 @enderror" aria-label="Default select example">
            @foreach ($allDependencias as $dependencia)
                <option value="{{ old('dependencia_id', $dependencia->id) }}" @isset($directorio->dependencia) {{ $directorio->dependencia->id == $dependencia->id ? 'selected' : '' }} @endisset>{{ $dependencia->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3 mx-2 col">
        <label for="area" class="form-label">Área</label>
        <select name="area_id" id="area" class="form-select bg-light @error('area_id') is-invalid @else border-0 @enderror" aria-label="Default select example">
            @foreach ($allAreas as $area)
                <option value="{{ $area->id }}" @isset($directorio->area) {{ $directorio->area->id == $area->id ? 'selected' : '' }} @endisset>{{ $area->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3 mx-2 col">
    <button class="btn btn-primary w-100" type="submit">{{ $btnText }}</button>
</div>
<div class="mb-3 mx-2 col">
    <a class="btn btn-link w-100" href="{{ route('directorios.index') }}">Cancelar</a>
</div>
