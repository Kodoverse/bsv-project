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
        if ($request->status == 'completed') {
            $sale->completed_at = now();
        }
        if ($request->status == 'confirmed') {
            $sale->confirmed_at = now();
        }
        $sale->save();

        return redirect()->back()->with('success', 'Order status updated!');
    }
}