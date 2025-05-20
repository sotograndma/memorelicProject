<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerVerificationController extends Controller
{
    public function prompt()
    {
        return view('customer.seller.prompt');
    }

    public function agreement()
    {
        return view('customer.seller.agreement');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'agree' => 'accepted'
        ]);

        $customer = Auth::user()->userable; // akses ke model Customer
        $customer->is_verified_seller = true;
        $customer->save();

        return view('customer.seller.loading');
    }
}
