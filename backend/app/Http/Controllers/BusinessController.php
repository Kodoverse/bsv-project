<?php

namespace App\Http\Controllers;

use App\Models\PartnerInfo;
use Illuminate\Http\Request;

use App\Models\Business;

use Illuminate\Support\Facades\Auth;
class BusinessController extends Controller
{
    public function index()
    {
        return view('partner.tabs.profile');
    }

    public function create()
    {
        return view('partner.tabs.profile');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $user = Auth::user();
        $business = Business::find($id);
        $partner = $user->partnerInfo;
        return view('businesses.show', compact('business', 'partner'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
