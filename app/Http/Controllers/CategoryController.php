<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    $categories = Category::latest()->paginate(10);
    return view('master-data.category.index', compact('categories'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-data.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    $validated = $request->validate([
        'name' => 'required|string|max:100|unique:categories,name',
        'description' => 'nullable|string|max:255',
    ]);
 
    Category::create($validated);
 
    return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
