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
                    Name <span class="text-danger">*</span>
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    class="form-control"
                    value="{{ old('name', $user?->name) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">
                    Email <span class="text-danger">*</span>
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    class="form-control"
                    value="{{ old('email', $user?->email) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="branch_id" class="form-label">
                    Branch <span class="text-danger">*</span>
                </label>

                <select
                    id="branch_id"
                    name="branch_id"
                    class="form-select select2"
                    data-placeholder="Select branch"
                    required
                >
                    <option value=""></option>

                    @foreach ($branches as $branch)
                        <option
                            value="{{ $branch->id }}"
                            @selected(
                                (string) old(
                                    'branch_id',
                                    $user?->branch_id ?? session('active_branch_id')
                                ) === (string) $branch->id
                            )
                        >
                            {{ $branch->name }} - {{ $branch->location }}
                        </option>
                    @endforeach
                </select>
            </div>

            @role('super_admin')
                <div class="mb-3">
                    <label for="role_id" class="form-label">
                        Role
                    </label>

                    <select
                        id="role_id"
                        name="role_id"
                        class="form-select select2 @error('role_id') is-invalid @enderror"
                        data-placeholder="Select role (optional)"
                    >
                        <option value=""></option>

                        @foreach ($roles as $role)
                            <option
                                value="{{ $role->id }}"
                                @selected(
                                    (string) old(
                                        'role_id',
                                        $userRole?->id ?? null
                                    ) === (string) $role->id
                                )
                            >
                                {{ \Illuminate\Support\Str::headline($role->name) }}
                            </option>
                        @endforeach
                    </select>

                    @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        Assign a role to control user permissions. If no role is selected,
                        the user will have basic access.
                    </div>
                </div>
            @endrole

            <div class="mb-3">
                <label for="password" class="form-label">
                    Password

                    @if (!$user)
                        <span class="text-danger">*</span>
                    @endif
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    {{ $user ? '' : 'required' }}
                    minlength="8"
                >

                @if ($user)
                    <div class="form-text">
                        Leave blank to keep the current password.
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    Confirm Password

                    @if (!$user)
                        <span class="text-danger">*</span>
                    @endif
                </label>

                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="form-control"
                    {{ $user ? '' : 'required' }}
                    minlength="8"
                >
            </div>

            <a
                href="{{ route('users.index') }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                {{ $submitLabel }}
            </button>
        </form>
    </div>
</div>