<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategories::all();
        return view('admin.product-categories.index', [
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategories::all();
        return view('admin.product-categories.create', [
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => [
                'required',
                'max:255',
                Rule::unique('product_categories')->ignore($request->id),
            ],
        ], [
            'category_name.unique' => 'The product category name already exists.',
        ]);

        $data = $request->only(['category_name']);

        ProductCategories::create($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product category created successfully!');
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
        $productCategories = ProductCategories::findOrFail($id);
        return view('admin.product-categories.edit', [
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => [
                'required',
                'max:255',
                Rule::unique('product_categories')->ignore($request->id),
            ],
        ], [
            'category_name.unique' => 'The product category name already exists.',
        ]);

        $productCategories = ProductCategories::findOrFail($id);
        $productCategories->category_name = $request->input('category_name');
        $productCategories->save();

        return redirect()->route('admin.product-categories.index', [
            'success' => 'update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProductCategories::findOrFail($id)->delete();
        return redirect()->route('admin.product-categories.index');
    }
}
