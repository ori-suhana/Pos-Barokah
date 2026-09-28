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
}