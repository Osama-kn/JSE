<?php

namespace App\Console\Commands;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product {name} {description} {price} {image_url} {categories_ids}';

    /**
     * The console command description.
     * 
     *
     * @var string
     */
    protected $description = 'Create a new product';
    protected $productRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve the product attributes from the command arguments
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $image = $this->argument('image_url');
        $categories_ids = $this->argument('categories_ids');
        // Convert comma-separated string to an array of category IDs
        $categories_ids = explode(',', $categories_ids);

        // Create a request object for validation
        $request = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
            'categories_ids' => $categories_ids
        ];

        // Use custom validation rules to validate the input data
        $validator = new CreateProductRequest();
        $rules = $validator->rules();
        $validator = Validator::make($request, $rules);

        // If validation fails, return error message and status code
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 1;
        }

        // Save the product to the database using the ProductRepository 
        $product = $this->productRepository->saveProduct($name, $description, $price, $image);
        // Update the product categories
        $product->categories()->sync($categories_ids);
        $this->info('Product created successfully!');
    }
}
