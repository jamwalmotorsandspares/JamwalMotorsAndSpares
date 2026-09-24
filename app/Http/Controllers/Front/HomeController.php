<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ActivityTracker;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function index(){
        $categories = Category::where('category_type','sub_category')->wherehas('products')->inRandomOrder()->with('products')->limit(5)->get();
        // dd($categories);   
        ActivityTracker::track(
                                        'CATEGORY_VIEW',
                                        'Customer viewed category'
                                    );
        return view('front.index',compact('categories'));
    }
}
