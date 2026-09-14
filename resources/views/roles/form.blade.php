@php
    use Illuminate\Support\Str;

    $protectedRoles = [
        'super_admin',
        'supervisor',
        'administrator',
    ];

    $isProtectedRole = $role && in_array($role->name, $protectedRoles);
@endphp

<div class="card module-card">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST">
            @csrf

            @if ($formMethod !== 'POST')
                @method($formMethod)
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">
                    Role Name <span class="text-danger">*</span>
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $role ? Str::headline($role->name) : '') }}"
                    required
                    @if ($isProtectedRole) readonly @endif
                >

                @if ($isProtectedRole)
                    <small class="text-muted">
                        Default roles cannot be renamed.
                    </small>
                @else
                    <small class="text-muted">
                        Example: Super Admin. It will be stored as
                        <strong>super_admin</strong>.
                    </small>
                @endif

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if ($permissions && $permissions->count() > 0)
                <div class="mb-4">
                    <label class="form-label">Permissions</label>

                    <div class="row">
                        <div class="col-md-6">
                            @foreach ($permissions->take(ceil($permissions->count() / 2)) as $permission)
                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="permission_{{ $permission->id }}"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        @checked(in_array($permission->id, $rolePermissions ?? []))
                                    >

                                    <label
                                        class="form-check-label"
                                        for="permission_{{ $permission->id }}"
                                    >
                                        {{ Str::headline($permission->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            @foreach ($permissions->slice(ceil($permissions->count() / 2)) as $permission)
                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="permission_{{ $permission->id }}"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        @checked(in_array($permission->id, $rolePermissions ?? []))
                                    >

                                    <label
                                        class="form-check-label"
                                        for="permission_{{ $permission->id }}"
                                    >
                                        {{ Str::headline($permission->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                {{ $submitLabel }}
            </button>
        </form>
    </div>
</div>