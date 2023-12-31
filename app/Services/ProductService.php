<?php 

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductService{
    static function getAllProducts(){
        $products = Product::latest('updated_at')->filter()->get();
        return $products;
    }
    
    static function getAllCategories(){
$categories = ProductCategory::all();
return $categories;
    }

    static function storeProduct($request){
        $product = Product::create($request->only('title', 'description', 'price'));

        $data = $request->all();

        if($request->hasFile('product_image')) {
            $path = $request->product_image->store('public/products/images'); 
    
             $product->update(['product_image' => $path]);
           }
        if($data['category']) {
            $category_id = static::getOrCreateCategoryId($data['category']);
            $product->update(['category_id' => $category_id]);
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
        if($data['category']) {
            $category_id = static::getOrCreateCategoryId($data['category']);
            unset($data['category']);
            $product->update(['category_id' => $category_id]);
           }
        $product->update($data);
    
        return $product;
      }

      static function deleteProduct($product){
        $product->delete();
      }

      static function getOrCreateCategoryId($category){
        $categoryObj = ProductCategory::where('title', $category)->first();

        if (!$categoryObj) {

            $categoryObj = ProductCategory::create(['title' => $category]);
            return $categoryObj->id;
        }
        

            return $categoryObj->id;
        
      }
}