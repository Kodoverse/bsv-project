<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminPartnerRequest;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\PartnerInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('user_role', 'partner')
            ->with(['partnerInfo', 'products'])
            ->withCount('products');
        //FILTRI DA RIVEDERE
        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('partnerInfo', function ($subQ) use ($search) {
                        $subQ->where('business_name', 'like', "%{$search}%")
                            ->orWhere('business_address', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'active') {
                $query->whereHas('partnerInfo', function ($q) {
                    $q->where('is_active', true);
                });
            } elseif ($request->status === 'pending') {
                $query->whereDoesntHave('partnerInfo');
            } elseif ($request->status === 'suspended') {
                $query->whereHas('partnerInfo', function ($q) {
                    $q->where('is_active', false);
                });
            }
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('partnerInfo', function ($q) use ($request) {
                $q->where('business_category', $request->category);
            });
        }

        $partners = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        $busCategory = BusinessCategory::all();
        return view('admin.partners.create', compact('busCategory'));
    }

    public function store(StoreAdminPartnerRequest $request)
    {
        $data = $request->validated();

        $newUser = new User();
        $newUser->fill([
            'email' => $data['email'],
            'password' => Hash::make(\Illuminate\Support\Str::random(12)),
            'user_role' => 'partner',
        ]);
        $newUser->save();

        $partnerInfo = new PartnerInfo();
        $partnerInfo->fill([
            'user_id' => $newUser->id,
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'is_active' => $data['is_active'] ?? true,
            'redemption_rules' => 'Standard redemption rules apply.',
            'min_points_per_redemption' => 10,
            'max_points_per_redemption' => 1000,
        ]);
        $partnerInfo->save();


        $business = new Business();
        $business->fill([
            'name' => $data['business_name'],
            'business_category_id' => $data['business_category_id'],
            'address' => $data['business_address'],
            'description' => $data['business_description'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'email' => $data['business_email'] ?? null,
        ]);
        $business->save();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner creato con successo!');
    }
}