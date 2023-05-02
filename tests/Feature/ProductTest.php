<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use DatabaseTransactions, WithFaker;
    /**
     * Test Save Product
     *
     * @return void
     */
    public function testSaveProduct()
    {
        // Create a category to associate with the product
        $category = Category::factory()->create();

        // Create a fake image to upload
        $image = UploadedFile::fake()->image('product.jpg');
        // Make a POST request to the "save" endpoint with the required data
        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Lorem ipsum dolor sit amet',
            'price' => 9.99,
            'image' => $image,
            'categories_ids' => [$category->id],
        ]);

        // Assert that the response has a successful status code
        $response->assertSuccessful();

        // Assert that the product was saved to the database with the correct data
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'description' => 'Lorem ipsum dolor sit amet',
            'price' => 9.99
        ]);
        // Assert that the product is associated with the specified category
        $this->assertDatabaseHas('category_product', [
            'category_id' => $category->id,
            'product_id' => $response->json('data')['id'],
        ]);
    }
}
