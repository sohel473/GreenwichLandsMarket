<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('cart.add', $product->id));

        $this->assertCount(1, Cart::all());
        $response->assertRedirect(route('pictures.show', $product->id));
    }

    /** @test */
    public function user_can_view_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('cart.view'));

        $response->assertStatus(200);
        $response->assertViewIs('cart.cart');
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);
        $this->post(route('cart.add', $product->id));

        $response = $this->post(route('cart.remove', $product->id));

        $this->assertCount(0, Cart::all());
        $response->assertRedirect(route('cart.view'));
    }

    /** @test */
    public function user_can_change_cart_item_quantity()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);
        $this->post(route('cart.add', $product->id));

        $response = $this->post(route('cart.changeQuantity', ['productId' => $product->id, 'changeType' => 'increase']));

        $cart = Cart::first();
        $this->assertEquals(2, $cart->quantity);
        $response->assertRedirect(route('cart.view'));
    }

    // ... additional test cases
}
