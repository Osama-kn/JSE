<?php

namespace App\Console\Commands;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Console\Command;

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
        $product = $this->productRepository->saveProduct($name, $description, $price, $image);
        $product->categories()->sync($categories_ids);
        $this->info('Product created successfully!');
    }
}
