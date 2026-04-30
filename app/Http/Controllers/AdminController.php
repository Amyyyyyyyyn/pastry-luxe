<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $recentOrders = Order::query()->latest()->limit(4)->get();
        $newOrdersCount = Order::query()
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        return view('admin.dashboard', compact('recentOrders', 'newOrdersCount'));
    }

    public function products(): View
    {
        $products = Product::with('category')->orderBy('name')->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function productStore(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = (bool) $request->boolean('is_active', true);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('products', 'public');
        if (blank($data['slug'] ?? null)) $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(6));
        Product::create($data);
        return back()->with('status', 'Produit créé.');
    }

    public function productUpdate(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = (bool) $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($product->image && !str_starts_with((string) $product->image, 'http')) {
                Storage::disk('public')->delete((string) $product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($data['image']);
        }

        $product->update($data);

        return back()->with('status', 'Produit mis à jour.');
    }

    public function productDestroy(Product $product): RedirectResponse
    {
        if ($product->image && !str_starts_with((string) $product->image, 'http')) {
            Storage::disk('public')->delete((string) $product->image);
        }
        $product->delete();

        return back()->with('status', 'Produit supprimé.');
    }

    public function orders(): View
    {
        $orders = Order::with('items')->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function orderShow(Order $order): View
    {
        $order->load('items');
        return view('admin.order-show', compact('order'));
    }

    public function orderUpdate(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update(['status' => $request->string('status')]);
        return back()->with('status', 'Statut mis à jour.');
    }
}
