<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function home(Request $request): View
    {
        $slug = (string) $request->query('categorie', '');
        $categories = Category::query()->orderBy('sort_order')->orderBy('name')->get();
        $query = Product::query()->where('is_active', true)->with('category')->orderBy('name');
        if ($slug !== '') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
        }
        $heroProduct = (clone $query)->whereHas('category', fn ($q) => $q->where('slug', 'cakes'))->first() ?? (clone $query)->first();
        $products = (clone $query)->limit(12)->get();
        return view('shop.home', compact('categories', 'products', 'heroProduct', 'slug'));
    }

    public function products(Request $request): View
    {
        $slug = (string) $request->query('categorie', '');
        $categories = Category::query()->orderBy('sort_order')->orderBy('name')->get();
        $query = Product::query()->where('is_active', true)->with('category')->orderBy('name');
        if ($slug !== '') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
        }
        $products = $query->paginate(18)->withQueryString();
        return view('shop.catalog', compact('categories', 'products', 'slug'));
    }

    public function show(Product $product): View
    {
        abort_unless((bool) $product->is_active, 404);

        $product->load('category');

        return view('shop.product-show', compact('product'));
    }
}
