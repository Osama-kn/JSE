<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAllProducts() : Collection;
    public function saveProduct(string $name, string $description, float $price, string $image): Product;
}
