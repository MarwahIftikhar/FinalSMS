@php
    $navLeft = app('adminlte')->menu('navbar-left');
@endphp
<nav class="app-header {{ config('adminlte.classes_topnav', 'navbar-expand bg-body') }} navbar">
    <div class="{{ config('adminlte.classes_topnav_container', 'container-fluid') }}">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar"><i class="bi bi-list" aria-hidden="true"></i></a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ url('/') }}" class="nav-link"><i class="bi bi-grid-1x2 me-1" aria-hidden="true"></i> Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ config('adminlte.sidebar_docs_url', '#') }}" class="nav-link" target="_blank" rel="noopener"><i class="bi bi-book me-1" aria-hidden="true"></i> Documentation</a></li>
            @foreach ($navLeft as $item)
                <li class="nav-item d-none d-md-block"><a href="{{ $item['href'] ?? '#' }}" class="nav-link">{{ $item['text'] ?? '' }}</a></li>
            @endforeach
        </ul>

        <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item dropdown me-lg-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" data-bs-toggle="dropdown" aria-expanded="false" title="Branches">
                        <i class="bi bi-diagram-3-fill"></i>
                        <span class="d-none d-lg-inline">Branches: {{ $activeBranch?->name ?? 'No branch' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (auth()->user()->is_admin)
                            <li><a class="dropdown-item fw-semibold text-primary" href="{{ route('branches.create') }}"><i class="bi bi-plus-lg me-1"></i> Add Branch</a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li><h6 class="dropdown-header">Select Branch</h6></li>
                        @forelse ($availableBranches as $branch)
                            <li>
                                <form method="POST" action="{{ route('branches.switch') }}">
                                    @csrf
                                    <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                    <button type="submit" class="dropdown-item {{ $activeBranch?->id === $branch->id ? 'active' : '' }}">{{ $branch->name }}<small class="d-block text-muted">{{ $branch->location }}</small></button>
                                </form>
                            </li>
                        @empty
                            <li><span class="dropdown-item-text">No active branches</span></li>
                        @endforelse
                    </ul>
                </li>
            @endauth
            <li class="nav-item d-flex align-items-center me-lg-2"><button type="button" data-adminlte-search aria-label="Search" class="adminlte-search-trigger btn btn-sm border rounded-pill d-flex align-items-center gap-2 px-2 px-lg-3 text-body-secondary"><i class="bi bi-search" aria-hidden="true"></i><span class="d-none d-lg-inline">Search…</span></button></li>
            @include('adminlte::partials.navbar-messages')
            @include('adminlte::partials.navbar-notifications')
            <li class="nav-item"><a class="nav-link" href="#" data-lte-toggle="fullscreen" aria-label="Toggle fullscreen"><i data-lte-icon="maximize" class="bi bi-arrows-fullscreen" aria-hidden="true"></i><i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none" aria-hidden="true"></i></a></li>
            @if (config('adminlte.color_mode_toggle', true)) @include('adminlte::partials.color-mode') @endif
            @if (config('adminlte.control_sidebar', false)) @include('adminlte::partials.control-sidebar') @endif
            @if (config('adminlte.usermenu_enabled', true)) @include('adminlte::partials.usermenu') @endif
        </ul>
    </div>
</nav>
@include('adminlte::partials.command-palette')
