<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
{
    $products = Product::with('category')->latest()->paginate(10);
 
    return view('master-data.product.index', compact('products'));
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