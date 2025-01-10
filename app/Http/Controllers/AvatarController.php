<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Avatar;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
                                    ->latest() 
                                    ->get();

        $avatars = Avatar::all();
        $transactions = Transaction::where('user_id', $user->id)->get();

        return view('pages.message', compact('notifications', 'friends'));
    }

    public function bought($avatar_id)
    {
        $user = Auth::user();
        $avatar = Avatar::find($avatar_id);

        if (!$avatar) {
            return redirect()->back()->with('error', @lang('lang.avatar_not_available'));
        }

        $transactionExists = Transaction::where([
            ['user_id', $user->id],
            ['avatar_id', $avatar_id]
        ])->exists();

        if ($transactionExists) {
            $user->update([
                'profile_image' => $avatar->image,
            ]);

            return redirect()->back()->with('success', __('lang.profile_updated'));
        }

        if ($user->coins < $avatar->price) {
            return redirect()->back()->with('error', __('lang.insuffcient_coin'));
        }

        $user->decrement('coins', $avatar->price);

        Transaction::create([
            'user_id' => $user->id,
            'avatar_id' => $avatar_id,
        ]);

        $user->update([
            'profile_image' => $avatar->image,
        ]);

        return redirect()->back()->with('success', __('lang.avatar_bought'));
    }

}
