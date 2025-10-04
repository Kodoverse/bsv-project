<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $products = Product::forPartner($user->id)->get();
         dd($products);
        return view('partner.dashboard', compact('products'));
       
    }
}