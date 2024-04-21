<?php

namespace App\Services;

use DateTime;
use App\Models\Order;
use App\Models\ProductCategory;

class SuperadminService {
    static function update($data)
    {
        
    }
    static function getDashboardData($query)
    {
        $data = [
            static::getOrderProductChartInfo($query) ?? [],
            static::getOrderProspectChartInfo($query) ?? [],
            //
        ];
        return $data;
    }
    static function getOrderProductChartInfo($query){
        if($query['order_product_chart_from'] ?? null && $query['order_product_chart_to'] ?? null){
            $array = [];
            $fromDate = new DateTime($query['order_product_chart_from']);
            $toDate = new DateTime($query['order_product_chart_to']);
            $interval = $fromDate->diff($toDate);
            $daysCount = $interval->days;
            $daysArray = [];
            for ($i = 0; $i <= $daysCount; $i++) {
                $daysArray[] = $fromDate->format('Y-m-d');
                $fromDate->modify('+1 day');
            }
            if($query['product_category'] == "all"){
                $i = 0;
                foreach(ProductCategory::all() as $category){
                    $array[$i]['category'] = $category->title;
                    for($k = 0; $k <= $daysCount; $k++){
                        $array[$i]['products'][$k] = Order::whereHas('products', function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                         })->whereDate('created_at', $daysArray[$k])->count();
                    }
                    $i++;
                } 
                $array[$i]['category'] = 'without a category';
                for($k = 0; $k <= $daysCount; $k++){
                    $array[$i]['products'][$k] = Order::whereHas('products', function ($query) use ($category) {
                    $query->where('category_id', null);
                     })->whereDate('created_at', $daysArray[$k])->count();
                    }
            } elseif($query['product_category'] != null)  {
                $category = ProductCategory::find($query['product_category']);
                if(!$category){
                    return null;
                }
                $array[0]['category'] = $category->title;
                for($k = 0; $k <= $daysCount; $k++){
                    $array[0]['products'][$k] = Order::whereHas('products', function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                    })->whereDate('created_at', $daysArray[$k])->count();
                }
                
            }
            // dd($array);
            return $array;
        }
        return null;
    }
    static function getOrderProspectChartInfo($query){
        
        return null;
    }
}