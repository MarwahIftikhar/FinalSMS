<?php

use ColorlibHQ\AdminLte\Menu\Filters\ActiveFilter;
use ColorlibHQ\AdminLte\Menu\Filters\GateFilter;
use ColorlibHQ\AdminLte\Menu\Filters\HrefFilter;
use ColorlibHQ\AdminLte\Menu\Filters\SearchFilter;

return [

    'title' => 'School Management System',
    'title_prefix' => '',
    'title_postfix' => '',

    'use_ico_only' => false,
    'use_full_favicon' => false,

    'google_fonts' => [
        'allowed' => true,
    ],

    'logo' => '<b>SMS</b> School',
    'logo_img' => '',
    'logo_img_class' => '',
    'logo_img_alt' => 'School Management System',

    'auth_logo' => [
        'enabled' => false,

        'img' => [
            'path' => '',
            'alt' => 'School Management System',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,
    'layout_rtl' => false,

    'footer_left' =>
        'Copyright &copy; ' . date('Y') .
        ' <a href="#" class="text-decoration-none">School Management System</a>. All rights reserved.',

    'footer_right' => 'School Management System',

    'preloader' => false,

    'control_sidebar' => false,
    'control_sidebar_theme' => 'dark',

    'sidebar_docs_url' => false,

    'demo' => false,
    'demo_middleware' => ['web'],

    'docs' => false,
    'docs_middleware' => ['web'],

    'sidebar_breakpoint' => 'lg',
    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,

    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'leave',

    'sidebar_theme' => 'dark',

    'primary_color' => '#0d6efd',
    'sidebar_color' => '#172554',
    'navbar_color' => '#ffffff',
    'footer_color' => '#ffffff',

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => 'fw-semibold',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'shadow',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-expand bg-white shadow-sm',
    'classes_topnav_nav' => 'navbar',
    'classes_topnav_container' => 'container-fluid',

    'color_mode_toggle' => true,


    'menu' => [

        [
            'text' => 'Home',
            'url' => '/',
            'icon' => 'bi bi-house-door-fill',
        ],

        [
            'text' => 'Student Records',
            'icon' => 'bi bi-person-vcard-fill',

            'submenu' => [
                [
                    'text' => 'All Students',
                    'url' => 'students',
                    'icon' => 'bi bi-people-fill',
                ],

                [
                    'text' => 'Add Student',
                    'url' => 'students/create',
                    'icon' => 'bi bi-person-plus-fill',
                ],

                [
                    'text' => 'Student Attendance',
                    'url' => 'student-attendance',
                    'icon' => 'bi bi-calendar-check-fill',
                ],
            ],
        ],

        [
            'text' => 'Admissions',
            'icon' => 'bi bi-clipboard-check',

            'submenu' => [
                [
                    'text' => 'All Admissions',
                    'url' => 'admissions',
                    'icon' => 'bi bi-list-ul',
                ],

                [
                    'text' => 'New Admission',
                    'url' => 'admissions/create',
                    'icon' => 'bi bi-person-plus',
                ],
            ],
        ],

        [
            'text' => 'Classes',
            'url' => 'classes',
            'icon' => 'bi bi-building',
        ],

        [
            'text' => 'Sections',
            'url' => 'sections',
            'icon' => 'bi bi-diagram-3',
        ],

        [
            'text' => 'Fee Reports',
            'icon' => 'bi bi-cash-coin',

            'submenu' => [
                [
                    'text' => 'Fee Collection',
                    'url' => 'fees',
                    'icon' => 'bi bi-wallet2',
                ],

                [
                    'text' => 'Pending Fees',
                    'url' => 'fees/pending',
                    'icon' => 'bi bi-exclamation-circle-fill',
                ],

                [
                    'text' => 'Fee Reports',
                    'url' => 'fees/reports',
                    'icon' => 'bi bi-file-earmark-bar-graph-fill',
                ],
            ],
        ],

        [
            'text' => 'Examination',
            'icon' => 'bi bi-journal-text',

            'submenu' => [
                [
                    'text' => 'Examinations',
                    'url' => 'examinations',
                    'icon' => 'bi bi-file-earmark-text-fill',
                ],

                [
                    'text' => 'Exam Schedule',
                    'url' => 'examinations/schedule',
                    'icon' => 'bi bi-calendar-event-fill',
                ],

                [
                    'text' => 'Results',
                    'url' => 'results',
                    'icon' => 'bi bi-award-fill',
                ],
            ],
        ],

        [
            'text' => 'Staff Records',
            'icon' => 'bi bi-person-workspace',

            'submenu' => [
                [
                    'text' => 'All Staff',
                    'url' => 'staff',
                    'icon' => 'bi bi-people-fill',
                ],

                [
                    'text' => 'Add Staff',
                    'url' => 'staff/create',
                    'icon' => 'bi bi-person-plus-fill',
                ],

                [
                    'text' => 'Staff Attendance',
                    'url' => 'staff-attendance',
                    'icon' => 'bi bi-calendar-check-fill',
                ],
            ],
        ],

        [
            'text' => 'Transport',
            'icon' => 'bi bi-bus-front-fill',

            'submenu' => [
                [
                    'text' => 'Transport Routes',
                    'url' => 'transport/routes',
                    'icon' => 'bi bi-signpost-2-fill',
                ],

                [
                    'text' => 'Vehicles',
                    'url' => 'transport/vehicles',
                    'icon' => 'bi bi-bus-front',
                ],

                [
                    'text' => 'Drivers',
                    'url' => 'transport/drivers',
                    'icon' => 'bi bi-person-badge-fill',
                ],
            ],
        ],

        [
            'text' => 'Finance',
            'icon' => 'bi bi-wallet-fill',

            'submenu' => [
                [
                    'text' => 'Income',
                    'url' => 'finance/income',
                    'icon' => 'bi bi-arrow-down-circle-fill',
                ],

                [
                    'text' => 'Expenses',
                    'url' => 'finance/expenses',
                    'icon' => 'bi bi-arrow-up-circle-fill',
                ],

                [
                    'text' => 'Financial Reports',
                    'url' => 'finance/reports',
                    'icon' => 'bi bi-bar-chart-fill',
                ],
            ],
        ],

        [
            'text' => 'Messaging',
            'icon' => 'bi bi-chat-dots-fill',

            'submenu' => [
                [
                    'text' => 'Messages',
                    'url' => 'messages',
                    'icon' => 'bi bi-envelope-fill',
                ],

                [
                    'text' => 'Announcements',
                    'url' => 'announcements',
                    'icon' => 'bi bi-megaphone-fill',
                ],
            ],
        ],

        [
            'header' => 'REPORTS',
        ],

        [
            'text' => 'Student Reports',
            'url' => 'reports/students',
            'icon' => 'bi bi-bar-chart-line-fill',
        ],

        [
            'text' => 'Attendance Reports',
            'url' => 'reports/attendance',
            'icon' => 'bi bi-calendar2-check-fill',
        ],

        [
            'text' => 'Academic Reports',
            'url' => 'reports/academic',
            'icon' => 'bi bi-mortarboard-fill',
        ],

        [
            'header' => 'ADMINISTRATION',
        ],

        [
            'text' => 'Users',
            'url' => 'users',
            'icon' => 'bi bi-people-fill',
        ],

        [
            'text' => 'Branches',
            'url' => 'branches',
            'icon' => 'bi bi-diagram-3-fill',
        ],

        [
            'text' => 'Settings',
            'url' => 'settings',
            'icon' => 'bi bi-gear-fill',
        ],
    ],

  
    'filters' => [
        GateFilter::class,
        HrefFilter::class,
        ActiveFilter::class,
        SearchFilter::class,
    ],

   

    'plugins' => [

        'flatpickr' => [
            'enabled' => false,
            'css' => 'vendor/flatpickr/flatpickr.min.css',
            'js' => 'vendor/flatpickr/flatpickr.min.js',
        ],

        'tom_select' => [
            'enabled' => false,
            'css' => 'vendor/tom-select/tom-select.bootstrap5.min.css',
            'js' => 'vendor/tom-select/tom-select.complete.min.js',
        ],

        'tabulator' => [
            'enabled' => false,
            'css' => 'vendor/tabulator-tables/tabulator.min.css',
            'js' => 'vendor/tabulator-tables/tabulator.min.js',
        ],

        'quill' => [
            'enabled' => false,
            'css' => 'vendor/quill/quill.snow.css',
            'js' => 'vendor/quill/quill.min.js',
        ],

        'apexcharts' => [
            'enabled' => false,
            'js' => 'vendor/apexcharts/apexcharts.min.js',
        ],

        'jsvectormap' => [
            'enabled' => false,
            'css' => 'vendor/jsvectormap/jsvectormap.min.css',
            'js' => [
                'vendor/jsvectormap/jsvectormap.min.js',
                'vendor/jsvectormap/maps/world.js',
            ],
        ],

        'fullcalendar' => [
            'enabled' => false,
            'css' => 'vendor/fullcalendar/index.global.min.css',
            'js' => 'vendor/fullcalendar/index.global.min.js',
        ],

        'sortablejs' => [
            'enabled' => false,
            'js' => 'vendor/sortablejs/sortablejs.min.js',
        ],
    ],

];
