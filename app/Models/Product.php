<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    } 

    public function scopeFilter($query)
    { 
      if(request('search')){
        
        $query 
        ->where('title', 'like', '%' . request('search') . '%')
        ->orWhere('description', 'like', '%' . request('search') . '%')
        ->orWhere('price', 'like', '%' . request('search') . '%');
      }
      if(request('filter_category')){
        if(request('filter_category') === 'all'){
          $query
          ->where('title', 'like', '%' . '' . '%');
        }
        else{
          $query
          ->where('category_id', 'like', request('filter_category'));
        }
      }
    }
    public function getCategoryAttribute()
    {
     $category = ProductCategory::find($this->category_id);
     if(!$category){ 
       return 'none';
      }
     return $category->title;
    }
}
