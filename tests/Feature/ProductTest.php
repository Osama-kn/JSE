<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use DatabaseTransactions, WithFaker;

    /**
     * Test Save Product
     *
     * @return void
     */
    public function testSaveProduct(): void
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

    /**
     * Tests that a product cannot be saved without any fields.
     *
     * @return void
     */
    public function testSaveProductWithoutFields(): void
    {
        // Make a POST request without any data
        $response = $this->postJson('/api/products');

        // Assert that the response has a status code of 422 (Unprocessable Entity)
        $response->assertStatus(422);

        // Assert that the validation errors are returned in the response
        $response->assertJsonValidationErrors(['name', 'description', 'price', 'image', 'categories_ids']);
    }


    /**
     * Tests that a product cannot be saved without price and image fields.
     *
     * @return void
     */
    public function testSaveProductSomeMissingFields(): void
    {
        $category = Category::factory()->create();

        // Make a POST request with some fields missing
        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Lorem ipsum dolor sit amet',
            // The "price" and "image" fields are missing
            'categories_ids' => [$category->id],
        ], ['Accept' => 'application/json']);

        // // Assert that the response has a status code of 422
        $response->assertStatus(422);

        // // Assert that the validation errors are returned in the response
        $response->assertJsonValidationErrors(['price', 'image']);
    }
}
