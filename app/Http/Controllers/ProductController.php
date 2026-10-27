<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter Pencarian (Nama atau Kode)
        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Status Stok (Menipis atau Habis)
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'menipis') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5); // Batas stok menipis (<= 5)
            } elseif ($request->stock_status === 'habis') {
                $query->where('stock', '=', 0);
            }
        }

        // Pengaturan jumlah data per halaman (10, 25, atau 50)
        $perPage = in_array($request->per_page, [10, 25, 50]) ? $request->per_page : 10;

        $products = $query->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view(
            'master-data.product.index',
            compact('products', 'categories')
        );
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('master-data.product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('master-data.product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
    $product->load(['transactionDetails.transaction']);
 
    $totalTerjual = $product->transactionDetails->sum('qty');
 
    $riwayat = $product->transactionDetails()
        ->with('transaction')
        ->latest()
        ->take(10)
        ->get();
 
    return view('master-data.product.show', compact('product', 'totalTerjual', 'riwayat'));
    }


}