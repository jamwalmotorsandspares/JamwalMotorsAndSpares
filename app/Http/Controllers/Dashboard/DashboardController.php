<?php

namespace App\Http\Controllers\Dashboard;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function index(){

        //----------
        //-- Monthly sales and purchases data stats
        //----------
        $sales_amount_paid = Order::select(
            \DB::raw('SUM(total_price) as subtotal'),
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
          )->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
          ->groupBy('month', 'year')->where('payment_status',1)->get();
        $sales_amount_unpaid = Order::select(
            \DB::raw('SUM(total_price) as subtotal'),
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
          )->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
          ->groupBy('month', 'year')->where('payment_status',3)->get();

        $reports = Report::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

        $total_sales = Order::where('payment_status',1)->sum('total_price');
        $total_sales_current_month = Order::where('payment_status',1)->whereMonth('created_at', now()->month)->sum('total_price');
        $today_sales = Order::where('payment_status',1)->whereDate('created_at', today())->sum('total_price');
        $orders_count = Order::count();
        $categories_count = Category::count();
        $brands_count = Brand::count();
        $products_count = Product::count();
        $total_product_purchases=Product::sum(DB::raw('purchase_price * stock'));
        $clients_count = User::count();
        $supplier_count = Supplier::count();


        //top customers according to order count
        $topCustomersOrder = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total_price) as total_amount')
            )
            ->groupBy(
                'users.id',
                'users.first_name',
                'users.last_name'
            )
            ->orderByDesc('order_count')
            ->limit(10)
            ->get();

// best selling product
    $bestSellingProduct = DB::table('product_order')
    ->join('products', 'products.id', '=', 'product_order.product_id')
    ->select(
        'products.id',
        'products.name_en',
        DB::raw('SUM(product_order.quantity) as total_quantity'),
        DB::raw('SUM(product_order.quantity * product_order.price) as total_amount')
    )
    ->groupBy('products.id', 'products.name_en')
    ->orderByDesc('total_quantity')
    ->limit(10)
    ->get();

    //customer with most order

    // $topCustomer = DB::table('orders')
    // ->join('users', 'users.id', '=', 'orders.user_id')
    // ->select(
    //     'users.id',
    //     'users.first_name',
    //     'users.last_name',
    //     DB::raw('COUNT(orders.id) as order_count'),
    //     DB::raw('SUM(orders.total_price) as total_amount')
    // )
    // ->groupBy(
    //     'users.id',
    //     'users.first_name',
    //     'users.last_name'
    // )
    // ->orderByDesc('order_count')
    // ->first();
    //topCustomerProducts

    // $topCustomerProducts = DB::table('product_order')
    // ->join('orders', 'orders.id', '=', 'product_order.order_id')
    // ->join('products', 'products.id', '=', 'product_order.product_id')
    // ->where('orders.user_id', $topCustomer->id)
    // ->select(
    //     'products.id',
    //     'products.name_en',
    //     DB::raw('SUM(product_order.quantity) as quantity'),
    //     DB::raw('SUM(product_order.quantity * product_order.price) as amount')
    // )
    // ->groupBy('products.id', 'products.name_en')
    // ->orderByDesc('quantity')
    // ->get();

//top seeling 10 Categories

// $topCategories = DB::table('product_order')
//     ->join('products', 'products.id', '=', 'product_order.product_id')
//     ->join('categories', 'categories.id', '=', 'products.category_id')
//     ->select(
//         'categories.id',
//         'categories.name_en',
//         DB::raw('SUM(product_order.quantity) as total_quantity'),
//         DB::raw('SUM(product_order.quantity * product_order.price) as total_amount')
//     )
//     ->groupBy('categories.id', 'categories.name_en')
//     ->orderByDesc('total_quantity')
//     ->limit(10)
//     ->get();



        return view('dashboard.index',compact('reports','supplier_count','clients_count','products_count','topCustomersOrder','bestSellingProduct'
        ,'categories_count','orders_count','total_sales','brands_count','total_product_purchases','sales_amount_paid','sales_amount_unpaid','total_sales_current_month','today_sales'));
    }
}
