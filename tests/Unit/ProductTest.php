<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_a_new_product()
    {
        $category = Category::factory()->create();

        $product = Product::create([
            'name' => 'Test Product',
            'price' => 199.99,
            'barcode' => '1234567890123',
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 199.99,
            'barcode' => '1234567890123',
            'category_id' => $category->id,
        ]);
    }

    public function test_updates_product_price()
    {
        $category = Category::factory()->create();

        $product = Product::create([
            'name' => 'Test Product',
            'price' => 100,
            'barcode' => '1234567890124',
            'category_id' => $category->id,
        ]);

        $product->update([
            'price' => 250.50,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 250.50,
        ]);
    }
}
