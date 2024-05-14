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

  public function category()
  {
    return $this->belongsTo(ProductCategory::class);
  }

  public function scopeFilter($query)
  {
    if (request('search')) {

      $query
        ->where('title', 'like', '%' . request('search') . '%')
        ->orWhere('description', 'like', '%' . request('search') . '%')
        ->orWhere('price', 'like', '%' . request('search') . '%');
    }
    if (request('filter_category')) {
      if (request('filter_category') === 'all') {
        $query
          ->where('title', 'like', '%' . '' . '%');
      } else {
        $query
          ->where('category_id', 'like', request('filter_category'));
      }
    }
    $filters = request()->input();

    // Apply category filters
    if (isset($filters['category_filter'])) {
      $categoryFilters = explode(',', $filters['category_filter']);
      $query->whereIn('category_id', $categoryFilters);
      if(in_array('none', $categoryFilters)){
        $query->whereIn('category_id', $categoryFilters)->orWhere('category_id', null);
      }
    }

    if (isset($filters['price_filter'])) {
      $priceFilters = $filters['price_filter'];
      if (!is_array($priceFilters)) {
        $priceFilters = explode(',', $priceFilters);
      }
      $query->where(function ($query) use ($priceFilters) {
        foreach ($priceFilters as $priceFilter) {
          switch ($priceFilter) {
            case '<10':
              $query->orWhere('price', '<', 10);
              break;
            case '10-100':
              $query->orWhereBetween('price', [10, 100]);
              break;
            case '100-500':
              $query->orWhereBetween('price', [100, 500]);
              break;
            case '500-1000':
              $query->orWhereBetween('price', [500, 1000]);
              break;
            case '1000-5000':
              $query->orWhereBetween('price', [1000, 5000]);
              break;
            case '>5000':
              $query->orWhere('price', '>', 5000);
              break;
            default:
              break;
          }
        }
      });
    }
    return $query;
  }
}
