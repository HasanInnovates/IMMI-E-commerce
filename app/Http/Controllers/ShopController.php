<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function home(): View
    {
        $categories = Category::where('status', true)
            ->withCount('products')
            ->get();

        $featuredProducts = Product::with('category')
            ->where('status', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('shop.home', compact('categories', 'featuredProducts'));
    }

    public function products(Request $request): View
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');

        $query = Product::with('category')->where('status', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $products = $query->latest()->paginate(9)->withQueryString();

        $categories = Category::where('status', true)
            ->withCount('products')
            ->get();

        return view('shop.products', compact('products', 'categories', 'search', 'categorySlug'));
    }

    public function productDetail(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('shop.product-detail', compact('product', 'relatedProducts'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->where('status', true)
            ->latest()
            ->paginate(9);

        return view('shop.category', compact('category', 'products'));
    }
}
