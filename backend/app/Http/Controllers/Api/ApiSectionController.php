<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
class ApiSectionController extends Controller
{
    public function index(Request $request){
        $query = Section::query()->with('page_sections.images');
    
        if ($request->has('title')) {
            $title = strtolower(str_replace(' ', '', trim($request->query('title'))));
            $query->whereRaw('REPLACE(LOWER(title), " ", "") = ?', [$title]);
        }
    
        $sections = $query->get();
    
        return response()->json([
            'success' => true,
            'results' => $sections
        ]);
    }
}
