<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerSalesController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $sale = Purchase::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $sale->status = $request->status;
        $sale->save();

        return redirect()->back()->with('success', 'Order status updated!');
    }
}