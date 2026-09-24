<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ActivityTracker;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function authenticated(Request $request, $user)
{
    ActivityTracker::track('LOGIN',
    'User logged in');
    if (session()->has('guest_cart')) {

        $guestCart = session()->pull('guest_cart');

        foreach ($guestCart as $item) {

            $exists = $user->products()
                ->where('product_id', $item['product_id'])
                ->exists();

            if (!$exists) {

                $user->products()->attach(
                    $item['product_id'],
                    [
                        'quantity' => $item['quantity']
                    ]
                );

            } else {

                $currentQty = $user->products()
                    ->where('product_id', $item['product_id'])
                    ->first()
                    ->pivot
                    ->quantity;

                $user->products()->updateExistingPivot(
                    $item['product_id'],
                    [
                        'quantity' => $currentQty + $item['quantity']
                    ]
                );
            }
        }
    }
}

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        ActivityTracker::track('LOGOUT',
        'User logged out');
        return redirect()->route('home'); // or redirect('/');
    }

}
