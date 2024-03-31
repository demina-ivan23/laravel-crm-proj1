<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    static function getAllProducts()
    {
        $products = Product::latest('updated_at')->filter()->paginate(10);
        return $products;
    }

    static function getAllCategories()
    {
        $categories = ProductCategory::all();
        return $categories;
    }

    static function storeProduct($data)
    {
        $product = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price']
        ]);
        $product_image = $data['product_image'] ?? null;
        if ($product_image) {
            $filename = Str::random(20);
            if(gettype($product_image) === "string"){
            $product_image = file_get_contents($product_image);
             } 
            //  dd($product_image);
             if(gettype($product_image) === "object"){
                // dd($product_image);
            $product_image = file_get_contents($product_image->path());   
             }
            $pathname = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'public/products/images/' . $filename);
            $success = Storage::disk('local')->put($pathname, $product_image);
            if(!$success){
                abort(500);
               }
            $product->update(['product_image' => $pathname]);
        }
        $category = $data['category'] ?? null;
        if ($category) {
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

    static function updateProduct($data)
    {

        $product = static::getProductById($data['product_id']);

        if (!$product) {
            return null;
        }
        $product_image = $data['product_image'] ?? null;
        if ($product_image) {
            // $path = $request->product_image->store('public/products/images');
            // $data['product_image'] = $path;
        }
        $category = $data['category'] ?? null;
        if ($category) {
            $category_id = static::getOrCreateCategoryId($data['category']);
            unset($data['category']);
            $product->update(['category_id' => $category_id]);
        }
        unset($data['product_id']);
        $product->update($data);

        return $product;
    }

    static function deleteProduct($product)
    {
        $product->delete();
    }

    static function getOrCreateCategoryId($category)
    {
        $categoryObj = ProductCategory::where('title', $category)->first();

        if (!$categoryObj) {

            $categoryObj = ProductCategory::create(['title' => $category]);
            return $categoryObj->id;
        }


        return $categoryObj->id;
    }
    static function findProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
        return $product;
    }
}
