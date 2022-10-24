@csrf

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control bg-light @error('nombre') is-invalid @else border-0 @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $directorio->nombre) }}" {{request()->routeIs('issues.create') ? 'disabled' : '' }}>
        <input type="hidden" class="form-control bg-light" name="directorio_id" id="directorio_id" value="{{ old('directorio_id', $directorio->id) }}">
    </div>
    <div class="mb-3 mx-2 col">
        <label for="usuario_de_red" class="form-label">Usuario de Red</label>
        <input type="text" class="form-control bg-light @error('usuario_de_red') is-invalid @else border-0 @enderror" name="usuario_de_red" id="usuario_de_red" placeholder="usuario_de_red" value="{{ old('usuario_de_red', $directorio->usuario_de_red) }}" {{request()->routeIs('issues.create') ? 'disabled' : '' }}>
    </div>
</div>

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <label for="text" class="form-label">Novedad</label>
        <textarea type="email" class="form-control bg-light @error('text') is-invalid @else border-0 @enderror" name="text" id="text" placeholder="Describa la novedad" value="{{ old('text', $issue->text) }}"></textarea>
    </div>
</div>

<div class="d-flex flex-column flex-md-row">
    <div class="mb-3 mx-2 col">
        <p class="text-info">Esta novedad se registra desde la IP {{ request()->ip() }}</p>
        <input type="hidden" class="form-control bg-light" name="ip_issue_sender" id="ip_issue_sender" value="{{ old('ip_issue_sender', request()->ip()) }}">
    </div>
</div>

<div class="mb-3 mx-2 col">
    <button class="btn btn-primary w-100" type="submit">{{ $btnText }}</button>
</div>
<div class="mb-3 mx-2 col">
    <a class="btn btn-link w-100" href="{{ route('directorios.index') }}">Cancelar</a>
</div>
