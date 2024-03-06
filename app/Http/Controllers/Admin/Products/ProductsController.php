<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;


class ProductsController extends Controller
{
 
    public function index()
    {
        $categories = ProductService::getAllCategories();
        $products = ProductService::getAllProducts();
        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }


    public function create()
    {
       return view('admin.products.create');
    }

  
    public function store(StoreProductRequest $request)
    {
        $product = ProductService::storeProduct($request);
        return redirect('/products/products')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = ProductService::findProduct($id);
        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = ProductService::getProductById($id);
        return view('admin.products.edit', ['product' => $product]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = ProductService::updateProduct($request, $id);
        if($product){

            return redirect('/products/products')->with('success', 'Product updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = ProductService::getProductById($id);

        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }

        ProductService::deleteProduct($product);
        return redirect('/products/products');
    }
}
