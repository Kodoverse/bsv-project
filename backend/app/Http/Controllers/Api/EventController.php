<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Constructor removed - middleware moved to routes
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Event::with(['category', 'creator'])
            ->withCount('registrations');

        // Filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        }

        // Filter by volunteer event if provided
        if ($request->has('is_volunteer_event')) {
            $isVolunteer = filter_var($request->is_volunteer_event, FILTER_VALIDATE_BOOLEAN);
            \Log::info('Filtering for volunteer events', ['is_volunteer_event' => $isVolunteer]);
            $query->where('is_volunteer_event', $isVolunteer);
        }

        $events = $query->orderBy('starts_at', 'desc')->paginate(10);
        
        \Log::info('Events query result', [
            'total' => $events->total(),
            'per_page' => $events->perPage(),
            'current_page' => $events->currentPage(),
            'has_volunteer_filter' => $request->has('is_volunteer_event'),
            'volunteer_events_count' => Event::where('is_volunteer_event', true)->count()
        ]);

        // Transform events to include full image URLs
        $events->getCollection()->transform(function ($event) {
            if ($event->image_url) {
                $event->image_url = $this->getFullImageUrl($event->image_url);
            }
            return $event;
        });

        return response()->json($events);
    }

    /**
     * Get upcoming events
     */
    public function upcoming(Request $request): JsonResponse
    {
        $query = Event::upcoming()
            ->with(['category', 'creator'])
            ->withCount('registrations');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $events = $query->orderBy('starts_at')->paginate(10);

        // Transform events to include full image URLs
        $events->getCollection()->transform(function ($event) {
            if ($event->image_url) {
                $event->image_url = $this->getFullImageUrl($event->image_url);
            }
            return $event;
        });

        return response()->json($events);
    }

    /**
     * Get finished events
     */
    public function finished(Request $request): JsonResponse
    {
        $query = Event::finished()
            ->with(['category', 'creator'])
            ->withCount('registrations');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $events = $query->orderBy('starts_at', 'desc')->paginate(10);

        // Transform events to include full image URLs
        $events->getCollection()->transform(function ($event) {
            if ($event->image_url) {
                $event->image_url = $this->getFullImageUrl($event->image_url);
            }
            return $event;
        });

        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'starts_at' => 'required|date|after:now',
            'ends_at' => 'required|date|after:starts_at',
            'is_volunteer_event' => 'sometimes|boolean',
            'volunteer_points' => 'nullable|integer|min:1',
            'max_participants' => 'nullable|integer|min:1'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('events', $imageName, 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Remove image from validated data since we're using image_url
        unset($validated['image']);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'upcoming';

        $event = Event::create($validated);
        $event->load(['category', 'creator']);

        // Transform image URL to full URL
        if ($event->image_url) {
            $event->image_url = $this->getFullImageUrl($event->image_url);
        }

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): JsonResponse
    {
        $event->load([
            'category',
            'creator',
            'registrations.user',
            'points.user'
        ]);

        // Transform image URL to full URL
        if ($event->image_url) {
            $event->image_url = $this->getFullImageUrl($event->image_url);
        }

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:event_categories,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'starts_at' => 'sometimes|required|date',
            'ends_at' => 'sometimes|required|date|after:starts_at',
            'status' => 'sometimes|required|in:upcoming,finished,cancelled',
            'is_volunteer_event' => 'sometimes|boolean',
            'volunteer_points' => 'nullable|integer|min:1',
            'max_participants' => 'nullable|integer|min:1'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image_url) {
                $oldImagePath = str_replace('/storage/', '', $event->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('events', $imageName, 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Remove image from validated data since we're using image_url
        unset($validated['image']);

        $event->update($validated);
        $event->load(['category', 'creator']);

        // Transform image URL to full URL
        if ($event->image_url) {
            $event->image_url = $this->getFullImageUrl($event->image_url);
        }

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): JsonResponse
    {
        // Check if event has registrations
        if ($event->registrations()->exists()) {
            return response()->json([
                'message' => 'Cannot delete event with existing registrations'
            ], 422);
        }

        // Delete associated image if exists
        if ($event->image_url) {
            $imagePath = str_replace('/storage/', '', $event->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $event->delete();

        return response()->json(null, 204);
    }

    /**
     * Get full image URL
     */
    private function getFullImageUrl($imageUrl)
    {
        if (!$imageUrl) {
            return null;
        }

        // If already a full URL, return as is
        if (str_starts_with($imageUrl, 'http')) {
            return $imageUrl;
        }

        // If starts with /storage, prepend base URL
        if (str_starts_with($imageUrl, '/storage')) {
            return url($imageUrl);
        }

        // Otherwise, assume it's a relative path
        return url('/storage/' . $imageUrl);
    }
}
