<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{


    public function saveProduct($name, $description, $price, $image)
    {
        return Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image
        ]);
    }

    public function getAllProducts()
    {
        return Product::all();
    }
}
