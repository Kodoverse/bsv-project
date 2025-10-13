<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $eventCategories = EventCategory::where("parent_id", null)->get();
        return view("admin.event-categories.index", compact("eventCategories"));
    }
    public function create()
    {
        return view("admin.event-categories.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);


        try {
            if (!isset($validated['slug'])) {
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            }

            EventCategory::create($validated);

            return redirect()
                ->route('admin.event-categories.index')
                ->with('success', 'Categoria creata con successo.');
        } catch (\Throwable $e) {
            \Log::error('Errore creating EventCategory: ' . $e->getMessage(), [
                'exception' => $e,
                'validated' => $validated,
            ]);

            // Torna indietro con input e messaggio di errore
            return back()
                ->withInput()
                ->withErrors(['error' => 'Si è verificato un errore durante la creazione della categoria. Controlla i log.']);
        }
    }
    public function show(EventCategory $eventCategory)
    {
        return view("admin.event-categories.show", compact("eventCategory"));
    }
    public function edit(EventCategory $eventCategory)
    {

        return view("admin.event-categories.edit", compact("eventCategory"));
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $eventCategory->update($request->all());

        return redirect()
            ->route('admin.event-categories.show', [$eventCategory->id]);
    }

    public function destroy(EventCategory $eventCategory)
    {
        $eventCategory->delete();
        return redirect()->route('admin.event-categories.index')->with('success', 'Categoria Cancellata');
    }
}
