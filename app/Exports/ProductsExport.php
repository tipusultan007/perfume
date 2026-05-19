<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['brand', 'category'])->get();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Name',
            'Brand',
            'Category',
            'SKU',
            'Price',
            'Sale Price',
            'Stock',
            'Size',
            'Gender',
            'Concentration',
            'Season',
            'Top Notes',
            'Heart Notes',
            'Base Notes',
            'Intensity',
            'Notes',
            'Description',
            'Status',
            'Product Type',
        ];
    }

    /**
    * @param mixed $product
    * @return array
    */
    public function map($product): array
    {
        return [
            $product->name,
            $product->brand->name ?? '',
            $product->category->name ?? '',
            $product->sku,
            $product->base_price,
            $product->sale_price,
            $product->stock_quantity,
            $product->size,
            $product->gender,
            $product->concentration,
            $product->season,
            $product->top_notes,
            $product->heart_notes,
            $product->base_notes,
            $product->intensity,
            $product->short_description,
            strip_tags($product->description),
            $product->status,
            $product->product_type,
        ];
    }
}
