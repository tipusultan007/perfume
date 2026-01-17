<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\HomeSection::updateOrCreate(
            ['key' => 'hero'],
            [
                'title' => 'Midnight Alchemy',
                'subtitle' => 'The New Collection',
                'button_text' => 'Discover The Collection',
                'button_link' => '/shop',
                'image_path' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=2000'
            ]
        );

        \App\Models\HomeSection::updateOrCreate(
            ['key' => 'heritage'],
            [
                'title' => 'Crafting Scents Since 1995',
                'subtitle' => 'Our Heritage',
                'content' => 'Every bottle tells a story of distant lands, rare ingredients, and the master perfumers who blend them into liquid art.',
                'button_text' => 'Read Our Story',
                'button_link' => '#',
                'image_path' => 'https://images.unsplash.com/photo-1615634260167-c8cdede054de?q=80&w=1000'
            ]
        );

        // Set top 4 categories as home-page visible
        \App\Models\Category::take(4)->update(['show_on_home' => true]);

        // Set top 5 products as featured
        \App\Models\Product::take(5)->update(['is_featured' => true]);
    }
}
