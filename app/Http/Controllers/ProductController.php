<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductController extends Controller
{

    public function index()
    {
        // Mengambil produk beserta data kategorinya (Eager Loading)
        $products = Product::with('category')->get();

        return view('products.index', compact('products'));
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



}