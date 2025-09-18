<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventCategoryController extends Controller
{
    // Constructor removed - middleware moved to routes file
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $categories = EventCategory::withCount('events')
                ->orderBy('name')
                ->get();

            return response()->json($categories)
                ->header('Access-Control-Allow-Origin', 'http://localhost:5173')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        } catch (\Exception $e) {
            \Log::error('Error fetching event categories: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json(['error' => 'Internal server error', 'message' => $e->getMessage()], 500)
                ->header('Access-Control-Allow-Origin', 'http://localhost:5173')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:event_categories',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7', // hex color
            'image' => 'nullable|image|max:2048' // max 2MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event-categories', 'public');
            $validated['image'] = $path;
        }

        $category = EventCategory::create($validated);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventCategory $eventCategory): JsonResponse
    {
        return response()->json($eventCategory->load(['events' => function($query) {
            $query->orderBy('starts_at', 'desc');
        }]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventCategory $eventCategory): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:event_categories,name,' . $eventCategory->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'image' => 'nullable|image|max:2048' // max 2MB
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($eventCategory->image) {
                Storage::disk('public')->delete($eventCategory->image);
            }
            
            $path = $request->file('image')->store('event-categories', 'public');
            $validated['image'] = $path;
        }

        $eventCategory->update($validated);

        return response()->json($eventCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventCategory $eventCategory): JsonResponse
    {
        // Check if category has events
        if ($eventCategory->events()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category with existing events'
            ], 422);
        }

        // Delete the image if it exists
        if ($eventCategory->image) {
            Storage::disk('public')->delete($eventCategory->image);
        }

        $eventCategory->delete();

        return response()->json(null, 204);
    }
}
