<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Prospect,
    Product,
    Order,
    OrderStatus,
    ProductCategory,
    ProspectState
};

class ProspectsProductsOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboards.prospects-products-orders', [
            'prospects' => Prospect::latest()->filter()->paginate(15),
            'states' => ProspectState::all(),
            'products' => Product::latest()->filter()->paginate(15),
            'categories' => ProductCategory::all(),
            'orders' => Order::latest()->filter()->paginate(15),
            'statuses' => OrderStatus::all()
        ]);
    }
}
