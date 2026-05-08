@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">NewKirk</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </div>
                <h4 class="page-title">Product Reviews</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-3 mb-4 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Search</label>
                            <input type="text" name="search" class="form-control rounded-pill border-light" placeholder="User, Email, Comment..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select rounded-pill border-light">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Rating</label>
                            <select name="rating" class="form-select rounded-pill border-light">
                                <option value="">All Ratings</option>
                                @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">
                                <i class="ri-filter-3-line me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-light rounded-pill px-4">
                                <i class="ri-refresh-line me-1"></i> Reset
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs">
                                                <span class="avatar-title bg-soft-primary text-primary rounded-circle fw-bold">
                                                    {{ substr($review->user_name ?? $review->user->name ?? 'G', 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ms-2">
                                                <h5 class="my-0 fs-14">{{ $review->user_name ?? $review->user->name ?? 'Guest' }}</h5>
                                                <small class="text-muted">{{ $review->user_email ?? $review->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $review->product_id) }}" class="text-body fw-semibold">
                                            {{ \Illuminate\Support\Str::limit($review->product->name, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ri-star-{{ $i <= $review->rating ? 'fill' : 'line' }} text-warning"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        <small class="text-muted" title="{{ $review->comment }}">
                                            {{ \Illuminate\Support\Str::limit($review->comment, 50) }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill {{ $review->status === 'approved' ? 'bg-soft-success text-success' : 'bg-soft-warning text-warning' }} px-3 py-1">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $review->status === 'approved' ? 'btn-soft-warning' : 'btn-soft-success' }}" data-bs-toggle="tooltip" title="{{ $review->status === 'approved' ? 'Pend' : 'Approve' }}">
                                                    <i class="ri-{{ $review->status === 'approved' ? 'close-circle' : 'checkbox-circle' }}-line"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ri-feedback-line fs-48"></i>
                                            <p class="mt-2">No reviews found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 pagination-newkirk">
                        {{ $reviews->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
