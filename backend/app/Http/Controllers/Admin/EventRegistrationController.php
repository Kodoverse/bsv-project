<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function index()
    {
        return view('admin.registrations.index');
    }
}
