<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_can_create_product_and_stock_in_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/products', [
                'sku' => 'TEST-001',
                'name' => '測試紗布',
                'unit' => '包',
                'safety_stock' => 5,
                'location' => 'A-01',
            ])
            ->assertRedirect('/products');

        $product = Product::query()->where('sku', 'TEST-001')->firstOrFail();
        $this->assertSame(0, $product->quantity);

        $this->actingAs($user)
            ->post('/stock/in', [
                'product_id' => $product->id,
                'quantity' => 10,
                'remark' => '進貨單 A',
            ])
            ->assertRedirect();

        $this->assertSame(10, $product->fresh()->quantity);

        $this->actingAs($user)
            ->post('/stock/out', [
                'product_id' => $product->id,
                'quantity' => 3,
                'remark' => '病房領用',
            ])
            ->assertRedirect();

        $this->assertSame(7, $product->fresh()->quantity);
    }

    public function test_cannot_stock_out_more_than_on_hand(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['quantity' => 2, 'safety_stock' => 1]);

        $this->actingAs($user)
            ->from('/stock/out')
            ->post('/stock/out', [
                'product_id' => $product->id,
                'quantity' => 9,
            ])
            ->assertSessionHasErrors('quantity');

        $this->assertSame(2, $product->fresh()->quantity);
    }
}
