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
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $image = $this->argument('image_url');
        $categories_ids = $this->argument('categories_ids');
        $categories_ids = explode(',', $categories_ids);

        $request = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
            'categories_ids' => $categories_ids
        ];
        
        $validator = new CreateProductRequest();
        $rules = $validator->rules();
        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 1;
        }

        $product = $this->productRepository->saveProduct($name, $description, $price, $image);
        $product->categories()->sync($categories_ids);
        $this->info('Product created successfully!');
    }
}
