<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class ProductsApiController extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ProductService::getAllProducts(); // it shows the latest prospects first
        return response()->json(['products' => $products]);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = ProductService::storeProduct($request->all());
        if($product){
            return response()->json(['result' => 'Product created successfully', 'product' => $product]);
        } else {
            return response()->json(['result' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = ProductService::findProduct($id);
        return response()->json(['product' => $product]);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $data['product_id'] = $id;
        $product = ProductService::updateProduct($data);
        if($product){
            return response()->json(['result' => 'Product updated successfully', 'product' => $product]);
        } else {
            return response()->json(['result' => 'Something went wrong']);
        }
    }
    // public function delete(string $id)
    // {
    //     // some space for soft deletes       
    // }
  
}
