<?php

namespace App\Services;

use Exception;
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
        $success = static::setProductImage($product_image, $product);
        $success ? '' : abort(500); 
        $category = $data['category'] ?? null;
        static::setCategory($category, $data['custom_category'] ?? null, $product);
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
        $category = $data['category'] ?? null;
        static::setCategory($category, $data['custom_category'] ?? null, $product);
        unset($data['category'], $data['product_id']);
        if(array_key_exists('custom_category', $data)){
            unset($data['custom_category']);
        }
        $product->update($data);
        $product_image = $data['product_image'] ?? null;
        $success = static::setProductImage($product_image, $product);
        $success ? true : abort(500); 
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
    static function setProductImage($product_image, Product $product)
    {
        try {
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
            $product->update(['product_image' => 'products/images/' . $filename]);
        }
        return true;
       } catch(Exception $e) {
        return false;
       }
    }
    static function setCategory(?string $category, ?string $custom_category, Product $product)
    {
        if($category)
        {
            if($category == 'custom')
            {
                $category = null;
                $category_id = $custom_category ? static::getOrCreateCategoryId($custom_category) : null;
            } else {
                $category_id = static::getOrCreateCategoryId($category);
            }
            $product->update(['category_id' => $category_id]);
            return true;
        }
        $product->update(['category_id' => null ]);
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
