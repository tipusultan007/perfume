@extends('layouts.store')

@section('styles')
<style>
    .account-page-wrapper {
        padding: 160px 5% 100px;
        background: #f8f9fa;
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .account-box {
        display: grid;
        grid-template-columns: 300px 1fr;
        background: var(--white);
        width: 100%;
        max-width: 1200px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        overflow: hidden;
    }

    .account-sidebar {
        padding: 60px 40px;
        border-right: 1px solid #e5e7eb;
        background: #fff;
    }

    .account-sidebar h2 {
        font-size: 2rem;
        margin-bottom: 40px;
        letter-spacing: -0.02em;
        color: #111;
        font-weight: 600;
        font-family: 'Playfair Display', serif;
    }

    .account-nav {
        list-style: none;
        padding: 0;
    }

    .account-nav li {
        margin-bottom: 5px;
    }

    .account-nav a {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        font-size: 16px;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        color: #64748b; /* Slate 500 */
        border-radius: 8px;
        text-decoration: none;
    }
    
    .account-nav a:hover {
        background-color: #fffbf0; /* Very light gold tint */
        color: #bfa15f; /* Gold text */
        transform: translateX(5px);
        border: 1px solid #f0e6cc;
    }

    .account-nav li.active a {
        background: linear-gradient(135deg, #d4af37 0%, #aa8429 100%); /* Metallic Gold Gradient */
        color: #fff;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
        border: none;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .account-content {
        padding: 60px 60px;
    }

    .account-content h3 {
        font-size: 28px;
        margin-bottom: 40px;
        font-family: 'Cormorant Garamond';
        border-bottom: 1px solid var(--border);
        padding-bottom: 20px;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
    }

    .stat-card {
        padding: 30px;
        background: var(--cream);
        border: 1px solid var(--border);
    }

    .stat-card h4 {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
        margin-bottom: 15px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-card .value {
        font-size: 24px;
        font-family: 'Cormorant Garamond';
    }

    /* Tables */
    .account-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .account-table th {
        text-align: left;
        padding: 15px;
        border-bottom: 1px solid var(--black);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .account-table td {
        padding: 20px 15px;
        border-bottom: 1px solid var(--border);
    }

    .status-badge {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 4px 8px;
        background: #eee;
    }

    .status-completed { background: #e8f5e9; color: #2e7d32; }
    .status-pending { background: #fff8e1; color: #f57f17; }
    .status-cancelled { background: #ffebee; color: #c62828; }

    /* Forms */
    .account-form {
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        opacity: 0.7;
    }

    .form-group input {
        width: 100%;
        padding: 12px 0;
        border: none;
        border-bottom: 1px solid var(--border);
        background: transparent;
        font-family: 'Montserrat';
        font-size: 15px;
        outline: none;
        transition: var(--transition);
    }

    .form-group input:focus {
        border-bottom-color: var(--black);
    }

    .btn-save {
        padding: 15px 40px;
        background: var(--black);
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        cursor: pointer;
        border: none;
    }

    @media (max-width: 991px) {
        .account-page-wrapper {
            padding: 40px 20px;
        }

        .account-box {
            grid-template-columns: 1fr;
        }
        
        .account-sidebar {
            border-right: none;
            border-bottom: 1px solid var(--border);
            padding: 40px 20px;
            text-align: center;
        }

        .account-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .account-nav a {
            border: 1px solid var(--border);
            padding: 8px 15px;
        }

        .account-content {
            padding: 40px 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="account-page-wrapper">
    <div class="account-box">
        <aside class="account-sidebar">
            <h2 class="serif">My Account</h2>
            <ul class="account-nav">
                <li class="{{ request()->routeIs('account.index') ? 'active' : '' }}">
                    <a href="{{ route('account.index') }}">
                        <i class="fa-solid fa-gauge-high" style="width: 20px; margin-right: 10px;"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('account.orders*') ? 'active' : '' }}">
                    <a href="{{ route('account.orders') }}">
                        <i class="fa-solid fa-bag-shopping" style="width: 20px; margin-right: 10px;"></i> Orders
                    </a>
                </li>
                <li class="{{ request()->routeIs('account.addresses') ? 'active' : '' }}">
                    <a href="{{ route('account.addresses') }}">
                        <i class="fa-solid fa-map-location-dot" style="width: 20px; margin-right: 10px;"></i> Addresses
                    </a>
                </li>
                <li class="{{ request()->routeIs('account.details') ? 'active' : '' }}">
                    <a href="{{ route('account.details') }}">
                        <i class="fa-solid fa-user-gear" style="width: 20px; margin-right: 10px;"></i> Account Details
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="width: 20px; margin-right: 10px;"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <div class="account-content">
            @yield('account_content')
        </div>
    </div>
</div>
@endsection
