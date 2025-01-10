<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserField;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        if (!session()->has('register_data') || !array_key_exists('price', session('register_data'))) {
            abort(404);
        }

        $price = session('register_data')['price'];

        return view('pages.register_payment', compact('price'));
    }

    public function postPayment(Request $request)
    {
        if ($request->payment < $request->price) {
            return redirect()->route('payment')->with('error', __('lang.underpaid_message', ['amount' => $request->price - $request->payment]));
        } 
        
        if ($request->payment > $request->price) {
            return redirect()->route('payment')->with([
                'overpaid' => true,
                'amount' => $request->payment - $request->price,
                'price' => $request->price
            ]);
        }

        return $this->createUserFromSessionData();
    }

    public function overpaid(Request $request)
    {
        return $this->createUserFromSessionData($request->amount);
    }

    private function createUserFromSessionData($additionalCoins = 0)
    {
        $sessionData = session('register_data');

        $user = User::create([
            'name' => $sessionData['name'],
            'email' => $sessionData['email'],
            'password' => Hash::make($sessionData['password']),
            'gender' => $sessionData['gender'],
            'profession_id' => $sessionData['profession'],
            'linkedin' => $sessionData['linkedin'],
            'mobile_number' => $sessionData['mobile_number'],
            'coins' => $additionalCoins ? 100 + $additionalCoins : 100, 
        ]);

        $user->fields()->createMany(
            array_map(fn($field) => ['field_of_work_id' => $field], $sessionData['fields'])
        );

        Auth::login($user);

        return redirect()->route('homepage');
    }
}
