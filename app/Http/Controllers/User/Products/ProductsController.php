<?php

namespace App\Http\Controllers\User\Products;


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
        return view('user.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }


    public function create()
    {
       return view('user.products.create');
    }

  
    public function store(StoreProductRequest $request)
    {
        $product = ProductService::storeProduct($request->all());
        return redirect('/products/products')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = ProductService::findProduct($id);
        return view('user.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = ProductService::getProductById($id);
        return view('user.products.edit', ['product' => $product]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->all();
        $data['product_id'] = $id;
        $product = ProductService::updateProduct($data);
        if($product){
            return redirect('/products/products')->with('success', 'Product updated successfully');
        } else {
            return redirect('/products/products')->with('erorr', 'Something went wrong'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $product = ProductService::getProductById($id);

    //     if(!$product){
    //         abort(404);
    //     }

    //     ProductService::deleteProduct($product);
    //     return redirect('/products/products');
    // }
}
