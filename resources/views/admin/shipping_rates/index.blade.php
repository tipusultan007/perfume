@extends('admin.layouts.app')

@section('title', 'Shipping Rates')
@section('page_title', 'Shipping Rates')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Shipping Rates</li>
                    </ol>
                </div>
                <h4 class="page-title">Shipping Rates</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- List of Shipping Rates -->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title m-0">Active Shipping Rates</h4>
                        <form action="{{ route('admin.shipping-rates.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search rates..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            @if(request('search'))
                                <a href="{{ route('admin.shipping-rates.index') }}" class="btn btn-sm btn-light ms-1">Clear</a>
                            @endif
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-11 fw-bold tracking-wider">
                                    <th>Name</th>
                                    <th>State / ZIP</th>
                                    <th>Cost</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shippingRates as $rate)
                                <tr>
                                    <td>
                                        <h5 class="my-0 fs-14 fw-bold text-dark">{{ $rate->name }}</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-11 fw-semibold text-uppercase opacity-75">
                                            @if($rate->zip_code)
                                                ZIP: {{ $rate->zip_code }}
                                            @elseif($rate->state_code)
                                                State: {{ $rate->state_code }}
                                            @else
                                                Global
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-dark text-dark fw-bold px-2 py-1 fs-12 font-monospace border">
                                            ${{ number_format($rate->cost, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($rate->is_active)
                                            <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Active</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-soft-primary btn-sm me-1 edit-shipping-btn" 
                                            title="Edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editShippingModal"
                                            data-shipping='{{ json_encode($rate) }}'>
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <form action="{{ route('admin.shipping-rates.destroy', $rate) }}" method="POST" 
                                            onsubmit="return confirm('Delete this shipping rate?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-truck-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No shipping rates defined</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $shippingRates->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Shipping Rate -->
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Add Shipping Rate</h4>
                    
                    <form action="{{ route('admin.shipping-rates.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Display Name</label>
                            <input type="text" name="name" required placeholder="e.g. Standard Shipping" 
                                class="form-control fw-semibold">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Cost ($)</label>
                                <input type="number" step="0.01" name="cost" required placeholder="10.00" 
                                    class="form-control fw-bold">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">State (2 Char)</label>
                                <input type="text" name="state_code" maxlength="2" placeholder="NY" 
                                    class="form-control fw-bold text-uppercase">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">ZIP Code Override</label>
                            <input type="text" name="zip_code" maxlength="10" placeholder="e.g. 10001 (Optional)" 
                                class="form-control fw-semibold">
                        </div>

                        <div class="bg-light p-3 rounded mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                                <label class="form-check-label fs-12 fw-bold text-muted ms-1" for="isActive">ACTIVE STATUS</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold text-uppercase fs-11 py-2">
                            <i class="ri-save-line me-1"></i> Save Shipping Rate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Shipping Modal -->
<div class="modal fade" id="editShippingModal" tabindex="-1" aria-labelledby="editShippingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editShippingModalLabel">Edit Shipping Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editShippingForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Display Name</label>
                        <input type="text" name="name" id="edit_name" required class="form-control fw-semibold">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Cost ($)</label>
                            <input type="number" step="0.01" name="cost" id="edit_cost" required class="form-control fw-bold">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">State (2 Char)</label>
                            <input type="text" name="state_code" id="edit_state_code" maxlength="2" class="form-control fw-bold text-uppercase">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">ZIP Code Override</label>
                        <input type="text" name="zip_code" id="edit_zip_code" maxlength="10" class="form-control fw-semibold">
                    </div>

                    <div class="bg-light p-3 rounded mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active" value="1">
                            <label class="form-check-label fs-12 fw-bold text-muted ms-1" for="edit_is_active">ACTIVE STATUS</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.edit-shipping-btn');
        const editForm = document.getElementById('editShippingForm');
        
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const shipping = JSON.parse(this.getAttribute('data-shipping'));
                
                // Update form action URL dynamically
                let actionUrl = "{{ route('admin.shipping-rates.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', shipping.id);
                editForm.action = actionUrl;
                
                // Populate fields
                document.getElementById('edit_name').value = shipping.name;
                document.getElementById('edit_cost').value = shipping.cost;
                document.getElementById('edit_state_code').value = shipping.state_code || '';
                document.getElementById('edit_zip_code').value = shipping.zip_code || '';
                
                // Checkboxes
                document.getElementById('edit_is_active').checked = shipping.is_active == 1;
            });
        });
    });
</script>
@endsection

<style>
    .fs-11 { font-size: 11px; }
    .fs-10 { font-size: 10px; }
    .fs-12 { font-size: 12px; }
    .fs-14 { font-size: 14px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
</style>
@endsection
