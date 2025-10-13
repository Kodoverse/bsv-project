<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class SubCategoryEventController extends Controller
{
    public function index()
    {
        $subCategory = EventCategory::where('parent_id')->get();
        return view('admin.subcategories-event.index', compact('subCategory'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|exists:event_categories,id',
        ]);


        $subcategory = new EventCategory();
        $subcategory->name = $validated['name'];
        $subcategory->parent_id = $validated['parent_id'];

        $subcategory->save();

        return redirect()->route('admin.subcategories-event.index')->with('success', 'Sotto categoria creata');

    }
    public function show(EventCategory $eventCategory)
    {

    }

    public function create()
    {
        $eventCategories = EventCategory::whereNull('parent_id')->get();

        return view('admin.subcategories-event.create', compact('eventCategories'));
    }
    public function edit(Request $request)
    {
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }

}
