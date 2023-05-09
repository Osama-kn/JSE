<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Traits\ApiResponser;
use App\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ApiResponser;

    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    /**
     * Save a new product
     *
     * @param \App\Http\Requests\CreateProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(CreateProductRequest $request): JsonResponse
    {
        try {

            // Get the uploaded file and generate a unique filename for it
            $file = $request->file('image');
            $fileHash = sha1_file($file);
            $filename = $file->getClientOriginalName();
            $filename = str_replace(' ', '', $filename);
            $filename = $fileHash . '' . $filename;

            // Store the file in the "public/product" directory
            Storage::putFileAs('public/product', $file, $filename);

            // Get the URL for the stored image file
            $image =  Storage::url('public/product/' . $filename);

            // Create a new product record and save it to the database
            $product = $this->productRepository->saveProduct(
                $request->name,
                $request->description,
                $request->price,
                $image
            );

            // Associate the product with the specified categories
            $product->categories()->sync($request->categories_ids);

            // Return a success response with the saved product data
            return $this->successResponse($product);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    /**
     * Get all products with categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $products = $this->productRepository->getAllProductsWithProducts();
            return $this->successResponse($products);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
