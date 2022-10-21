@csrf

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="name" class="form-label">Nombre</label>
        <input id="name" class="form-control bg-light @error('name') is-invalid @else border-0 @enderror" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus autocomplete="name" />
    </div>
</div>

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="email" class="form-label">Email</label>
        <input id="email" class="form-control bg-light @error('email') is-invalid @else border-0 @enderror" type="email" name="email" value="{{ old('email', $user->email) }}" />
    </div>
</div>

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="password" class="form-label">Password</label>
        <input id="password" class="form-control bg-light @error('password') is-invalid @else border-0 @enderror" type="password" name="password" autocomplete="new-password" />
    </div>
</div>

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="password_confirmation" class="form-label">Confirmar Password</label>
        <input id="password_confirmation" class="form-control bg-light @error('password_confirmation') is-invalid @else border-0 @enderror" type="password" name="password_confirmation" autocomplete="new-password" />
    </div>
</div>

<div class="d-flex flex-row">
    <div class="mb-3 mx-2 col-12">
        <label for="roles" class="form-label">Roles</label>
        <select name="roles[]" id="roles" class="form-control @error('roles[]') is-invalid @else border-0 @enderror" multiple>
            <optgroup label="Permisos">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }} >{{ mb_convert_case($role->name, MB_CASE_TITLE) }}</option>
                @endforeach
            </optgroup>
        </select>
    </div>
</div>

<div class="flex items-center justify-end mt-4">
    <button class="btn btn-primary ml-4" type="submit">{{ $btnText }}</button>
</div>
