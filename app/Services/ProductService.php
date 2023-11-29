<?php 

namespace App\Services;

use App\Models\Product;


class ProductService{
    static function getAllProducts(){
        $products = Product::latest('updated_at')->paginate(30);
        return $products;
    }
    
    static function storeProduct($request){
        $product = Product::create($request->only('title', 'description', 'price'));

        if($request->hasFile('product_image')) {
            $path = $request->product_image->store('public/products/images'); 
    
             $product->update(['product_image' => $path]);
           }
           return $product;
    }
    
    static function getProductById($id)
    {
        $product = Product::find($id);
        return $product;
    }

    static function updateProduct($request, $id){
        $data = $request->all();
    
        $product = static::getProductById($id);
    
        if(!$product){
            return null;
        }
    
        if($request->hasFile('product_image')){
            $path = $request->product_image->store('public/products/images');
            $data['product_image'] = $path;
        }
    
        $product->update($data);
    
        return $product;
      }

      static function deleteProduct($product){
        $product->delete();
      }

}