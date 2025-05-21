<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $categories = Category::all();
    return view('admin.category.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Category::create($request->all());
    return redirect()->route('admin.category.index')->with('success', 'Catégorie ajoutée.');
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
   public function edit(Category $category)
{
    return view('admin.category.edit', compact('category'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $category->update($request->all());
    return redirect()->route('admin.category.index')->with('success', 'Catégorie mise à jour.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
{
        // dd($category);
    $category->delete();
    return redirect()->route('admin.category.index')->with('success', 'Catégorie supprimée.');
}
}
