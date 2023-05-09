<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductService
{
    private ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Create a new product with an uploaded image.
     *
     * @param string $name
     * @param string $description
     * @param double $price
     * @param UploadedFile $image
     * @param array $categoryIds An array of category IDs to associate with the product
     *
     * @throws \Exception If there was an error saving the product data or image
     *
     * @return Product The created product instance
     */
    public function createProduct(string $name, string $description, float $price, UploadedFile $image, array $categoryIds): Product
    {
        try {
            // Generate a unique filename for the uploaded image
            $fileHash = sha1_file($image);
            $filename = $image->getClientOriginalName();
            $filename = str_replace(' ', '', $filename);
            $filename = $fileHash . '' . $filename;

            // Store the image in the "public/product" directory
            Storage::putFileAs('public/product', $image, $filename);

            // Get the URL for the stored image file
            $imageUrl =  Storage::url('public/product/' . $filename);

            $product = $this->productRepository->saveProduct(
                $name,
                $description,
                $price,
                $imageUrl
            );

            // Associate the product with the specified categories
            $product->categories()->sync($categoryIds);

            return $product;
        } catch (Exception $e) {
            throw new Exception("Error creating product: " . $e->getMessage());
        }
    }
    
}
