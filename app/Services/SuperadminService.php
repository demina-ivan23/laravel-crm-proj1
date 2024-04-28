<?php

namespace App\Services;

use DateTime;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ProspectState;
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
            'order_chart_info' => static::getOrderChartInfo($query) ?? [],
            
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
                    $array[$i] = static::processByFilter('category', 'products' , $category, $order_statuses, $daysCount, $daysArray);
                    $i++;
                }
                $array[$i] = static::processByFilter('category', 'products' , null , $order_statuses, $daysCount, $daysArray);
            } elseif ($query['product_category'] != null) {
                $category = ProductCategory::find($query['product_category']);
                if (!$category) {
                    return null;
                }
                $array[0] = static::processByFilter('category', 'products' , $category, $order_statuses, $daysCount, $daysArray);
            } else {
                $array[0] = static::processByFilter('category', 'products' , null, $order_statuses, $daysCount, $daysArray);
            }
            return $array;
        }
        return null;
    }
    
    static function processByFilter($filterName, $elementsName , ?object $filterObect, mixed $order_statuses, int $daysCount, array $daysArray)
    {
        $result[$filterName] = $filterObect ? $filterObect->title  : 'without a ' . $filterName;
        for ($k = 0; $k <= $daysCount; $k++) {
            $result[$elementsName][$k] = static::getElementCountByFilterAtDate($elementsName, $filterName . '_id' , $filterObect ? $filterObect->id : null, $daysArray[$k]);
            foreach ($order_statuses as $order_status) {
                $result['order_statuses'][$k][$order_status->title] = static::getOrderStatusCountAtDate($elementsName, $order_status->id, $filterName . '_id', $filterObect ? $filterObect->id : null, $daysArray[$k]);
            }
        }
        return $result;
    }
    
    static function getElementCountByFilterAtDate(string $element, string $filterName, ?string $filterId, string $date)
    {

            return Order::whereHas($element, function ($query) use ($filterName, $filterId) {
                $query->where($filterName, $filterId);
            })
            ->whereDate('created_at', $date)
            ->count();

    }
    
    static function getOrderStatusCountAtDate($elementName, int $orderStatusId, string $filterName, ?string $filterId, string $date)
    {
            return Order::whereHas('statuses', function ($query) use ($orderStatusId) {
                $query->where('order_status_id', $orderStatusId);
            })
            ->whereHas($elementName, function ($query) use ($filterName, $filterId) {
                if ($filterId !== null) {
                    $query->where($filterName, $filterId);
                } else {
                    $query->whereNull($filterName);
                }
            })
            ->whereDate('created_at', $date)
            ->count();
    }
    
    static function getOrderProspectChartInfo($query)
    {
        if ($query['order_prospect_chart_from'] ?? null && $query['order_prospect_chart_to'] ?? null) {
            $order_statuses  = OrderStatus::all();
            $array = [];
            $days = static::getDaysCount($query['order_prospect_chart_from'], $query['order_prospect_chart_to']);
            $daysCount = $days['days_count'];
            $daysArray = $days['days_array'];
            if ($query['prospect_state'] === 'all') {
                $i = 0;
                foreach (ProspectState::all() as $state) {
                    $array[$i] = static::processByFilter('state', 'customer' , $state, $order_statuses, $daysCount, $daysArray);
                    $i++;
                }
                $array[$i] = static::processByFilter('state', 'customer' , null, $order_statuses, $daysCount, $daysArray);
            } elseif ($query['prospect_state'] != null) {
                $state = ProspectState::find($query['prospect_state']);
                if(!$state)
                {
                    return null;
                }
                $array[0] = static::processByFilter('state', 'customer' , $state , $order_statuses, $daysCount, $daysArray);
            } 
           return $array;
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
    static function getOrderChartInfo($query)
    {
        if($query['order_chart_from'] ?? null && $query['order_chart_to'] ?? null)
        {
            $order_statuses  = OrderStatus::all();
            $array = [];
            $days = static::getDaysCount($query['order_chart_from'], $query['order_chart_to']);
            $daysCount = $days['days_count'];
            $daysArray = $days['days_array'];
            $i = 0;
            $statuses = [];
            if($query['order_status'] === 'all')
            {
                $statuses = OrderStatus::all();
            } elseif($query['order_status'] != null) {
                $statuses = OrderStatus::where('title', $query['order_status']);
            }
            foreach($statuses as $status){
                $array[$i] = static::processForOrder($status->title, $status->id, $daysCount, $daysArray); 
                $i++;
            }
            return $array;
        }
        return null;
    }
    static function processForOrder(string $status_title, int $status_id, int $daysCount, array $daysArray)
    {
            $result = [];
            $result['status'] = $status_title;
                    for ($k = 0; $k <= $daysCount; $k++) {
                        $result['orders'][$k]  = Order::whereHas('statuses', function ($query) use ($status_id) {
                            $query->where('order_status_id', $status_id);
                        })->whereDate('created_at', $daysArray[$k])->count(); 
         }
         return $result;
    }
   
}
