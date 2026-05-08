<?php

namespace Database\Seeders;

use App\Models\Popup;
use Illuminate\Database\Seeder;

class PopupSeeder extends Seeder
{
    public function run(): void
    {
        $popups = [
            [
                'title' => 'NewKirk Exclusive',
                'subtitle' => 'Membership Reward',
                'description' => 'Join our elite inner circle and receive 15% off your first niche fragrance bottle. Experience the art of scent.',
                'link' => '/shop',
                'cta_text' => 'Join Now',
                'template_id' => 'luxury-minimalist',
                'show_newsletter' => true,
                'font_family' => 'Cormorant Garamond',
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'title' => 'Midnight Royalty',
                'subtitle' => 'Limited Edition',
                'description' => 'A mysterious blend of Oud and Rose, crafted for those who command the night. Discover the limited "Noir" collection.',
                'link' => '/collection/noir',
                'cta_text' => 'Reveal More',
                'template_id' => 'dark-gold',
                'show_newsletter' => false,
                'font_family' => 'Cinzel',
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1594035910387-fea477e4031b?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'title' => 'Modern Essence',
                'subtitle' => 'New Arrival',
                'description' => 'Minimalist bottles, maximum impact. Explore our new "Clear" series designed for the modern metropolitan soul.',
                'link' => '/new-arrivals',
                'cta_text' => 'Explore Now',
                'template_id' => 'modern-glass',
                'show_newsletter' => true,
                'font_family' => 'Outfit',
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'title' => 'Private Collection',
                'subtitle' => 'Vip Access Only',
                'description' => 'The vault is open. Gain access to archival scents and bespoke blends curated by master perfumers.',
                'link' => '/vip',
                'cta_text' => 'Enter Vault',
                'template_id' => 'elegant-sidebar',
                'show_newsletter' => false,
                'font_family' => 'Playfair Display',
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1563170351-be3200b7762c?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'title' => 'The Heritage Edit',
                'subtitle' => 'Vintage Charm',
                'description' => 'Rediscover the timeless elegance of classic floral notes. A collection inspired by 19th-century Parisian ateliers.',
                'link' => '/heritage',
                'cta_text' => 'View History',
                'template_id' => 'vintage-classic',
                'show_newsletter' => true,
                'font_family' => 'Prata',
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1595428774754-34805fbe1281?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'title' => 'Pure Botanical',
                'subtitle' => 'Natural Luxe',
                'description' => '100% organic essences from around the world. Sustainable luxury in every drop. Better for you, better for the earth.',
                'link' => '/botanical',
                'cta_text' => 'Discover Nature',
                'template_id' => 'floating-minimalist',
                'show_newsletter' => true,
                'font_family' => 'Montserrat',
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1547881338-66291632731d?auto=format&fit=crop&q=80&w=1000'
            ],
        ];

        foreach ($popups as $data) {
            $imageUrl = $data['image_url'];
            unset($data['image_url']);
            
            $popup = Popup::create($data);
            
            try {
                $popup->addMediaFromUrl($imageUrl)->toMediaCollection('popup');
            } catch (\Exception $e) {
                $this->command->warn("Could not download image for popup: {$popup->title}");
            }
        }
    }
}
