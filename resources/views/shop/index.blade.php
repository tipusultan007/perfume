@extends('layouts.store')

@section('title', "The Collection | L'ESSENCE NYC")

@section('styles')
<style>
    /* --- 2. Collection Header --- */
    .collection-header {
        padding: 140px 5% 40px;
        text-align: center;
        background: var(--cream);
        border-bottom: 1px solid var(--border);
    }

    .collection-header h1 {
        font-size: 3.5rem;
        margin-bottom: 10px;
    }

    .collection-header p {
        font-size: 13px;
        opacity: 0.6;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* --- 3. Shop Layout --- */
    .shop-container {
        display: flex;
        padding: 60px 5%;
        gap: 60px;
    }

    /* Sidebar Filter (Desktop) */
    .sidebar {
        width: 220px;
        flex-shrink: 0;
        position: sticky;
        top: 120px;
        height: fit-content;
    }

    .filter-section {
        margin-bottom: 40px;
    }

    .filter-section h4 {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 10px;
    }

    .filter-list li {
        margin-bottom: 12px;
        font-size: 13px;
        display: flex;
        align-items: center;
        cursor: pointer;
        opacity: 0.7;
    }

    .filter-list li:hover, .filter-list li.active {
        opacity: 1;
        color: var(--accent);
    }

    .filter-list input {
        margin-right: 12px;
        accent-color: var(--black);
        width: 14px;
        height: 14px;
        cursor: pointer;
    }

    /* Search Box */
    .search-filter {
        margin-bottom: 40px;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--border);
        padding-bottom: 5px;
        transition: var(--transition);
    }

    .search-input-wrapper:focus-within {
        border-bottom-color: var(--black);
    }

    .search-input-wrapper input {
        border: none;
        background: transparent;
        padding: 5px 30px 5px 0;
        width: 100%;
        font-size: 13px;
        outline: none;
        font-family: 'Inter', sans-serif;
    }

    .search-input-wrapper i {
        position: absolute;
        right: 0;
        opacity: 0.5;
        font-size: 16px;
    }

    /* ... Active Filters ... */
    .product-grid-container {
        flex-grow: 1;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 40px 20px;
    }

    /* ... Re-using base card styles from layout or shop.html ... */
    
    /* --- 4. Mobile Filter Bar --- */
    .mobile-filter-bar {
        display: none;
        position: sticky;
        top: 75px;
        background: white;
        z-index: 90;
        border-bottom: 1px solid var(--border);
        padding: 15px 5%;
        justify-content: space-between;
        align-items: center;
    }

    .filter-trigger-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        cursor: pointer;
    }

    /* --- 5. Offcanvas Filter --- */
    .offcanvas-filter {
        position: fixed;
        top: 0;
        left: -100%;
        width: 85%;
        height: 100vh;
        background: white;
        z-index: 2000;
        transition: var(--transition);
        padding: 40px 5%;
        overflow-y: auto;
    }

    .offcanvas-filter.active {
        left: 0;
    }

    .offcanvas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .filter-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1999;
        display: none;
    }

    .filter-overlay.active {
        display: block;
    }

    @media (max-width: 1200px) {
        .product-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }

        .mobile-filter-bar {
            display: flex;
        }

        .shop-container {
            padding-top: 30px;
            padding-left: 5%;
            padding-right: 5%;
        }
    }

    /* --- Active Filters --- */
    .active-filters-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
        align-items: center;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: var(--cream);
        border: 1px solid var(--border);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: var(--transition);
    }

    .filter-tag:hover {
        border-color: var(--black);
    }

    .filter-tag a {
        display: flex;
        align-items: center;
        font-size: 14px;
        opacity: 0.5;
    }

    .filter-tag a:hover {
        opacity: 1;
        color: #ff4d4d;
    }

    .clear-all-filters {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--accent);
        border-bottom: 1px solid transparent;
        margin-left: 10px;
    }

    .clear-all-filters:hover {
        border-bottom-color: var(--accent);
    }
</style>
@endsection

@section('content')
<header class="collection-header">
    <p class="mono">New York Atelier</p>
    <h1>The Collection</h1>
