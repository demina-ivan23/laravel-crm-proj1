<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Prospect,
    Product,
    Order
};

class ProspectsProductsOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboards.prospects-products-orders', ['prospects' => Prospect::latest()->filter()->paginate(15), 'products' => Product::latest()->filter()->paginate(15), 'orders' => Order::latest()->filter()->paginate(15)]);
    }
}