<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = Auth::user()->events()->get();
        $eventsJson = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date->toIso8601String(),
                'backgroundColor' => $event->color,
                'borderColor' => $event->color,
                'extendedProps' => [
                    'description' => $event->description,
                    'is_completed' => $event->is_completed,
                ]
            ];
        });

        return view('events.index', ['events' => $eventsJson]);
    }

    public function create(Request $request)
    {
        // Ambil parameter date dari URL jika ada (ketika user klik tanggal di calendar)
        $date = $request->query('date');
        
        return view('events.create', compact('date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date_format:Y-m-d\TH:i',
            'end_date' => 'required|date_format:Y-m-d\TH:i|after:start_date',
            'color' => 'required|string',
        ]);

        Auth::user()->events()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'color' => $validated['color'],
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);
        return view('events.show', ['event' => $event]);
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date_format:Y-m-d\TH:i',
            'end_date' => 'required|date_format:Y-m-d\TH:i|after:start_date',
            'color' => 'required|string',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }

    public function toggleComplete(Event $event)
    {
        $this->authorize('update', $event);
        $event->update(['is_completed' => !$event->is_completed]);

        return redirect()->route('events.index')->with('success', 'Status event diupdate!');
    }
}