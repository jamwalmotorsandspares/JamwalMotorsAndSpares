<?php

namespace App\Http\Controllers\Dashboard;

// use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index(Request $request)
    {

    // when($request->search,function ($query) use ($request){
    //         return $query->where('invoice_no','Like','%'.$request->search.'%')
    //         ->orWhereHas('user', function ($q) use ($request) {
    //             $q->where('first_name', 'like', '%'.$request->search.'%')->orWhere('last_name','like','%'.$request->search.'%');
    //         });
    //     })
        $notifications = auth()->user()
                        ->notifications()
                        ->latest()
                        ->paginate(10);
        return view('dashboard.notification.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return redirect(
            $notification->data['url'] ?? route('dashboard.notifications.index')
        );
    }

    public function markAsUnread($id)
    {
         $notification = auth()->user()
        ->notifications()
        ->where('id', $id)
        ->firstOrFail();

    $notification->markAsUnread();

       return redirect(
        $notification->data['url'] ?? route('dashboard.notifications.index')
         );
    }

}
