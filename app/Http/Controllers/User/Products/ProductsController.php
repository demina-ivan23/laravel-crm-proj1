<?php

namespace App\Http\Controllers\User\Products;


use App\Models\Product;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;


class ProductsController extends Controller
{
 
    public function index()
    {
        $categories = ProductService::getAllCategories();
        $products = ProductService::getAllProducts();
        return view('user.products.index', compact('products', 'categories'));
    }


    public function create()
    {
       return view('user.products.create');
    }

  
    public function store(StoreProductRequest $request)
    {
        $product = ProductService::storeProduct($request->all());
        return redirect()->route('user.products.dashboard')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('user.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('user.products.edit', compact('product'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = ProductService::updateProduct($request->all(), $product);
        if($product){
            return redirect()->route('user.products.dashboard')->with('success', 'Product updated successfully');
        } else {
            return redirect()->route('user.products.dashboard')->with('erorr', 'Something went wrong'); 
        }
    }

    public function delete(Product $product)
    {
       $product->delete();
       return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'products', 'tab-button' => 'productsTabButton'])->with('success', 'Product Trashed Successfully');
    }

    public function restore(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'products', 'tab-button' => 'productsTabButton'])->with('success', 'Product Restored Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->forceDelete();
        return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'products', 'tab-button' => 'productsTabButton'])->with('success', 'Product Deleted Permanently');
    }
}
