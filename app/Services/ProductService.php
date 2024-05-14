<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Http\UploadedFile;
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

    static function storeProduct(array $data)
    {
        $product = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price']
        ]);
        static::setProductImage($data['product_image'] ?? null, $product);
        static::setCategory($data['category'] ?? null, $data['custom_category'] ?? null, $product);
        return $product;
    }

    static function updateProduct(array $data, Product $product)
    {
        static::setCategory($data['category'] ?? null, $data['custom_category'] ?? null, $product);
        unset($data['category']);
        unset($data['custom_category']);
        static::setProductImage($data['product_image'] ?? null, $product);
        unset($data['product_image']);
        $product->update($data);
        return $product;
    }

    static function deleteProduct(Product $product)
    {
        $product->delete();
    }

    static function getOrCreateCategory(?string $categoryTitle)
    {
        $category = ProductCategory::where('title', $categoryTitle)->first() ?? null;
        if (!$category) {
            $category = ProductCategory::create(['title' => $categoryTitle]);
            return $category->id;
        }
        return $category->id;
    }
    static function setProductImage(string|null|UploadedFile $productImage, Product $product)
    {
        try {
            if ($productImage) {
                $filename = Str::random(20);
                if (gettype($productImage) === "string") {
                    $productImage = file_get_contents($productImage);
                }
                //  dd($productImage);
                if (gettype($productImage) === "object") {
                    // dd($productImage);
                    $productImage = file_get_contents($productImage->path());
                }
                $pathname = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'public/products/images/' . $filename);
                $success = Storage::disk('local')->put($pathname, $productImage);
                if (!$success) {
                    abort(500);
                }
                $product->update(['product_image' => 'products/images/' . $filename]);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    static function setCategory(?string $category, ?string $customCategory, Product $product)
    {
        $categoryId = '';
        if ($category) {
            if ($category == 'custom') {
                $category = null;
                $categoryId = $customCategory ? static::getOrCreateCategory($customCategory) : null;
            } else {
                $categoryId = static::getOrCreateCategory($category);
            }
            $product->update(['category_id' => $categoryId]);
            return true;
        }
        $product->update(['category_id' => null]);
    }
}
