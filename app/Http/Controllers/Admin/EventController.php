<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->orderByDesc('starts_at')
            ->paginate(20);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event()]);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        Event::create($data);

        return redirect()->route('admin.events.index')->with('status', 'Event created.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();

        $event->update($data);

        return redirect()->route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event deleted.');
    }
}
