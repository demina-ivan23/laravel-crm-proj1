<?php

namespace App\Services;

use DateTime;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ProductCategory;

class SuperadminService
{
    static function update($data)
    {
    }
    static function getDashboardData($query)
    {
        $data = [
            'order_product_chart_info' => static::getOrderProductChartInfo($query) ?? [],
            'order_prospect_chart_info' => static::getOrderProspectChartInfo($query) ?? [],
        ];
        return $data;
    }
    static function getOrderProductChartInfo($query)
    {
        if ($query['order_product_chart_from'] ?? null && $query['order_product_chart_to'] ?? null) {
            $order_statuses  = OrderStatus::all();
            $array = [];
            $days = static::getDaysCount($query['order_product_chart_from'], $query['order_product_chart_to']);
            $daysCount = $days['days_count'];
            $daysArray = $days['days_array'];
            if ($query['product_category'] == "all") {
                $i = 0;
                foreach (ProductCategory::all() as $category) {
                    $array[$i]['category'] = $category->title;
                    for ($k = 0; $k <= $daysCount; $k++) {
                        $array[$i]['products'][$k] = Order::whereHas('products', function ($query) use ($category) {
                            $query->where('category_id', $category->id);
                        })
                            ->whereDate('created_at', $daysArray[$k])
                            ->count();
                        foreach ($order_statuses as $order_status) {
                            $array[$i]['order_statuses'][$k][$order_status->title] =
                                Order::whereHas('statuses', function ($query) use ($order_status) {
                                    $query->where('order_status_id', $order_status->id);
                            })->whereHas('products', function ($query) use ($category) {
                                $query->where('category_id', $category->id);
                            })
                                ->whereDate('created_at', $daysArray[$k])
                                ->count();
                        }
                    }
                    $i++;
                }
                $array[$i]['category'] = 'without a category';
                for ($k = 0; $k <= $daysCount; $k++) {
                    $array[$i]['products'][$k] = Order::whereHas('products', function ($query) use ($category) {
                        $query->where('category_id', null);
                    })
                    ->whereDate('created_at', $daysArray[$k])
                    ->count();
                    foreach ($order_statuses as $order_status) {
                        $array[$i]['order_statuses'][$k][$order_status->title] =
                            Order::whereHas('statuses', function ($query) use ($order_status) {
                                $query->where('order_status_id', $order_status->id);
                        })->whereHas('products', function ($query) use ($category) {
                            $query->where('category_id', $category->id);
                        })
                            ->whereDate('created_at', $daysArray[$k])
                            ->count();
                    }
                }
            } elseif ($query['product_category'] != null) {
                $category = ProductCategory::find($query['product_category']);
                if (!$category) {
                    return null;
                }
                $array[0]['category'] = $category->title;
                for ($k = 0; $k <= $daysCount; $k++) {
                    $array[0]['products'][$k] = Order::whereHas('products', function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                    })
                    ->whereDate('created_at', $daysArray[$k])
                    ->count();
                    foreach ($order_statuses as $order_status) {
                        $array[0]['order_statuses'][$k][$order_status->title] =
                            Order::whereHas('statuses', function ($query) use ($order_status) {
                                $query->where('order_status_id', $order_status->id);
                        })->whereHas('products', function ($query) use ($category) {
                            $query->where('category_id', $category->id);
                        })
                            ->whereDate('created_at', $daysArray[$k])
                            ->count();
                    }
                }
            } else {
                $array[0]['category'] = 'without a category';
                for ($k = 0; $k <= $daysCount; $k++) {
                    $array[0]['products'][$k] = Order::whereHas('products', function ($query){
                        $query->where('category_id', null);
                    })
                    ->whereDate('created_at', $daysArray[$k])
                    ->count();
                    foreach ($order_statuses as $order_status) {
                        $array[0]['order_statuses'][$k][$order_status->title] =
                            Order::whereHas('statuses', function ($query) use ($order_status) {
                                $query->where('order_status_id', $order_status->id);
                        })->whereHas('products', function ($query) {
                            $query->where('category_id', null);
                        })
                            ->whereDate('created_at', $daysArray[$k])
                            ->count();
                    }
                }
            }
            // dd($array);
            return $array;
        }
        return null;
    }
    static function getOrderProspectChartInfo($query)
    {
        if ($query['order_prospect_chart_from'] ?? null && $query['order_prospect_chart_to'] ?? null) {
            $array = [];
            $days = static::getDaysCount($query['order_prospect_chart_from'], $query['order_prospect_chart_to']);
            $daysCount = $days['days_count'];
            $daysArray = $days['days_array'];
            if ($query['prospect_state'] === 'all') {
            } elseif ($query['prospect_state'] != null) {
            }
        }
        return null;
    }
    static function getDaysCount($from, $to)
    {
        $fromDate = new DateTime($from);
        $toDate = new DateTime($to);
        $interval = $fromDate->diff($toDate);
        $daysCount = $interval->days;
        for ($i = 0; $i <= $daysCount; $i++) {
            $daysArray[] = $fromDate->format('Y-m-d');
            $fromDate->modify('+1 day');
        }
        return ['days_count' => $daysCount, 'days_array' => $daysArray];
    }
}
