import $ from 'jquery';
import * as bootstrap from 'bootstrap';
import DataTable from 'datatables.net-bs5';
import select2 from 'select2';
import toastr from 'toastr';


// ---------------------------------------------------------
// Make jQuery available globally.
// Select2 and other plugins need access to jQuery.
// ---------------------------------------------------------
window.$ = window.jQuery = $;
window.bootstrap = bootstrap;


// ---------------------------------------------------------
// Connect DataTables with jQuery.
// ---------------------------------------------------------
DataTable.use($);


// ---------------------------------------------------------
// Initialize Select2 plugin.
// ---------------------------------------------------------
select2(window, $);


// ---------------------------------------------------------
// Make toastr available globally.
// ---------------------------------------------------------
window.toastr = toastr;


// ---------------------------------------------------------
// Run everything after the page has loaded.
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {

    // -----------------------------------------------------
    // Get CSRF token from the main Blade layout.
    // This is required for POST, PUT and DELETE requests.
    // -----------------------------------------------------
    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.content;


    // -----------------------------------------------------
    // Find the admissions DataTable.
    // If the current page does not contain this table,
    // nothing will happen.
    // -----------------------------------------------------
    const admissionsTableElement = $('#admissionsTable');

    let admissionsTable = null;


    // -----------------------------------------------------
    // Configure toastr notifications.
    // -----------------------------------------------------
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3500,
        extendedTimeOut: 1000,
    };


    // -----------------------------------------------------
    // Show Laravel flash messages through toastr.
    // -----------------------------------------------------
    const flashToast = $('#flashToast');

    if (flashToast.length) {

        const type = flashToast.data('type') || 'success';
        const message = flashToast.data('message');

        if (typeof toastr[type] === 'function') {
            toastr[type](message);
        }
    }


    // =====================================================
    // SELECT2
    // =====================================================

    // -----------------------------------------------------
    // Initialize every element having class "select2".
    //
    // IMPORTANT:
    // We are NOT using "tags: true".
    //
    // The Class dropdown uses class_id, which is a foreign
    // key connected to the classes table.
    //
    // Therefore, only classes that actually exist in the
    // classes table should appear here.
    // -----------------------------------------------------
    $('.select2').each(function () {

        const select = $(this);

        // Prevent Select2 from being initialized twice.
        if (select.hasClass('select2-hidden-accessible')) {
            return;
        }

        const placeholder =
            select.data('placeholder') || 'Select an option';

        const allowClear =
            Boolean(select.data('placeholder'));

        select.select2({
            width: '100%',
            placeholder: placeholder,
            allowClear: allowClear,
        });
    });


    // =====================================================
    // ADMISSIONS DATATABLE
    // =====================================================

    // -----------------------------------------------------
    // Only initialize the DataTable if the table exists
    // on the current page.
    // -----------------------------------------------------
    if (admissionsTableElement.length) {

        admissionsTable = admissionsTableElement.DataTable({

            // Show "Processing..." while data is loading.
            processing: true,

            // Data is loaded from Laravel using AJAX.
            serverSide: true,

            // URL comes from data-source in admissions.index.
            ajax: admissionsTableElement.data('source'),

            // -------------------------------------------------
            // Columns returned by AdmissionController.
            // -------------------------------------------------
            columns: [

                // Serial number.
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                // Admission number.
                {
                    data: 'admission_no',
                    name: 'admission_no',
                },

                // Student full name.
                {
                    data: 'student_name',
                    name: 'first_name',
                },

                // Father's name.
                {
                    data: 'father_name',
                    name: 'father_name',
                },

                // Class name returned by controller.
                {
                    data: 'class_name',
                    name: 'class_id',
                },

                // Gender.
                {
                    data: 'gender',
                    name: 'gender',
                },

                // Admission date.
                {
                    data: 'admission_date',
                    name: 'admission_date',
                },

                // Active / Inactive badge.
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                },

                // Edit and Delete buttons.
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                },
            ],

            // Sort by admission date descending.
            order: [
                [6, 'desc']
            ],

            // Ten records per page.
            pageLength: 10,
        });
    }


    // =====================================================
    // HELPER FUNCTIONS
    // =====================================================

    // -----------------------------------------------------
    // Display a toastr message.
    // -----------------------------------------------------
    const showMessage = (type, message) => {

        if (typeof toastr[type] === 'function') {
            toastr[type](message);
        }
    };


    // -----------------------------------------------------
    // Convert Laravel validation errors into HTML.
    // -----------------------------------------------------
    const errorsHtml = (errors) => {

        const messages = Object.values(errors || {}).flat();

        if (!messages.length) {
            return 'Please check the form and try again.';
        }

        return `
            <ul class="mb-0">
                ${messages
                    .map((message) => `<li>${message}</li>`)
                    .join('')}
            </ul>
        `;
    };


    // =====================================================
    // ADMISSION FORM
    // =====================================================

    // -----------------------------------------------------
    // Find the admission form.
    // -----------------------------------------------------
    const admissionForm =
        document.getElementById('admissionForm');


    // -----------------------------------------------------
    // Only attach submit functionality if the form exists.
    // -----------------------------------------------------
    if (admissionForm) {

        admissionForm.addEventListener(
            'submit',
            async (event) => {

                // Stop normal browser form submission.
                event.preventDefault();


                // -------------------------------------------------
                // Find submit button.
                // -------------------------------------------------
                const button =
                    admissionForm.querySelector(
                        'button[type="submit"]'
                    );


                // -------------------------------------------------
                // Save original button HTML.
                // We restore it after the request finishes.
                // -------------------------------------------------
                const defaultButtonHtml =
                    button?.innerHTML || 'Save';


                // -------------------------------------------------
                // Disable button while saving.
                // This prevents duplicate submissions.
                // -------------------------------------------------
                if (button) {

                    button.disabled = true;

                    button.innerHTML = `
                        <span
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true">
                        </span>
                        Saving...
                    `;
                }


                try {

                    // -------------------------------------------------
                    // Convert form fields into FormData.
                    //
                    // This includes:
                    // first_name
                    // gender
                    // admission_no
                    // class_id
                    // section
                    // etc.
                    // -------------------------------------------------
                    const formData =
                        new FormData(admissionForm);


                    // -------------------------------------------------
                    // Send form to Laravel.
                    // -------------------------------------------------
                    const response = await fetch(
                        admissionForm.action,
                        {
                            method: 'POST',

                            body: formData,

                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With':
                                    'XMLHttpRequest',
                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },
                        }
                    );


                    // -------------------------------------------------
                    // Laravel should return JSON because we requested
                    // application/json.
                    // -------------------------------------------------
                    const data =
                        await response.json();


                    // =================================================
                    // VALIDATION ERROR
                    // =================================================

                    if (response.status === 422) {

                        showMessage(
                            'error',
                            errorsHtml(data.errors)
                        );

                        return;
                    }


                    // =================================================
                    // OTHER SERVER ERROR
                    // =================================================

                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'The admission could not be saved.'
                        );
                    }


                    // =================================================
                    // SUCCESS
                    // =================================================

                    showMessage(
                        'success',
                        data.message ||
                        'Student admission saved successfully.'
                    );


                    // -------------------------------------------------
                    // Redirect to admissions list.
                    // -------------------------------------------------
                    if (data.redirect_url) {

                        window.setTimeout(() => {

                            window.location.assign(
                                data.redirect_url
                            );

                        }, 700);
                    }


                } catch (error) {

                    // -------------------------------------------------
                    // Display unexpected error.
                    // -------------------------------------------------
                    showMessage(
                        'error',
                        error.message ||
                        'Something went wrong while saving the admission.'
                    );


                } finally {

                    // -------------------------------------------------
                    // Enable button again.
                    // -------------------------------------------------
                    if (button) {

                        button.disabled = false;

                        button.innerHTML =
                            defaultButtonHtml;
                    }
                }
            }
        );
    }


    // =====================================================
    // CREATE CLASS FROM ADMISSION FORM
    // =====================================================

    const addClassForm = document.getElementById('addClassForm');

    if (addClassForm) {
        addClassForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const nameInput = document.getElementById('new_class_name');
            const descriptionInput = document.getElementById('new_class_description');
            const nameError = document.getElementById('new_class_name_error');
            const message = document.getElementById('classCreateMessage');
            const submitButton = addClassForm.querySelector('button[type="submit"]');

            nameError.textContent = '';
            nameInput.classList.remove('is-invalid');
            message.className = 'alert d-none';
            message.textContent = '';
            submitButton.disabled = true;

            try {
                const response = await fetch(addClassForm.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        name: nameInput.value.trim(),
                        description: descriptionInput.value.trim(),
                    }),
                });

                const data = await response.json();

                if (response.status === 422) {
                    if (data.errors?.name?.[0]) {
                        nameError.textContent = data.errors.name[0];
                        nameInput.classList.add('is-invalid');
                    }
                    message.className = 'alert alert-danger';
                    message.textContent = data.errors?.name?.[0] || 'Please correct the form.';
                    return;
                }

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Class could not be created.');
                }

                const select = document.getElementById('class_id');
                const option = new Option(data.name, data.id, true, true);
                select.add(option);
                $(select).trigger('change');

                message.className = 'alert alert-success';
                message.textContent = data.message;

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('addClassModal')
                ).hide();
                addClassForm.reset();
                showMessage('success', data.message);
            } catch (error) {
                message.className = 'alert alert-danger';
                message.textContent = error.message || 'An error occurred while creating the class.';
            } finally {
                submitButton.disabled = false;
            }
        });
    }

    const addSectionForm = document.getElementById('addSectionForm');

    if (addSectionForm) {
        addSectionForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const nameInput = document.getElementById('new_section_name');
            const descriptionInput = document.getElementById('new_section_description');
            const nameError = document.getElementById('new_section_name_error');
            const message = document.getElementById('sectionCreateMessage');
            const submitButton = addSectionForm.querySelector('button[type="submit"]');

            nameError.textContent = '';
            nameInput.classList.remove('is-invalid');
            message.className = 'alert d-none';
            message.textContent = '';
            submitButton.disabled = true;

            try {
                const response = await fetch(addSectionForm.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        name: nameInput.value.trim(),
                        description: descriptionInput.value.trim(),
                    }),
                });

                const data = await response.json();

                if (response.status === 422) {
                    const validationMessage = data.errors?.name?.[0] || 'Please correct the form.';
                    nameError.textContent = data.errors?.name?.[0] || '';
                    nameInput.classList.toggle('is-invalid', Boolean(data.errors?.name?.[0]));
                    message.className = 'alert alert-danger';
                    message.textContent = validationMessage;
                    return;
                }

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Section could not be created.');
                }

                const select = document.getElementById('section_id');
                select.add(new Option(data.name, data.id, true, true));
                $(select).trigger('change');
                message.className = 'alert alert-success';
                message.textContent = data.message;
                bootstrap.Modal.getOrCreateInstance(document.getElementById('addSectionModal')).hide();
                addSectionForm.reset();
                showMessage('success', data.message);
            } catch (error) {
                message.className = 'alert alert-danger';
                message.textContent = error.message || 'An error occurred while creating the section.';
            } finally {
                submitButton.disabled = false;
            }
        });
    }

    const addClassCrudForm = document.getElementById('addClassCrudForm');

    if (addClassCrudForm) {
        addClassCrudForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const nameInput = document.getElementById('crud_class_name');
            const descriptionInput = document.getElementById('crud_class_description');
            const message = document.getElementById('classCrudMessage');
            const nameError = document.getElementById('crud_class_name_error');

            message.className = 'alert d-none';
            nameError.textContent = '';
            nameInput.classList.remove('is-invalid');

            try {
                const response = await fetch(addClassCrudForm.dataset.url, {
                    method: 'POST',
                    headers: {'Accept': 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken},
                    body: JSON.stringify({name: nameInput.value.trim(), description: descriptionInput.value.trim()}),
                });
                const data = await response.json();
                if (response.status === 422) {
                    nameError.textContent = data.errors?.name?.[0] || '';
                    nameInput.classList.toggle('is-invalid', Boolean(data.errors?.name?.[0]));
                    message.className = 'alert alert-danger';
                    message.textContent = data.errors?.name?.[0] || 'Please correct the form.';
                    return;
                }
                if (!response.ok || !data.success) throw new Error(data.message || 'Class could not be created.');
                message.className = 'alert alert-success';
                message.textContent = data.message;
                bootstrap.Modal.getOrCreateInstance(document.getElementById('addClassCrudModal')).hide();
                addClassCrudForm.reset();
                showMessage('success', data.message);
                setTimeout(() => window.location.reload(), 700);
            } catch (error) {
                message.className = 'alert alert-danger';
                message.textContent = error.message || 'An error occurred while creating the class.';
            }
        });
    }


    // =====================================================
    // DELETE ADMISSION
    // =====================================================

    // -----------------------------------------------------
    // Listen for clicks anywhere on the page.
    //
    // This works for DataTables rows even though DataTables
    // creates those rows dynamically.
    // -----------------------------------------------------
    document.addEventListener(
        'click',
        async (event) => {

            // -------------------------------------------------
            // Find the closest delete button.
            // -------------------------------------------------
            const button =
                event.target.closest(
                    '.delete-admission'
                );


            // -------------------------------------------------
            // If the clicked element isn't a delete button,
            // stop here.
            // -------------------------------------------------
            if (!button) {
                return;
            }


            // -------------------------------------------------
            // Ask user for confirmation.
            // -------------------------------------------------
            const admissionNo =
                button.dataset.admissionNo || 'this admission';


            const confirmed =
                window.confirm(
                    `Delete admission ${admissionNo}? This cannot be undone.`
                );


            if (!confirmed) {
                return;
            }


            // -------------------------------------------------
            // Disable delete button while deleting.
            // -------------------------------------------------
            button.disabled = true;


            try {

                // -------------------------------------------------
                // Send DELETE request to Laravel.
                // -------------------------------------------------
                const response =
                    await fetch(
                        button.dataset.deleteUrl,
                        {
                            method: 'DELETE',

                            headers: {
                                'Accept':
                                    'application/json',

                                'X-Requested-With':
                                    'XMLHttpRequest',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },
                        }
                    );


                // -------------------------------------------------
                // Read JSON response.
                // -------------------------------------------------
                const data =
                    await response.json();


                // -------------------------------------------------
                // Check whether deletion succeeded.
                // -------------------------------------------------
                if (!response.ok || !data.success) {

                    throw new Error(
                        data.message ||
                        'The admission could not be deleted.'
                    );
                }


                // -------------------------------------------------
                // Reload DataTable without returning to page 1.
                // -------------------------------------------------
                if (admissionsTable) {

                    admissionsTable.ajax.reload(
                        null,
                        false
                    );
                }


                // -------------------------------------------------
                // Show success notification.
                // -------------------------------------------------
                showMessage(
                    'success',
                    data.message ||
                    'Student admission deleted successfully.'
                );


            } catch (error) {

                // -------------------------------------------------
                // Show delete error.
                // -------------------------------------------------
                showMessage(
                    'error',
                    error.message ||
                    'Something went wrong while deleting the admission.'
                );


                // -------------------------------------------------
                // Allow the user to try deleting again.
                // -------------------------------------------------
                button.disabled = false;
            }
        }
    );
});