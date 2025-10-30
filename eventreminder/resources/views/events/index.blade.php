@extends('layouts.app')

@section('title', 'Calendar')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Kalender Event</h2>
    <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">+ Tambah Event</a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div id="calendar"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: {!! $events !!},
            eventClick: function(info) {
                window.location.href = '/events/' + info.event.id;
            },
            dateClick: function(info) {
                window.location.href = '/events/create?date=' + info.dateStr;
            }
        });
        calendar.render();
    });
</script>
@endsection