</header>

<div class="mobile-filter-bar">
    <div class="filter-trigger-btn" id="openFilter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 6h16M7 12h10m-7 6h4" />
        </svg>
        Filter By
    </div>
    <div class="mono" style="font-size: 9px;">{{ $products->total() }} Products</div>
</div>

<div class="shop-container">
    <aside class="sidebar">
        <form action="{{ route('shop') }}" method="GET" id="filterForm">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <div class="search-filter">
                <h4>Search</h4>
                <div class="search-input-wrapper">
                    <input type="text" name="search" placeholder="Type to search..." value="{{ $searchQuery }}">
                    <i class="ri-search-line"></i>
                </div>
            </div>

            <div class="filter-section">
                <h4>Categories</h4>
                <ul class="filter-list">
                    <li class="{{ !request('category') ? 'active' : '' }}">
                        <a href="{{ route('shop', array_merge(request()->except(['category', 'page']))) }}">All Products</a>
                    </li>
                    @foreach($categories as $category)
                        <li class="{{ request('category') == $category->slug ? 'active' : '' }}">
                            <a href="{{ route('shop', array_merge(request()->except(['page']), ['category' => $category->slug])) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if($brands->count() > 0)
            <div class="filter-section">
                <h4>Brands</h4>
                <ul class="filter-list">
                    @foreach($brands as $brand)
                        <li>
                            <input type="checkbox" name="brands[]" value="{{ $brand->slug }}" 
                                {{ in_array($brand->slug, (array)$activeBrands) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            {{ $brand->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- Scent Profile (Static) -->
            <div class="filter-section">
                <h4>Scent Profile</h4>
                <ul class="filter-list">
                    <li><input type="checkbox"> Woody & Smoky</li>
                    <li><input type="checkbox"> Fresh Citrus</li>
                    <li><input type="checkbox"> Floral</li>
                    <li><input type="checkbox"> Amber</li>
                </ul>
            </div>

            <div class="filter-section">
                <h4>Price Range</h4>
                <ul class="filter-list">
                    <li><input type="checkbox"> Under $100</li>
                    <li><input type="checkbox"> $100 — $250</li>
                    <li><input type="checkbox"> $250+</li>
                </ul>
            </div>
        </form>
    </aside>

    <main class="product-grid-container">
        @if($activeCategory || !empty($activeBrands) || $searchQuery)
            <div class="active-filters-bar">
                <span class="mono" style="font-size: 10px; opacity: 0.5; margin-right: 10px;">Active Filters:</span>
                
                @if($searchQuery)
                    <div class="filter-tag">
                        <span>Search: "{{ $searchQuery }}"</span>
                        <a href="{{ route('shop', request()->except(['search', 'page'])) }}" title="Remove Search"><i class="ri-close-line"></i></a>
                    </div>
                @endif

                @if($activeCategory)
                    <div class="filter-tag">
                        <span>Category: {{ $activeCategory->name }}</span>
                        <a href="{{ route('shop', request()->except(['category', 'page'])) }}" title="Remove Category"><i class="ri-close-line"></i></a>
                    </div>
                @endif

                @foreach($brands as $brand)
                    @if(in_array($brand->slug, (array)$activeBrands))
                        <div class="filter-tag">
                            <span>Brand: {{ $brand->name }}</span>
                            @php
                                $remainingBrands = array_diff((array)$activeBrands, [$brand->slug]);
                                $brandParams = !empty($remainingBrands) ? ['brands' => $remainingBrands] : [];
                            @endphp
                            <a href="{{ route('shop', array_merge(request()->except(['brands', 'page']), $brandParams)) }}" title="Remove Brand"><i class="ri-close-line"></i></a>
                        </div>
                    @endif
                @endforeach

                <a href="{{ route('shop') }}" class="clear-all-filters">Clear All</a>
            </div>
        @endif

        <div class="product-grid">
            @foreach($products as $product)
                <a href="{{ route('shop.product.show', $product->slug) }}" class="p-card group">
                    <div class="p-img">
                        @if($product->hasMedia('featured'))
                            <img src="{{ $product->getFirstMediaUrl('featured') }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?random={{ $product->id }}" alt="{{ $product->name }}">
                        @endif
                        
                        @if($product->stock_quantity < 5 && $product->stock_quantity > 0)
                            <span class="p-badge">Low Stock</span>
                        @elseif($product->created_at->gt(now()->subDays(7)))
                            <span class="p-badge">New</span>
                        @endif

                        <div class="p-actions">
                            @if($product->variants->count() > 0)
                                <button class="action-btn" title="Select Options" onclick="event.preventDefault(); openQuickView('{{ $product->slug }}')"><i class="ri-sound-module-line"></i></button>
                            @else
                                <button class="action-btn" title="Add to Cart" onclick="event.preventDefault(); quickAdd({{ $product->id }})"><i class="ri-shopping-cart-line"></i></button>
                            @endif
                            <button class="action-btn" title="Quick View" onclick="event.preventDefault(); event.stopPropagation(); openQuickView('{{ $product->slug }}')"><i class="ri-eye-line"></i></button>
                        </div>
                    </div>
                    <h3 class="p-title">{{ $product->name }}</h3>
                    <div class="p-price-container">
                        @if($product->product_type == 'variable')
                            <span class="p-price">From ${{ number_format($product->base_price, 2) }}</span>
                        @else
                            <span class="p-price">${{ number_format($product->base_price, 2) }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-20">
            {{ $products->links() }}
        </div>
    </main>
</div>

<!-- Mobile Offcanvas Filter -->
<div class="filter-overlay" id="filterOverlay"></div>
<div class="offcanvas-filter" id="offcanvasFilter">
    <div class="offcanvas-header">
        <h2 class="serif">Filters</h2>
        <button class="close-cart" id="closeFilter" style="font-size: 30px;">&times;</button>
    </div>
    
    <form action="{{ route('shop') }}" method="GET">
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        <div class="search-filter">
            <h4>Search</h4>
            <div class="search-input-wrapper">
                <input type="text" name="search" placeholder="Type to search..." value="{{ $searchQuery }}">
                <i class="ri-search-line"></i>
            </div>
        </div>

        <div class="filter-section">
            <h4>Categories</h4>
            <ul class="filter-list">
                <li class="{{ !request('category') ? 'active' : '' }}">
                    <a href="{{ route('shop', array_merge(request()->except(['category', 'page']))) }}">All Products</a>
                </li>
                @foreach($categories as $category)
                    <li class="{{ request('category') == $category->slug ? 'active' : '' }}">
                        <a href="{{ route('shop', array_merge(request()->except(['page']), ['category' => $category->slug])) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        @if($brands->count() > 0)
        <div class="filter-section">
            <h4>Brands</h4>
            <ul class="filter-list">
                @foreach($brands as $brand)
                    <li>
                        <input type="checkbox" name="brands[]" value="{{ $brand->slug }}" 
                            {{ in_array($brand->slug, (array)$activeBrands) ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        {{ $brand->name }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="filter-section">
            <h4>Scent Profile</h4>
            <ul class="filter-list">
                <li><input type="checkbox"> Woody & Smoky</li>
                <li><input type="checkbox"> Fresh Citrus</li>
                <li><input type="checkbox"> Floral</li>
                <li><input type="checkbox"> Amber</li>
            </ul>
        </div>

        <button type="submit" class="btn-luxe bg-black text-white w-full py-4 mt-6">Apply Filters</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('openFilter').addEventListener('click', function() {
        document.getElementById('offcanvasFilter').classList.add('active');
        document.getElementById('filterOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    document.getElementById('closeFilter').addEventListener('click', function() {
        document.getElementById('offcanvasFilter').classList.remove('active');
        document.getElementById('filterOverlay').classList.remove('active');
        document.body.style.overflow = 'auto';
    });

    document.getElementById('filterOverlay').addEventListener('click', function() {
        document.getElementById('offcanvasFilter').classList.remove('active');
        document.getElementById('filterOverlay').classList.remove('active');
        document.body.style.overflow = 'auto';
    });
</script>
@endsection
