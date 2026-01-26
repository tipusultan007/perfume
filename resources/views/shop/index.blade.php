@extends('layouts.store')

@section('title', "The Collection | L'ESSENCE NYC")

@section('styles')
<style>
    /* --- 2. Collection Header --- */
    .collection-header {
        padding: 180px 5% 40px;
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
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-list li {
        margin-bottom: 12px;
        font-size: 14px;
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

    .filter-list.scrollable {
        max-height: 250px;
        overflow-y: auto;
        padding-right: 15px;
    }

    /* Custom Scrollbar for Filters */
    .filter-list.scrollable::-webkit-scrollbar {
        width: 3px;
    }
    .filter-list.scrollable::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .filter-list.scrollable::-webkit-scrollbar-thumb {
        background: #000;
    }

    .btn-filter-apply {
        width: 100%;
        padding: 15px;
        background: var(--black);
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 10px;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-filter-apply:hover {
        background: var(--accent);
        color: white;
    }

    /* Search Box */
    .search-filter {
        margin-bottom: 40px;
    }

    .search-filter h4{
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 10px;
        font-weight: 600;
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
        font-size: 14px;
        outline: none;
        font-family: 'Montserrat', sans-serif;
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

    .p-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--accent);
        color: #fff;
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

    /* --- 6. Professional Pagination --- */
    .pagination-container {
        margin-top: 80px;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .pagination-container nav {
        width: 100%;
    }

    /* Mobile Responsive Pagination */
    @media (max-width: 640px) {
        .pagination-container {
            margin-top: 40px;
        }
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

            <div class="search-filter" x-data="{ expanded: true }">
                <h4 @click="expanded = !expanded">
                    Search 
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <div class="search-input-wrapper" x-show="expanded">
                    <input type="text" name="search" placeholder="Type to search..." value="{{ $searchQuery }}">
                    <i class="ri-search-line"></i>
                </div>
            </div>

            <div class="filter-section" x-data="{ expanded: true }">
                <h4 @click="expanded = !expanded">
                    Categories
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <ul class="filter-list" x-show="expanded">
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
            <div class="filter-section" x-data="{ expanded: true }">
                <h4 @click="expanded = !expanded">
                    Brands
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <ul class="filter-list scrollable" x-show="expanded">
                    @foreach($brands as $brand)
                        <li>
                            <input type="checkbox" name="brands[]" value="{{ $brand->slug }}" 
                                {{ in_array($brand->slug, (array)$activeBrands) ? 'checked' : '' }}>
                            {{ $brand->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($genders->count() > 0)
            <div class="filter-section" x-data="{ expanded: {{ !empty($activeGenders) ? 'true' : 'false' }} }">
                <h4 @click="expanded = !expanded">
                    Gender
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <ul class="filter-list" x-show="expanded" style="display: none;">
                    @foreach($genders as $gender)
                        <li>
                            <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                                {{ in_array($gender, (array)$activeGenders) ? 'checked' : '' }}>
                            {{ ucfirst($gender) }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($concentrations->count() > 0)
            <div class="filter-section" x-data="{ expanded: {{ !empty($activeConcentrations) ? 'true' : 'false' }} }">
                <h4 @click="expanded = !expanded">
                    Concentration
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <ul class="filter-list" x-show="expanded" style="display: none;">
                    @foreach($concentrations as $concentration)
                        <li>
                            <input type="checkbox" name="concentrations[]" value="{{ $concentration }}" 
                                {{ in_array($concentration, (array)$activeConcentrations) ? 'checked' : '' }}>
                            {{ $concentration }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($seasons->count() > 0)
            <div class="filter-section" x-data="{ expanded: {{ !empty($activeSeasons) ? 'true' : 'false' }} }">
                <h4 @click="expanded = !expanded">
                    Best for Season
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <ul class="filter-list" x-show="expanded" style="display: none;">
                    @foreach($seasons as $season)
                        <li>
                            <input type="checkbox" name="seasons[]" value="{{ $season }}" 
                                {{ in_array($season, (array)$activeSeasons) ? 'checked' : '' }}>
                            {{ ucfirst($season) }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(count($sizes) > 0)
            <div class="filter-section" x-data="{ expanded: {{ !empty($activeSizes) ? 'true' : 'false' }} }">
                <h4 @click="expanded = !expanded">
                    Size
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <ul class="filter-list" x-show="expanded" style="display: none;">
                    @foreach($sizes as $size)
                        <li>
                            <input type="checkbox" name="sizes[]" value="{{ $size }}" 
                                {{ in_array($size, (array)$activeSizes) ? 'checked' : '' }}>
                            {{ $size }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="filter-section" x-data="{ expanded: {{ request('top_notes') || request('heart_notes') || request('base_notes') ? 'true' : 'false' }} }">
                <h4 @click="expanded = !expanded">
                    Fragrance Notes
                    <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
                </h4>
                <div style="display: flex; flex-direction: column; gap: 10px;" x-show="expanded" style="display: none;">
                    <input type="text" name="top_notes" value="{{ request('top_notes') }}" placeholder="Top Note (e.g. Citrus)" class="border border-slate-200 p-2 text-xs w-full outline-none focus:border-black">
                    <input type="text" name="heart_notes" value="{{ request('heart_notes') }}" placeholder="Heart Note" class="border border-slate-200 p-2 text-xs w-full outline-none focus:border-black">
                    <input type="text" name="base_notes" value="{{ request('base_notes') }}" placeholder="Base Note" class="border border-slate-200 p-2 text-xs w-full outline-none focus:border-black">
                </div>
            </div>

            <button type="submit" class="btn-filter-apply">Apply Filters</button>
        </form>
    </aside>

    <main class="product-grid-container">
        @if($activeCategory || !empty($activeBrands) || $searchQuery || !empty($activeGenders) || !empty($activeConcentrations) || !empty($activeSeasons) || !empty($activeSizes))
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
                                $remaining = array_diff((array)$activeBrands, [$brand->slug]);
                                $params = array_merge(request()->except(['brands', 'page']), !empty($remaining) ? ['brands' => $remaining] : []);
                            @endphp
                            <a href="{{ route('shop', $params) }}"><i class="ri-close-line"></i></a>
                        </div>
                    @endif
                @endforeach

                @foreach((array)$activeGenders as $gender)
                    <div class="filter-tag">
                        <span>Gender: {{ ucfirst($gender) }}</span>
                        @php
                            $remaining = array_diff((array)$activeGenders, [$gender]);
                            $params = array_merge(request()->except(['genders', 'page']), !empty($remaining) ? ['genders' => $remaining] : []);
                        @endphp
                        <a href="{{ route('shop', $params) }}"><i class="ri-close-line"></i></a>
                    </div>
                @endforeach

                @foreach((array)$activeConcentrations as $concentration)
                    <div class="filter-tag">
                        <span>Conc: {{ $concentration }}</span>
                        @php
                            $remaining = array_diff((array)$activeConcentrations, [$concentration]);
                            $params = array_merge(request()->except(['concentrations', 'page']), !empty($remaining) ? ['concentrations' => $remaining] : []);
                        @endphp
                        <a href="{{ route('shop', $params) }}"><i class="ri-close-line"></i></a>
                    </div>
                @endforeach

                @foreach((array)$activeSeasons as $season)
                    <div class="filter-tag">
                        <span>Season: {{ ucfirst($season) }}</span>
                        @php
                            $remaining = array_diff((array)$activeSeasons, [$season]);
                            $params = array_merge(request()->except(['seasons', 'page']), !empty($remaining) ? ['seasons' => $remaining] : []);
                        @endphp
                        <a href="{{ route('shop', $params) }}"><i class="ri-close-line"></i></a>
                    </div>
                @endforeach

                @foreach((array)$activeSizes as $size)
                    <div class="filter-tag">
                        <span>Size: {{ $size }}</span>
                        @php
                            $remaining = array_diff((array)$activeSizes, [$size]);
                            $params = array_merge(request()->except(['sizes', 'page']), !empty($remaining) ? ['sizes' => $remaining] : []);
                        @endphp
                        <a href="{{ route('shop', $params) }}"><i class="ri-close-line"></i></a>
                    </div>
                @endforeach

                <a href="{{ route('shop') }}" class="clear-all-filters">Clear All</a>
            </div>
        @endif

        <div class="product-grid">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $products->onEachSide(2)->links() }}
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

        <div class="search-filter" x-data="{ expanded: true }">
            <h4 @click="expanded = !expanded">
                Search
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <div class="search-input-wrapper" x-show="expanded">
                <input type="text" name="search" placeholder="Type to search..." value="{{ $searchQuery }}">
                <i class="ri-search-line"></i>
            </div>
        </div>

        <div class="filter-section" x-data="{ expanded: true }">
            <h4 @click="expanded = !expanded">
                Categories
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <ul class="filter-list" x-show="expanded">
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
        <div class="filter-section" x-data="{ expanded: true }">
            <h4 @click="expanded = !expanded">
                Brands
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <ul class="filter-list scrollable" x-show="expanded">
                @foreach($brands as $brand)
                    <li>
                        <input type="checkbox" name="brands[]" value="{{ $brand->slug }}" 
                            {{ in_array($brand->slug, (array)$activeBrands) ? 'checked' : '' }}>
                        {{ $brand->name }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(count($sizes) > 0)
        <div class="filter-section" x-data="{ expanded: {{ !empty($activeSizes) ? 'true' : 'false' }} }">
            <h4 @click="expanded = !expanded">
                Size
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <ul class="filter-list" x-show="expanded" style="display: none;">
                @foreach($sizes as $size)
                    <li>
                        <input type="checkbox" name="sizes[]" value="{{ $size }}" 
                            {{ in_array($size, (array)$activeSizes) ? 'checked' : '' }}>
                        {{ $size }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($genders->count() > 0)
        <div class="filter-section" x-data="{ expanded: {{ !empty($activeGenders) ? 'true' : 'false' }} }">
            <h4 @click="expanded = !expanded">Gender
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <ul class="filter-list" x-show="expanded" style="display: none;">
                @foreach($genders as $gender)
                    <li>
                        <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                            {{ in_array($gender, (array)$activeGenders) ? 'checked' : '' }}>
                        {{ ucfirst($gender) }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($concentrations->count() > 0)
        <div class="filter-section" x-data="{ expanded: {{ !empty($activeConcentrations) ? 'true' : 'false' }} }">
            <h4 @click="expanded = !expanded">Concentration
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <ul class="filter-list" x-show="expanded" style="display: none;">
                @foreach($concentrations as $concentration)
                    <li>
                        <input type="checkbox" name="concentrations[]" value="{{ $concentration }}" 
                            {{ in_array($concentration, (array)$activeConcentrations) ? 'checked' : '' }}>
                        {{ $concentration }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($seasons->count() > 0)
        <div class="filter-section" x-data="{ expanded: {{ !empty($activeSeasons) ? 'true' : 'false' }} }">
            <h4 @click="expanded = !expanded">Best for Season
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <ul class="filter-list" x-show="expanded" style="display: none;">
                @foreach($seasons as $season)
                    <li>
                        <input type="checkbox" name="seasons[]" value="{{ $season }}" 
                            {{ in_array($season, (array)$activeSeasons) ? 'checked' : '' }}>
                        {{ ucfirst($season) }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="filter-section" x-data="{ expanded: {{ request('top_notes') || request('heart_notes') || request('base_notes') ? 'true' : 'false' }} }">
            <h4 @click="expanded = !expanded">
                Fragrance Notes
                <i class="ri-arrow-down-s-line" :class="{ 'rotate-180': !expanded }" style="transition: 0.3s;"></i>
            </h4>
            <div style="display: flex; flex-direction: column; gap: 10px;" x-show="expanded" style="display: none;">
                <input type="text" name="top_notes" value="{{ request('top_notes') }}" placeholder="Top Note" class="border border-slate-200 p-2 text-xs w-full">
                <input type="text" name="heart_notes" value="{{ request('heart_notes') }}" placeholder="Heart Note" class="border border-slate-200 p-2 text-xs w-full">
                <input type="text" name="base_notes" value="{{ request('base_notes') }}" placeholder="Base Note" class="border border-slate-200 p-2 text-xs w-full">
            </div>
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
