<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\ActivityTracker;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        $products_silder = Product::inRandomOrder()->limit(6)->get();
        $products = auth()->user()->products;
        $sub_total = auth()->user()->products()->sum(\DB::raw('products.price * product_user.quantity'));
        $tax_amount = $sub_total * ($setting->tax / 100);
        $total_price = $sub_total + $tax_amount + $setting->shipping;
        
         ActivityTracker::track(
            'VIEW_CART_LIST',
            'Cart Product Listing.'
        );


        return view('front.cart.index',compact('products','tax_amount','sub_total','total_price','products_silder'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {

            $cart = session()->get('guest_cart', []);

            $cart[] = [
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ];

            session()->put('guest_cart', $cart);

            return redirect()->route('login');
        }
        $request->validate([
            'product_id' =>Rule::unique('product_user')->where(function ($query) use ($request) {
                return $query->where('product_id', $request->product_id)
                   ->where('user_id', auth()->user()->id);
             })
        ]);
        $checkStock = true;
        $product = Product::find($request->product_id);
        $checkStock = $product->stock < $request->quantity;

        if($checkStock){
            return redirect()->back()->withErrors(["product_available" => __('site.product_available')])->withInput();
        }

        ActivityTracker::track(
            'ADD_TO_CART',
            'Product added to cart',
            $product
        );

        auth()->user()->products()->attach($request->product_id,['quantity' => $request->quantity]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->back();
    }

    public function update(Request $request,User $user)
    {
        $products = $request->products ? $request->products : [];
        if($request->exists('clear')){
             ActivityTracker::track(
                    'CART_PRODUCT_REMOVED',
                    'Cart Product removed'
                );

            auth()->user()->products()->detach();
        }

        if ($request->exists('update')) {
            foreach(auth()->user()->products as $product){
            if(!in_array($product->id,$products)){
                auth()->user()->products()->detach($product->id);
            }
            }
            foreach($products as $index => $product_id){
                auth()->user()->products()->updateExistingPivot($product_id,[
                    'quantity'=> $request->quantity[$index],
                ]);
            }

              ActivityTracker::track(
                    'CART_UPDATED',
                    'Product cart updated'
                );
        }

        return redirect()->back();
    }

}
