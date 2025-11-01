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

        //  Filtra per categoria (solo se non vuota)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filtra per stato (accetta lista separata da virgole)
        if ($request->filled('status')) {
            $statuses = collect(explode(',', $request->input('status')))
                ->map(fn($s) => trim($s))
                ->filter()
                ->all();

            if (!empty($statuses)) {
                $query->whereIn('status', $statuses);
            }
        }

        //  Filtra per evento volontario (true/false)
        if ($request->filled('is_volunteer_event')) {
            $isVolunteer = filter_var($request->input('is_volunteer_event'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_volunteer_event', $isVolunteer);
        }

        // Ordina per data di inizio (desc)
        $events = $query->orderByDesc('starts_at')->paginate(10);

        return view('admin.events.index', compact('events'));
    }


    public function create()
    {
        $categories = EventCategory::whereNotNull('parent_id')->get();
        return view('admin.events.create', compact('categories'));
    }
    public function store(StoreEventRequest $request)
    {

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('events', $imageName, 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Remove image from validated data since we're using image_url
        unset($validated['image']);
        $subcategory = EventCategory::findOrFail($validated['category_id']);
        $validated['category_id'] = $subcategory->id;

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'upcoming';

        if (!empty($validated['image_url'])) {
            $validated['image_url'] = $this->getFullImageUrl($validated['image_url']);
        }


        $newEvent = new Event($validated);
        // Transform image URL to full URL
        $newEvent->load(['category', 'creator']);
        $newEvent->save();
        return redirect()->route('admin.events.show', $newEvent->id)
            ->with('success', 'Evento creato con successo!');
    }

    public function show(Event $event)
    {
        $event->load([
            'category',
            'category.parent',
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
        $categories = EventCategory::whereNotNull('parent_id')->get();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function destroy(Event $event)
    {
        if ($event->image_url) {
            $imagePath = str_replace('/storage/', '', $event->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $event->delete();

        return redirect()->route('admin.events.index');
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
        return redirect()->route('admin.events.show', $event->id);

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
