<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Models\EventCategory;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    public function index(Request $request)
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
            $query->where('is_volunteer_event', $isVolunteer);
        }

        $events = $query->orderBy('starts_at', 'desc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.events.create', compact('categories'));
    }
    public function store(StoreEventRequest $request)
    {
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('events', $imageName, 'public');
            $request['image_url'] = '/storage/' . $imagePath;
        }

        // Remove image from validated data since we're using image_url
        unset($request['image']);

        $request['created_by'] = Auth::id();
        $request['status'] = 'upcoming';
        if ($request->image_url) {
            $request->image_url = $this->getFullImageUrl($request->image_url);
        }

        $newEvent = new Event();
        // Transform image URL to full URL
        $newEvent->fill($request->all());
        $newEvent->load(['category', 'creator']);
        $newEvent->save();
        return redirect()->route('events.show', $newEvent->id);
    }

    public function show(Event $event)
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
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact("event"));
    }

    public function destroy(Event $event)
    {
        if ($event->image_url) {
            $imagePath = str_replace('/storage/', '', $event->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $event->delete();

        return redirect()->route('events.index');
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image_url) {
                $oldImagePath = str_replace('/storage/', '', $event->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('events', $imageName, 'public');
            $request['image_url'] = '/storage/' . $imagePath;
        }

        // Remove image from validated data since we're using image_url
        unset($request['image']);

        $event->update($request->all());
        $event->load(['category', 'creator']);

        // Transform image URL to full URL
        if ($event->image_url) {
            $event->image_url = $this->getFullImageUrl($event->image_url);
        }
        return redirect()->route('events.show', $event->id);

    }

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
