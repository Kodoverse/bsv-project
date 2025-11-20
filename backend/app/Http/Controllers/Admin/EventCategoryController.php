<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $eventCategories = EventCategory::where("parent_id", null)->paginate(8);
        return view("admin.event-categories.index", compact("eventCategories"));
    }
    public function create(Request $request)
    {
        $parent = null;
        $categories = EventCategory::whereNull('parent_id')->get();

        if ($request->has('parent_id')) {
            $parent = EventCategory::findOrFail($request->get('parent_id'));
        }

        return view('admin.event-categories.create', compact('parent', 'categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
            'parent_id' => 'nullable|exists:event_categories,id',
        ]);

        if (!isset($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        if ($request->has('parent_id')) {
            $validated['parent_id'] = $request->input('parent_id');
        }
        EventCategory::create($validated);

        return redirect()
            ->route('admin.event-categories.index')
            ->with('success', 'Categoria creata con successo.');

    }
    public function show(EventCategory $eventCategory)
    {


        $events = $eventCategory->events()->paginate(4);
        return view("admin.event-categories.show", compact("eventCategory", "events"));

    }
    public function showSubcategory(EventCategory $parent, EventCategory $child)
    {
        abort_unless($child->parent_id === $parent->id, 404);
        $child->load(['parent', 'events' => fn($q) => $q->withCount('registrations')]);

        $events = $child->events()->paginate(6);

        return view('admin.event-categories.show', [
            'eventCategory' => $child,
            'events' => $events,
        ]);
    }

    public function edit(EventCategory $eventCategory)
    {
        $categories = EventCategory::whereNull('parent_id')
            ->where('id', '!=', $eventCategory->id)
            ->get(['id', 'name']);
        return view('admin.event-categories.edit', compact('eventCategory', 'categories'));
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
            'parent_id' => 'nullable|exists:categories_id',
        ]);
        $eventCategory->update($validated);
        return redirect()
            ->route('admin.event-categories.show', $eventCategory->id)
            ->with('success', 'Categoria aggiornata con successo!');
    }

    public function destroy(EventCategory $eventCategory)
    {
        $eventCategory->delete();
        return redirect()->route('admin.event-categories.index')->with('success', 'Categoria Cancellata');
    }
}
