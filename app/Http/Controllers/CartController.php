<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function index(): View
    {
        $rows = [];
        foreach ($this->cart->lines() as $i => $line) {
            $rows[] = ['index' => (int) $i, 'line' => $line, 'product' => Product::find((int) ($line['product_id'] ?? 0))];
        }
        $subtotal = collect($rows)->sum(function ($r) {
            $p = $r['product']; if (!$p) return 0;
            return ((float) $p->price) * ((int) ($r['line']['quantity'] ?? 0));
        });
        return view('shop.cart', ['rows' => $rows, 'subtotal' => $subtotal]);
    }

    public function add(AddToCartRequest $request): RedirectResponse
    {
        $product = Product::query()->where('is_active', true)->findOrFail($request->integer('product_id'));
        $this->cart->add($product, $request->integer('quantity'), $request->input('allergie'), $request->input('personalization'));
        return back()->with('toast', 'Produit ajouté au panier.');
    }

    public function update(int $line, UpdateCartItemRequest $request): RedirectResponse
    {
        $this->cart->update($line, $request->integer('quantity'), $request->input('allergie'), $request->input('personalization'));
        return back()->with('toast', 'Panier mis à jour.');
    }

    public function remove(int $line): RedirectResponse
    {
        $this->cart->remove($line);
        return back()->with('toast', 'Ligne supprimée.');
    }
}
