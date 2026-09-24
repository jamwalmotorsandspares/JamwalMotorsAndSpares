<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\VisitorHistory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VisitorHistoryController extends Controller
{

    public function index()
    {
        $histories = VisitorHistory::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(30);

        return view(
            'dashboard.visitor-history.index',
            compact('histories')
        );
    }

    public function history()
    {
        $histories = VisitorHistory::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(30);

        return view(
            'dashboard.visitor-history.index',
            compact('histories')
        );
    }

    public function guestHistory(Request $request)
    {
        $histories = VisitorHistory::where(
            'session_id',
            $request->session()->getId()
        )
        ->latest()
        ->get();

        return view(
            'visitor.history',
            compact('histories')
        );
    }
    public function navigation(Request $request)
    {
        VisitorHistory::create([
            'user_id' => auth()->id(),
            'session_id' => $request->session()->getId(),
            'url' => $request->url,
            'route_name' => optional($request->route())->getName(),
            'method' => 'GET',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true
        ]);
    }

}
