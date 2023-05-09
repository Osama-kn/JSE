<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Traits\ApiResponser;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use ApiResponser;

    private ProductRepositoryInterface $productRepository;
    protected $productService;

    public function __construct(ProductRepositoryInterface $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
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

            // Create a new product with the uploaded image
            $product = $this->productService->createProduct(
                $request->name,
                $request->description,
                $request->price,
                $request->file('image'),
                $request->categories_ids
            );

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
            $products = $this->productRepository->getAllProducts();
            return $this->successResponse($products);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
