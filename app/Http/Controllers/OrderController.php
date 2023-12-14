<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $cart = Cart::firstOrCreate([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'purchased' => false
        ]);

        $order = Order::firstOrCreate([
            'user_id' => Auth::id(),
            'ordered' => false
        ]);

        if (!$order->orderItems()->where('cart_id', $cart->id)->exists()) {
            $order->orderItems()->attach($cart->id);
        } else {
            $cart->quantity += 1;
            $cart->save();
        }

        return redirect()->route('pictures.show', $productId)
            ->with('success', 'Item added to cart');
    }

    public function viewCart()
    {
        $carts = Cart::where('user_id', Auth::id())->where('purchased', false)->get();
        $order = Order::where('user_id', Auth::id())->where('ordered', false)->first();

        return view('cart/cart', [
            'carts' => $carts,
            'order' => $order,
            'isExists' => $carts->isNotEmpty() && $order !== null
        ]);
    }

    public function removeFromCart($productId)
    {
        $order = Order::where('user_id', Auth::id())->where('ordered', false)->first();

        if ($order) {
            $cart = Cart::where('product_id', $productId)
                ->where('user_id', Auth::id())
                ->where('purchased', false)
                ->first();

            if ($cart) {
                $order->orderItems()->detach($cart->id);
                $cart->delete();

                return redirect()->route('cart.view')
                    ->with('success', 'Item removed from cart');
            }
        }

        return redirect()->route('home')
            ->with('error', 'No active order found');
    }

    public function changeCartItemQuantity($productId, $changeType)
    {
        $cart = Cart::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->where('purchased', false)
            ->firstOrFail();

        if ($changeType === 'increase') {
            $cart->quantity += 1;
        } elseif ($changeType === 'decrease' && $cart->quantity > 1) {
            $cart->quantity -= 1;
        }

        $cart->save();

        return redirect()->route('cart.view')
            ->with('success', 'Cart updated successfully');
    }

    public function confirmOrder(Request $request)
    {
        // Retrieve the user's order
        $order = Order::where('user_id', Auth::id())->where('ordered', false)->first();

        if (!$order) {
            return response()->json(['error' => 'No active order found'], 404);
        }

        // Retrieve cart items from the request
        $cartItems = $request->input('cartItems', []);

        // Update each cart item and mark them as purchased
        foreach ($cartItems as $item) {
            $cart = Cart::where('id', $item['cartId'])
                ->where('product_id', $item['productId'])
                ->where('user_id', Auth::id())
                ->where('purchased', false)
                ->first();

            if ($cart) {
                $cart->purchased = true;
                $cart->save();
            }
        }

        // Update the order status
        $order->ordered = true;
        $order->save();

        return response()->json(['message' => 'Order confirmed successfully']);
    }

    public function showOrderListPage()
    {
        $orders = Order::where('user_id', Auth::id())->where('ordered', true)->get();

        return view('cart/order-list', [
            'orders' => $orders
        ]);
    }
}
