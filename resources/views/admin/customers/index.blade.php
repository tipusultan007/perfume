@extends('admin.layouts.app')

@section('title', 'Customers')
@section('page_title', 'Customers')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customers</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Customers Management</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.customers.index') }}" method="GET" class="d-flex gap-2">
                                <div class="search-box">
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name or email...">
                                </div>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i> Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.customers.index') }}" class="btn btn-soft-dark">Clear</a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-11 fw-bold tracking-wider">
                                    <th style="width: 80px;">ID</th>
                                    <th>Customer Info</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th class="text-center">Orders</th>
                                    <th class="text-end" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                <tr>
                                    <td class="text-muted fw-semibold">#{{ $customer->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle fw-bold uppercase">
                                                        {{ substr($customer->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h5 class="my-0 fs-14 fw-bold text-dark">{{ $customer->name }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted fw-medium">{{ $customer->email }}</td>
                                    <td class="text-muted fs-12 fw-semibold">{{ $customer->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        @if($customer->orders_count > 0)
                                            <span class="badge bg-primary rounded-pill px-2 py-1 fs-11">{{ $customer->orders_count }} Orders</span>
                                        @else
                                            <span class="text-muted opacity-50">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-soft-info btn-sm" title="View Details">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" 
                                                onsubmit="return confirm('Are you sure you want to delete this customer?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm" title="Delete Customer">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ri-user-search-line fs-48 opacity-20"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No customers found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($customers->hasPages())
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-sm { height: 32px; width: 32px; }
    .avatar-title { font-size: 14px; }
    .fs-11 { font-size: 11px; }
    .fs-12 { font-size: 12px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
</style>
@endsection
