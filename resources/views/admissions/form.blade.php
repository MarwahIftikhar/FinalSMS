<div class="card module-card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-person-vcard fs-5"></i>
        <h3 class="card-title mb-0">
            {{ $admission ? 'Update Admission Details' : 'New Student Admission' }}
        </h3>
    </div>

    <div class="card-body">
        <form
            id="admissionForm"
            class="admission-form"
            action="{{ $formAction }}"
            method="POST"
        >
            @csrf
            @if ($formMethod !== 'POST')
                @method($formMethod)
            @endif

            <section class="form-section">
                <h2 class="form-section__title">
                    <i class="bi bi-person-fill"></i>
                    Student Information
                </h2>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $admission?->first_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $admission?->last_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select id="gender" name="gender" class="form-select select2" required>
                            <option value="">Select gender</option>
                            <option value="male" @selected(old('gender', $admission?->gender) === 'male')>Male</option>
                            <option value="female" @selected(old('gender', $admission?->gender) === 'female')>Female</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $admission?->date_of_birth) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="nationality" class="form-label">Nationality</label>
                        <select id="nationality" name="nationality" class="form-select select2" data-placeholder="Select nationality">
                            <option value=""></option>
                            @foreach (['Pakistani','Afghan','Bangladeshi','Chinese','Other'] as $nationality)
                                <option value="{{ $nationality }}" @selected(old('nationality', $admission?->nationality) === $nationality)>{{ $nationality }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <h2 class="form-section__title">
                    <i class="bi bi-journal-check"></i>
                    Admission Information
                </h2>

                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="admission_no" class="form-label">Admission Number <span class="text-danger">*</span></label>
                        <input type="text" id="admission_no" name="admission_no" class="form-control" value="{{ old('admission_no', $admission?->admission_no) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="admission_date" class="form-label">Admission Date <span class="text-danger">*</span></label>
                        <input type="date" id="admission_date" name="admission_date" class="form-control" value="{{ old('admission_date', $admission?->admission_date ?? now()->toDateString()) }}" required>
                    </div>

                    {{-- SINGLE CLASS SELECT --}}
                    <div class="col-md-3">
                        <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>

                        <div class="input-group">
                            <select id="class_id" name="class_id" class="form-select select2" data-placeholder="Select class" required>
                                <option value=""></option>
                                @foreach ($classes as $schoolClass)
                                    <option value="{{ $schoolClass->id }}" @selected((string) old('class_id', $admission?->class_id) === (string) $schoolClass->id)>{{ $schoolClass->name }}</option>
                                @endforeach
                            </select>

                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addClassModal" title="Add new class">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>

                        @error('class_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="section_id" class="form-label">Section</label>
                        <div class="input-group">
                            <select id="section_id" name="section_id" class="form-select select2" data-placeholder="Select section">
                                <option value=""></option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" @selected((string) old('section_id', $admission?->section_id) === (string) $section->id)>{{ $section->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addSectionModal" title="Add new section">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                        @error('section_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="form-section mb-0">
                <h2 class="form-section__title">
                    <i class="bi bi-people-fill"></i>
                    Parent / Guardian Information
                </h2>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                        <input type="text" id="father_name" name="father_name" class="form-control" value="{{ old('father_name', $admission?->father_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="mother_name" class="form-label">Mother Name</label>
                        <input type="text" id="mother_name" name="mother_name" class="form-control" value="{{ old('mother_name', $admission?->mother_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="guardian_name" class="form-label">Guardian Name</label>
                        <input type="text" id="guardian_name" name="guardian_name" class="form-control" value="{{ old('guardian_name', $admission?->guardian_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="guardian_phone" class="form-label">Guardian Phone <span class="text-danger">*</span></label>
                        <input type="text" id="guardian_phone" name="guardian_phone" class="form-control" value="{{ old('guardian_phone', $admission?->guardian_phone) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="guardian_email" class="form-label">Guardian Email</label>
                        <input type="email" id="guardian_email" name="guardian_email" class="form-control" value="{{ old('guardian_email', $admission?->guardian_email) }}">
                    </div>

                    <div class="col-md-8">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" class="form-control" rows="2">{{ old('address', $admission?->address) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Admission Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select select2" required>
                            <option value="Active" @selected(old('status', $admission?->status ?? 'Active') === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status', $admission?->status) === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>
            </section>

            <div class="form-actions mt-3">
                <a href="{{ route('admissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>

<div id="classCreateMessage" class="alert d-none" role="alert"></div>

<div id="sectionCreateMessage" class="alert d-none" role="alert"></div>

{{-- Modal: Add Class --}}
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addClassForm" class="modal-content" data-url="{{ route('classes.storeFromAdmission') }}">
            <div class="modal-header">
                <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="mb-3">
                    <label for="new_class_name" class="form-label">Class Name <span class="text-danger">*</span></label>
                    <input type="text" id="new_class_name" name="name" class="form-control" required>
                    <div class="invalid-feedback" id="new_class_name_error"></div>
                </div>
                <div class="mb-3">
                    <label for="new_class_description" class="form-label">Description</label>
                    <textarea id="new_class_description" name="description" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Class</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addSectionForm" class="modal-content" data-url="{{ route('sections.storeFromAdmission') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">Add New Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_section_name" class="form-label">Section Name <span class="text-danger">*</span></label>
                    <input type="text" id="new_section_name" name="name" class="form-control" required>
                    <div class="invalid-feedback" id="new_section_name_error"></div>
                </div>
                <div class="mb-3">
                    <label for="new_section_description" class="form-label">Description</label>
                    <textarea id="new_section_description" name="description" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Section</button>
            </div>
        </form>
    </div>
</div>

