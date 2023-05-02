<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponser;
use App\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        try {
            // Validate the request data
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'categories_ids' => 'required|array|exists:categories,id'
            ]);

            // Get the uploaded file and generate a unique filename for it
            $file = $request->file('image');
            $fileHash = sha1_file($file);
            $filename = $file->getClientOriginalName();
            $filename = str_replace(' ', '', $filename);
            $filename = $fileHash . '' . $filename;

            // Store the file in the "public/category" directory
            Storage::putFileAs('public/category', $file, $filename);

            // Get the URL for the stored image file
            $image =  Storage::url('public/category/' . $filename);

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
     * Get all products
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        try {
            $products = $this->productRepository->getAllProducts();
            return $this->successResponse($products);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
