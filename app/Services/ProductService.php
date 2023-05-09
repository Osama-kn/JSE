<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    private ProductRepositoryInterface $productRepository;
    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }


    /**
     * Save an uploaded image and return the image URL.
     *
     * @param UploadedFile $image
     *
     * @throws \Exception If there was an error saving the image file
     *
     * @return string The URL for the saved image file
     */
    public function saveProductImage(UploadedFile $image): string
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
            return Storage::url('public/product/' . $filename);
        } catch (Exception $e) {
            throw new Exception("Error saving product image: " . $e->getMessage());
        }
    }

    /**
     * Create a new product with the specified data and associated categories.
     *
     * @param string $name
     * @param string $description
     * @param double $price
     * @param string $imageUrl
     * @param array $categories_ids An array of category IDs to associate with the product
     *
     * @throws \Exception If there was an error saving the product data or associating categories
     *
     * @return Product The created product instance
     */
    public function createProductWithCategories(string $name, string $description, float $price, string $imageUrl, array $categories_ids): Product
    {
        try {
            $product = $this->productRepository->saveProduct($name, $description, $price, $imageUrl);

            // Associate the product with the specified categories
            $product->categories()->sync($categories_ids);

            return $product;
        } catch (Exception $e) {
            throw new Exception("Error creating product: " . $e->getMessage());
        }
    }

    public function getAllProductsWithCategories(): Collection
    {
        try {
            $products = $this->productRepository->getAllProducts();
            $result = $products->map(function ($product) {
                $product->categories;
                return $product;
            });

            return $result;
        } catch (Exception $e) {
            throw new Exception("Error getting products: " . $e->getMessage());
        }
    }
}
