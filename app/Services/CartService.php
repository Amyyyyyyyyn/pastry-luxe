<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function lines(): array
    {
        return (array) Session::get('cart', []);
    }

    public function add(Product $product, int $quantity, ?string $allergie, ?string $personalization): void
    {
        $cart = $this->lines();
        $cart[] = [
            'product_id' => $product->id,
            'quantity' => max(1, min(99, $quantity)),
            'allergie' => $allergie,
            'personalization' => $personalization,
        ];
        Session::put('cart', $cart);
    }

    public function update(int $index, int $quantity, ?string $allergie, ?string $personalization): void
    {
        $cart = $this->lines();
        if (!array_key_exists($index, $cart)) {
            return;
        }
        if ($quantity <= 0) {
            $this->remove($index);
            return;
        }
        $cart[$index]['quantity'] = max(1, min(99, $quantity));
        $cart[$index]['allergie'] = $allergie;
        $cart[$index]['personalization'] = $personalization;
        Session::put('cart', $cart);
    }

    public function remove(int $index): void
    {
        $cart = $this->lines();
        unset($cart[$index]);
        Session::put('cart', array_values($cart));
    }

    public function clear(): void
    {
        Session::forget('cart');
    }
}
