@extends('layouts.store')

@section('styles')
<style>
    .account-page-wrapper {
        padding: 100px 5%;
        background: #fcfcfc;
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .account-box {
        display: grid;
        grid-template-columns: 280px 1fr;
        background: var(--white);
        width: 100%;
        max-width: 1200px;
        border: 1px solid var(--border);
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    }

    .account-sidebar {
        padding: 60px 40px;
        border-right: 1px solid var(--border);
        background: #fafafa;
    }

    .account-sidebar h2 {
        font-size: 1.8rem;
        margin-bottom: 40px;
        letter-spacing: 1px;
    }

    .account-nav {
        list-style: none;
        padding: 0;
    }

    .account-nav li {
        margin-bottom: 5px;
    }

    .account-nav a {
        display: block;
        padding: 12px 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: var(--transition);
        color: rgba(0,0,0,0.5);
    }

    .account-nav a:hover, .account-nav li.active a {
        color: var(--black);
        padding-left: 5px;
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
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.5;
        margin-bottom: 10px;
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
        font-family: 'Inter';
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
                    <a href="{{ route('account.index') }}">Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('account.orders*') ? 'active' : '' }}">
                    <a href="{{ route('account.orders') }}">Orders</a>
                </li>
                <li class="{{ request()->routeIs('account.addresses') ? 'active' : '' }}">
                    <a href="{{ route('account.addresses') }}">Addresses</a>
                </li>
                <li class="{{ request()->routeIs('account.details') ? 'active' : '' }}">
                    <a href="{{ route('account.details') }}">Account Details</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>
            </ul>
        </aside>

        <div class="account-content">
            @yield('account_content')
        </div>
    </div>
</div>
@endsection
