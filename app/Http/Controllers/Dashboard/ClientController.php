<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Notifications\NewCustomerNotification;



class ClientController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('check-permissions', 'read_users');
        $clients = User::with('orders')->when($request->search,function ($query) use ($request){
            return $query->where('first_name','Like','%'.$request->search.'%')->orWhere('last_name','Like','%'.$request->search.'%')
            ->orWhere('email','Like','%'.$request->search.'%')->orWhere('phone','Like','%'.$request->search.'%');
        })->latest()->paginate(10);
        return view('dashboard.clients.index', compact('clients'));
    }

      public function create()
    {
        $this->authorize('check-permissions', 'create_clients');
        return view('dashboard.clients.create');
    }


    public function store(Request $request)
    {
        $this->authorize('check-permissions', 'create_clients');
        $request->validate([
            "first_name" => ['required', 'string', 'max:50'],
            "last_name" => ['required', 'string', 'max:50'],
            "phone"=>"required|digits:11",
            "email" => ['required', 'string', 'email', 'max:50', 'unique:admins'],
            "password" => ['required', 'string', 'min:8','max:50', 'confirmed'],
            "city" => ['required', 'string', 'max:50'],
            "state" => ['required', 'string', 'max:50'],
            "street" => ['required', 'string', 'max:100'],
            "building" => ['required', 'string', 'max:1000'],
            "apartment" => ['required', 'string', 'max:100'],
            "floor" => ['required', 'numeric', 'max:100'],
        ]);
        $request_data = $request->all();
        $request_data = $request->except(['password','password_confirmation']);
        $request_data['governorate'] =$request->state;
        unset($request_data['state']);
        $request_data['password'] = bcrypt($request->password);
//         dd($request_data);
        $customer = User::create($request_data);

        //admin notification
        $admins = Admin::where('role', 'super_admin')->first();

        // foreach ($admins as $admin) {
            $admins->notify(new NewCustomerNotification($customer));
        // }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }


    public function show(User $client)
    {
        $this->authorize('check-permissions', 'read_users');
        return view('dashboard.clients.show', compact('client'));
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $client
     * @return \Illuminate\Http\Response
     */
    // public function destroy($test,Request $request)
    // {
    //     $clients_arr = explode(",",$request->mass_delete);
    //     $clients = User::whereIn('id', $clients_arr);
    //     $clients->delete();
    //     session()->flash('success', __('site.deleted_successfully'));
    //     return redirect()->route('dashboard.suppliers.index');
    // }

}
