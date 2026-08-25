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
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user?->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user?->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="branch_id" class="form-label">Branch <span class="text-danger">*</span></label>
                <select id="branch_id" name="branch_id" class="form-select select2" data-placeholder="Select branch" required>
                    <option value=""></option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected((string) old('branch_id', $user?->branch_id ?? session('active_branch_id')) === (string) $branch->id)>{{ $branch->name }} - {{ $branch->location }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password @if (!$user)<span class="text-danger">*</span>@endif</label>
                <input id="password" name="password" type="password" class="form-control" {{ $user ? '' : 'required' }} minlength="8">
                @if ($user)
                    <div class="form-text">Leave blank to keep the current password.</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password @if (!$user)<span class="text-danger">*</span>@endif</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" {{ $user ? '' : 'required' }} minlength="8">
            </div>

            <div class="form-check mb-3">
                <input id="is_admin" name="is_admin" type="hidden" value="0">
                <input id="is_admin_checkbox" name="is_admin" type="checkbox" class="form-check-input" value="1" @checked(old('is_admin', $user?->is_admin ?? false))>
                <label for="is_admin_checkbox" class="form-check-label">Administrator access</label>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        </form>
    </div>
</div>
