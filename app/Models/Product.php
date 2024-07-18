<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory, SoftDeletes;

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
    $search = request('products-search');
    $filters = request()->input();

    $query->when($search, function ($query, $search) {
      $query->where(function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%')
          ->orWhere('description', 'like', '%' . $search . '%')
          ->orWhere('price', 'like', '%' . $search . '%');
      });
    });

    $query->when(isset($filters['products_category_filters']), function ($query) use ($filters) {
      $categoryFilters = explode(',', $filters['products_category_filters']);
      $query->where(function ($query) use ($categoryFilters) {
        $query->whereIn('category_id', $categoryFilters)
          ->orWhereNull('category_id');
      });
    });

    $query->when(isset($filters['products_price_filter']), function ($query) use ($filters) {
      $priceFilters = is_array($filters['products_price_filter']) ? $filters['products_price_filter'] : explode(',', $filters['products_price_filter']);
      $query->where(function ($query) use ($priceFilters) {
        foreach ($priceFilters as $priceFilter) {
          switch ($priceFilter) {
            case '<10':
              $query->where('price', '<', 10);
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
    });

    return $query;
  }
}
