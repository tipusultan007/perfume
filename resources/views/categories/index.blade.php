@extends('layouts.store')

@section('title', "Categories | L'ESSENCE NYC")

@section('styles')
<style>
    .categories-header {
        padding: 140px 5% 60px;
        text-align: center;
        background: var(--cream);
    }

    .categories-header h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
        font-family: var(--font-primary);
    }

    .categories-header p {
        font-size: 14px;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 2px;
        max-width: 600px;
        margin: 0 auto;
        font-family: var(--font-secondary);
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        padding: 60px 8%;
    }

    .category-card {
        position: relative;
        overflow: hidden;
        border-radius: 4px; /* Slight rounding for softness */
        aspect-ratio: 4/5; /* Portrait aspect ratio for elegance */
        display: block;
        group: group;
    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 50%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        color: white;
        transition: background 0.5s ease;
    }

    .category-card:hover .category-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 100%);
    }

    .category-content {
        transform: translateY(10px);
        transition: transform 0.5s ease;
    }

    .category-card:hover .category-content {
        transform: translateY(0);
    }

    .category-title {
        font-size: 2rem;
        font-family: var(--font-primary);
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .category-count {
        font-family: var(--font-secondary);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.9;
        display: inline-block;
        border-top: 1px solid rgba(255,255,255,0.5);
        padding-top: 10px;
    }

    .view-btn {
        margin-top: 20px;
        display: inline-block;
        background: white;
        color: black;
        padding: 10px 25px;
        border-radius: 50px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s ease 0.1s;
    }

    .category-card:hover .view-btn {
        opacity: 1;
        transform: translateY(0);
    }

    .view-btn:hover {
        background: var(--accent);
        color: white;
    }

    @media (max-width: 1200px) {
        .categories-grid {
            padding: 60px 5%;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .categories-header {
            padding-top: 120px;
        }
        .categories-header h1 {
            font-size: 2.5rem;
        }
        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 40px 5%;
        }
    }

    @media (max-width: 480px) {
        .categories-grid {
            grid-template-columns: 1fr;
        }
        .category-card {
            aspect-ratio: 16/9; /* Wider on mobile */
        }
        .category-overlay {
            padding: 25px;
        }
        .category-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')

<div class="categories-header">
    <h1>Our Collections</h1>
    <p>Discover our curated selection of fine fragrances, categorized by olfactory families and distinct characteristics.</p>
</div>

<div class="categories-grid">
    @foreach($categories as $category)
    <a href="{{ route('shop', ['category' => $category->slug]) }}" class="category-card">
        @if($category->getFirstMediaUrl('category_image'))
            <img src="{{ $category->getFirstMediaUrl('category_image') }}" alt="{{ $category->name }}" loading="lazy">
        @else
            <!-- Placeholder if no image -->
            <div style="width: 100%; height: 100%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #ccc;">
                <i class="ri-image-line" style="font-size: 3rem;"></i>
            </div>
        @endif
        
        <div class="category-overlay">
            <div class="category-content">
                <h2 class="category-title">{{ $category->name }}</h2>
                <span class="category-count">{{ $category->products_count ?? $category->products()->count() }} Products</span>
                <div>
                   <span class="view-btn">Explore Collection</span> 
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>

@endsection
