<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function index(): View|RedirectResponse
    {
        if (count($this->cart->lines()) === 0) return redirect()->route('cart.index');
        $subtotal = collect($this->cart->lines())->sum(function ($line) {
            $p = Product::find((int) ($line['product_id'] ?? 0)); if (!$p) return 0;
            return ((float) $p->price) * ((int) ($line['quantity'] ?? 0));
        });
        return view('shop.checkout', compact('subtotal'));
    }

    public function place(PlaceOrderRequest $request): RedirectResponse
    {
        $lines = $this->cart->lines();
        if (count($lines) === 0) return redirect()->route('cart.index');

        $order = DB::transaction(function () use ($request, $lines) {
            $order = Order::create([
                'client_name' => $request->string('client_name'),
                'phone' => $request->string('phone'),
                'notes' => $request->input('notes'),
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0.0;
            foreach ($lines as $line) {
                $product = Product::query()->where('is_active', true)->find((int) ($line['product_id'] ?? 0));
                if (!$product) continue;
                $q = max(1, (int) ($line['quantity'] ?? 1));
                $total += ((float) $product->price) * $q;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name_snapshot' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $q,
                    'allergie' => $line['allergie'] ?? null,
                    'personalization' => $line['personalization'] ?? null,
                ]);
            }
            $order->update(['total' => $total]);
            return $order;
        });

        $this->cart->clear();
        return redirect()->route('checkout.thanks', $order);
    }

    public function thanks(Order $order): View
    {
        return view('shop.thanks', compact('order'));
    }
}
