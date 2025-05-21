<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Item;

class HomeController extends Controller
{
    public function index()
    {
        $auctions = Auction::where('status', 'ongoing')->get(); // sesuaikan jika ada filter
        $items = Item::with('reviews')->where('status', 'available')->get();

        return view('customer.home', compact('auctions', 'items'));
    }
}
