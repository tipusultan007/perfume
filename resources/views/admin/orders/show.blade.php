@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)
@section('page_title', 'Order Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4 mt-3">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light border shadow-sm rounded-3">
                    <i class="ri-arrow-left-line"></i>
                </a>
                <h3 class="m-0 fw-bold text-dark">Order <span class="text-muted fw-medium">#{{ $order->order_number }}</span></h3>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-light border shadow-sm fw-bold text-uppercase fs-11 tracking-wider rounded-3">
                    <i class="ri-download-2-line me-1"></i> Invoice
                </a>
                
                <div class="dropdown">
                    <button class="btn btn-light border shadow-sm fw-bold text-uppercase fs-11 tracking-wider rounded-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                        <li>
                            <form action="{{ route('admin.orders.resend-details', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item fw-bold text-uppercase fs-11 tracking-wider text-secondary py-2">
                                    <i class="ri-mail-send-line me-1 opacity-50"></i> Resend Order Details
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left: Order Items -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-light border-bottom p-4 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 fw-bold text-dark text-uppercase tracking-widest fs-12">Items Ordered</h5>
                    <span class="fs-10 fw-bold text-muted text-uppercase tracking-widest">Quantity: {{ $order->items->count() }} line items</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap mb-0 align-middle">
                        <thead class="bg-light">
                            <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                <th class="ps-4 py-3">Product Information</th>
                                <th class="py-3">Unit Price</th>
                                <th class="py-3">Qty</th>
                                <th class="pe-4 py-3 text-end">Sum Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->product && $item->product->hasMedia('featured_image'))
                                            <div class="rounded-3 border p-1 bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <img src="{{ $item->product->getFirstMediaUrl('featured_image', 'thumb') }}" class="img-fluid rounded-2" alt="Product Image">
                                            </div>
                                        @else
                                            <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center text-muted fs-10 fw-bold text-uppercase" style="width: 50px; height: 50px;">
                                                No Img
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="m-0 fs-14 fw-bold text-dark">{{ $item->product_name }}</h6>
                                            @if($item->variant_name)
                                                <div class="fs-10 text-uppercase tracking-widest fw-bold text-secondary mt-1">{{ $item->variant_name }}</div>
                                            @endif
                                            <div class="fs-10 font-monospace fw-bold text-muted mt-1 tracking-wider">{{ $item->sku }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 font-monospace fs-13 fw-bold text-secondary">${{ number_format($item->price, 2) }}</td>
                                <td class="py-3 font-monospace fs-13 fw-bold text-secondary">x{{ $item->quantity }}</td>
                                <td class="pe-4 py-3 text-end font-monospace fs-14 fw-bold text-dark">${{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light p-4 border-top d-flex justify-content-end">
                    <div class="w-100" style="max-width: 300px;">
                        <div class="d-flex justify-content-between mb-3 fs-11 text-uppercase tracking-widest fw-bold text-secondary">
                            <span>Subtotal</span>
                            <span class="text-dark font-monospace">${{ number_format($order->items->sum('total'), 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fs-11 text-uppercase tracking-widest fw-bold text-secondary">
                            <span>Shipping</span>
                            <span class="text-dark font-monospace">${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 fs-11 text-uppercase tracking-widest fw-bold text-secondary">
                            <span>Tax</span>
                            <span class="text-dark font-monospace">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top fs-14 fw-bold">
                            <span class="text-dark text-uppercase tracking-widest">Grand Total</span>
                            <span class="text-dark font-monospace">${{ number_format($order->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Governance, Customer & Notes -->
        <div class="col-lg-4">
            
            <!-- Status Management -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark text-uppercase tracking-widest fs-12 mb-4 border-bottom pb-3">Order Governance</h5>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fs-10 text-uppercase tracking-widest text-secondary fw-bold mb-2">Logistics Status</label>
                            <select name="status" class="form-select form-select-lg fs-14 fw-bold text-dark shadow-sm">
                                @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'] as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fs-10 text-uppercase tracking-widest text-secondary fw-bold mb-2">Financing Status</label>
                            <select name="payment_status" class="form-select form-select-lg fs-14 fw-bold text-dark shadow-sm">
                                @foreach(['pending', 'paid', 'failed'] as $status)
                                    <option value="{{ $status }}" {{ $order->payment_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-3 border-top mt-4">
                            <button type="submit" class="btn btn-dark w-100 py-3 fs-11 text-uppercase tracking-widest fw-bold shadow">
                                Commit Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Notes (WooCommerce Style) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-light border-bottom p-4">
                    <h5 class="card-title m-0 fw-bold text-dark text-uppercase tracking-widest fs-12">Order Notes</h5>
                </div>
                
                <div class="card-body p-4 overflow-auto" style="max-height: 400px;">
                    @forelse($order->orderNotes as $note)
                        <div class="position-relative ps-3 border-start border-2 {{ $note->is_customer_notified ? 'border-success bg-success-subtle mx-n4 px-4 py-3 rounded-end' : 'border-light mb-4' }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fs-10 fw-bold text-uppercase tracking-widest {{ $note->is_customer_notified ? 'text-success' : 'text-secondary' }}">
                                    {{ $note->author->name }}
                                </span>
                                <span class="fs-10 font-monospace text-muted text-uppercase">{{ $note->created_at->format('M d, H:i') }}</span>
                            </div>
                            <p class="fs-13 text-dark mb-0 fw-medium">{{ $note->note }}</p>
                            @if($note->is_customer_notified)
                                <div class="mt-2 d-flex align-items-center gap-1 fs-10 fw-bold text-uppercase tracking-widest text-success">
                                    <i class="ri-checkbox-circle-line"></i> Customer Notified
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="ri-chat-history-line display-4 mb-2 opacity-25"></i>
                            <span class="d-block fs-10 fw-bold text-uppercase tracking-widest opacity-50">No notes recorded</span>
                        </div>
                    @endforelse
                </div>

                <div class="card-footer bg-light p-4 border-top">
                    <form action="{{ route('admin.orders.notes.store', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="note" rows="3" placeholder="Append a note to this order..." 
                                class="form-control fs-13 shadow-sm" required></textarea>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input shadow-sm" type="checkbox" name="is_customer_notified" value="1" id="notifyCustomer">
                                <label class="form-check-label fs-10 fw-bold text-uppercase tracking-widest text-secondary mt-1 cursor-pointer" for="notifyCustomer">
                                    Notify Customer
                                </label>
                            </div>
                            <button type="submit" class="btn btn-dark px-4 py-2 fs-10 fw-bold text-uppercase tracking-widest shadow-sm">
                                Add Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark text-uppercase tracking-widest fs-12 mb-4 border-bottom pb-3">Client Dossier</h5>
                    
                    <div class="mb-4">
                        <span class="d-block fs-10 text-uppercase tracking-widest text-secondary fw-bold mb-2">Legal Name</span>
                        <span class="fs-14 fw-bold text-dark">
                            {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? 'Guest Customer' }}
                        </span>
                    </div>
                    
                    @if($order->notes)
                    <div class="mb-4 p-3 bg-warning-subtle rounded-3 border border-warning">
                        <span class="d-block fs-10 text-uppercase tracking-widest text-warning fw-bold mb-2">Customer Note (Checkout)</span>
                        <p class="fs-13 text-dark mb-0 fw-medium fst-italic">"{{ $order->notes }}"</p>
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <span class="d-block fs-10 text-uppercase tracking-widest text-secondary fw-bold mb-2">Electronic Mail</span>
                        <a href="mailto:{{ $order->shipping_address['email'] ?? '' }}" class="d-block fs-14 fw-bold text-dark text-decoration-none">{{ $order->shipping_address['email'] ?? 'N/A' }}</a>
                        <span class="d-block fs-12 fw-bold text-secondary mt-1">{{ $order->shipping_address['phone'] ?? 'N/A' }}</span>
                    </div>

                    <div class="mb-4 p-3 bg-light rounded-3 border">
                        <span class="d-block fs-10 text-uppercase tracking-widest text-secondary fw-bold mb-2">Courier Destination</span>
                        <p class="fs-13 fw-bold text-dark mb-0 text-uppercase tracking-wide">
                            {{ $order->shipping_address['address'] ?? '' }}<br>
                            <span class="text-secondary">{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}</span>
                        </p>
                    </div>

                    <div class="pt-4 border-top">
                         <span class="d-block fs-10 text-uppercase tracking-widest text-secondary fw-bold mb-2">Billing Records</span>
                         @if(json_encode($order->shipping_address) === json_encode($order->billing_address))
                            <span class="fs-10 fw-bold text-muted text-uppercase tracking-widest fst-italic">Synchronized with shipping</span>
                         @else
                            <p class="fs-13 fw-bold text-dark mb-0 text-uppercase tracking-wide">
                                {{ $order->billing_address['address'] ?? '' }}<br>
                                <span class="text-secondary">{{ $order->billing_address['city'] ?? '' }} {{ $order->billing_address['zip'] ?? '' }}</span>
                            </p>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-10 { font-size: 10px !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .tracking-wide { letter-spacing: 0.025em; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fallback in case $.toast is still not attached
        if (typeof window.$ === 'undefined' || typeof $.toast !== 'function') {
            console.error("Toast plugin not loaded properly.");
            return;
        }

        @if(session('success'))
            $.toast({
                heading: 'Success',
                text: "{{ session('success') }}",
                position: 'top-right',
                loaderBg: '#0f172a',
                icon: 'success',
                hideAfter: 3000,
                stack: 1
            });
        @endif

        @if(session('error'))
            $.toast({
                heading: 'Error',
                text: "{{ session('error') }}",
                position: 'top-right',
                loaderBg: '#0f172a',
                icon: 'error',
                hideAfter: 3000,
                stack: 1
            });
        @endif
    });
</script>
@endsection
