<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProduct implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('name_en','description_en','purchase_price','price','stock','category_id','brand_id','car_id')->get(); //'name_ar','description_ar',
    }

    public function map($products) : array {
        return [
            // $products->name_ar,
            $products->name_en,
            $products->purchase_price,
            $products->price,
            $products->stock,
            // $products->country,
            $products->category->name_en,
            $products->brand->name_en,
            $products->car->name_en,
            $products->description_en,
            // $products->description_ar,
        ] ;


    }

    public function headings(): array
    {
        return ["name","purchase_price","sale_price","stock","category","brand","car","description"];
    }

}
