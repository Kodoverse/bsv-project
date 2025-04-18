<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
class ApiSectionController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::with('page_sections.images')->get();
        
        return response([
            'success'=> true,
            'results'=> $sections,
        ]);
    }
}
