<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        // Generate JWT token for this user
        $this->token = JWTAuth::fromUser($this->user);
    }

    protected function headers()
    {
        return ['Authorization' => "Bearer {$this->token}"];
    }

    /** @test */
    public function user_can_create_product()
    {
        $data = ['name' => 'Test Product', 'price' => 99.99];

        $response = $this->postJson('/api/products', $data, $this->headers());

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function user_can_get_products_paginated()
    {
        Product::factory()->count(15)->create();

        $response = $this->getJson('/api/products', $this->headers());

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
        ]);
    }

    /** @test */
    public function user_can_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Name',
            'price' => 199.99,
        ], $this->headers());

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function user_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}", [], $this->headers());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
