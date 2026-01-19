<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    /*
     * Get the base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $prefix = 'uploads';

        if ($media->collection_name === 'featured') {
            $prefix = 'products/featured';
        } elseif ($media->collection_name === 'gallery') {
            $prefix = 'products/gallery';
        } elseif ($media->collection_name === 'variant_image') {
            $prefix = 'products/variants';
        }

        return $prefix . '/' . $media->id;
    }
}
