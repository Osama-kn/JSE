<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{


    public function saveProduct(string $name, string $description, float $price, string $image): Product
    {
        return Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image
        ]);
    }
    

    public function getAllProducts(): Collection
    {
        return Product::all();
    }

}
