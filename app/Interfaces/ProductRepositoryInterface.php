<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function getAllProductsWithProducts();
    public function saveProduct($name, $description, $price, $image);
}
