<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Removed Vite to avoid Node/npm dependency in this environment -->
    <style>
        :root {
            --brand-primary: #2563eb; /* blue-600 */
            --brand-primary-700: #1d4ed8;
            --brand-primary-50: #eef2ff;
            --brand-accent: #22c55e; /* green-500 */
            --brand-danger: #ef4444;
            --brand-warning: #f59e0b;
            --success-gradient: linear-gradient(90deg, #16a34a, #22c55e);
            --warning-gradient: linear-gradient(90deg, #d97706, #f59e0b);
            --info-gradient: linear-gradient(90deg, #0ea5e9, #6366f1);
            --danger-gradient: linear-gradient(90deg, #ef4444, #f97316);
            --surface-1: #ffffff; --surface-2: #f8fafc; --text-muted: #6b7280;
        }
        /* App background with stronger, pleasing gradients */
        html, body { height: 100%; }
        body {
            background-color: #e6f0ff; /* fallback */
            background-image:
                radial-gradient(900px 500px at 10% -10%, rgba(59,130,246,.35), transparent 60%),
                radial-gradient(900px 500px at 110% 0%, rgba(34,197,94,.28), transparent 60%),
                linear-gradient(180deg, #f6fbff 0%, #edf4ff 50%, #eafdf4 100%);
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .sticky-header { position: sticky; top: 0; z-index: 1030; }
        .navbar-elevated { background: linear-gradient(180deg, #ffffff, #f8fafc); border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
        .navbar-nav { align-items: center; gap: .75rem; }
        .nav-link { color:#374151 !important; border-radius: 10px; padding: .5rem .85rem; line-height: 1; display: inline-flex; align-items: center; gap: .45rem; }
        .nav-link i { color:#334155; }
        .nav-link:hover { background: #eef2ff; color:#1d4ed8 !important; }
        .nav-link.active { background:#e0e7ff; color:#1d4ed8 !important; font-weight: 600; box-shadow: inset 0 0 0 1px rgba(29,78,216,.12); }
        .navbar-brand { font-weight: 700; letter-spacing: .2px; display: inline-flex; align-items: center; padding: .375rem 0; }
        .navbar-brand i { color:#0f172a; }
        .navbar-actions .btn-icon { width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color:#334155; border: 1px solid #e5e7eb; background: #fff; }
        .navbar-actions .btn-icon:hover { background:#f1f5f9; }
        /* Small icon button used in tables */
        .btn-icon-sm { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; }
        .table thead th.border-0 { border: 0; }
        .badge.fs-6 { font-size: 1rem; }
        .card { background: var(--surface-1); border: 1px solid #e5e7eb; }
        .card.shadow-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
        .card:hover { box-shadow: 0 10px 28px rgba(0,0,0,.06)!important; }
        /* Button system - consistent lively interactions */
        .btn { position: relative; overflow: hidden; }
        .btn-primary { background-color: var(--brand-primary); border-color: var(--brand-primary); box-shadow: 0 2px 10px rgba(37,99,235,.25); }
        .btn-primary:hover { background-color: var(--brand-primary-700); border-color: var(--brand-primary-700); box-shadow: 0 6px 18px rgba(37,99,235,.35); transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); box-shadow: 0 2px 10px rgba(37,99,235,.25); }
        .btn-outline-primary { color: var(--brand-primary); border-color: var(--brand-primary); }
        .btn-outline-primary:hover { background-color: var(--brand-primary); border-color: var(--brand-primary); color: #fff; box-shadow: 0 6px 18px rgba(37,99,235,.25); }
        .btn-secondary { background-color: #475569; border-color: #475569; }
        .btn-secondary:hover { background-color: #334155; border-color: #334155; }
        .btn-danger { background-color: var(--brand-danger); border-color: var(--brand-danger); }
        .btn-danger:hover { background-color: #dc2626; border-color: #dc2626; }
        .btn-warning { background-color: var(--brand-warning); border-color: var(--brand-warning); color:#111827; }
        .btn-warning:hover { background-color: #d97706; border-color: #d97706; color:#111827; }
        .page-header h2 { margin-bottom: .25rem; }
        .page-header p { color: var(--text-muted); }
        /* Liveliness helpers */
        .fade-in { animation: fadeIn .4s ease both; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
        .hover-lift { transition: transform .15s ease, box-shadow .15s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(0,0,0,.08)!important; }
        .text-gradient-success { background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-gradient-warning { background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-gradient-info { background: var(--info-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .badge-soft-success { color: #166534; background: rgba(34,197,94,.12); }
        .badge-soft-warning { color: #92400e; background: rgba(245,158,11,.15); }
        .badge-soft-danger { color: #991b1b; background: rgba(239,68,68,.12); }
        .table-modern tbody tr { transition: background-color .15s ease; }
        .table-modern tbody tr:hover { background-color: #f3f4f6; }
        .table-modern thead { border-bottom: 1px solid #e5e7eb; }
        .btn-shadow { box-shadow: 0 2px 10px rgba(37,99,235,.25); }
        .btn-shadow:hover { box-shadow: 0 6px 18px rgba(37,99,235,.35); }
        .rounded-12 { border-radius: 12px; }
        .section-title { font-weight: 700; letter-spacing: .2px; }
        /* Categories grid polish */
        .category-grid .category-card { border: 1px solid #e5e7eb; border-radius: 12px; transition: box-shadow .2s ease, transform .2s ease; background: var(--surface-1); }
        .category-grid .category-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
        .category-grid .card-body { padding: 1rem 1.25rem; display: flex; flex-direction: column; }
        .category-grid .card-title { font-weight: 600; }
        .category-grid .card-text { color: var(--text-muted); display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 3.6em; }
        .category-grid .card-footer { background: transparent; border-top: 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-header navbar-elevated">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" style="color:#111827;">
                <i class="fas fa-warehouse me-2"></i>
                <span>Inventory System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Products</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <!-- Global Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" data-confirm-title>Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" data-confirm-body>Are you sure you want to delete this item? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            // Theme toggle removed
            const modalEl = document.getElementById('confirmDeleteModal');
            if (!modalEl) return;
            const modal = new bootstrap.Modal(modalEl);
            let targetForm = null;

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-delete-form]');
                if (!btn) return;
                e.preventDefault();
                const formId = btn.getAttribute('data-delete-form');
                targetForm = document.getElementById(formId);
                const name = btn.getAttribute('data-item-name') || 'this item';
                const title = modalEl.querySelector('[data-confirm-title]');
                const body = modalEl.querySelector('[data-confirm-body]');
                if (title) title.textContent = 'Delete Confirmation';
                if (body) body.textContent = `Are you sure you want to delete ${name}? This action cannot be undone.`;
                modal.show();
            });

            const confirmBtn = document.getElementById('confirmDeleteButton');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', () => {
                    if (targetForm) targetForm.submit();
                });
            }
        })();
        // Enable Bootstrap tooltips globally
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
