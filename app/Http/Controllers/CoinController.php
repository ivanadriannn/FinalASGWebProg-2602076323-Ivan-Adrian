<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CoinController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('pages.top-up-coin', compact('user', 'notifications'));
    }

    public function add_coin()
    {
        $user = Auth::user();
        $user->increment('coins', 100);
        return redirect()->route('topup');
    }

}
