<header class="sticky-top bg-dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="header">
        <i id="toggle-list" class="bi bi-list btn btn-dark btn-list">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
        </i>
        <nav class=" header-content navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Admin
                </button>
            </div>
        </nav>
    </div>
</header>
