<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemReview;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ItemReviewController extends Controller
{

    public function store(Request $request, $transactionId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $transaction = Transaction::findOrFail($transactionId);

        $customerId = Auth::user()->userable_id;

        if ($transaction->customer_id != Auth::id()) {
            return back()->with('error', 'Akses tidak valid.');
        }

        $existing = ItemReview::where('transaction_id', $transactionId)->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk transaksi ini.');
        }

        ItemReview::create([
            'transaction_id' => $transactionId,
            'item_id' => $transaction->item_id,
            'customer_id' => $customerId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $transaction->update(['status' => 'completed']);

        return redirect()
            ->route('customer.payment.completed', ['transaction_id' => $transaction->id])
            ->with('review_submitted', true);
    }


}
