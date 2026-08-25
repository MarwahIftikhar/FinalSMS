<div class="card"><div class="card-body">
@if ($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form action="{{ $formAction }}" method="POST">@csrf @if ($formMethod !== 'POST') @method($formMethod) @endif
<div class="mb-3"><label for="name" class="form-label">Section Name <span class="text-danger">*</span></label><input id="name" name="name" type="text" class="form-control" value="{{ old('name', $section?->name) }}" required></div>
<div class="mb-3"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $section?->description) }}</textarea></div>
<div class="mb-3"><label for="status" class="form-label">Status <span class="text-danger">*</span></label><select id="status" name="status" class="form-select" required><option value="1" @selected((string) old('status', $section?->status ?? 1) === '1')>Active</option><option value="0" @selected((string) old('status', $section?->status) === '0')>Inactive</option></select></div>
<a href="{{ route('sections.index') }}" class="btn btn-outline-secondary">Cancel</a> <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button></form>
</div></div>
