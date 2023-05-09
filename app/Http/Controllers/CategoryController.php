<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponser;
use App\Interfaces\CategoryRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ApiResponser;

    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Get all categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() : JsonResponse
    {
        try {
            $categories = $this->categoryRepository->getAllCategories();
            return $this->successResponse($categories);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
