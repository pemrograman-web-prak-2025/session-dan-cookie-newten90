@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-3xl font-bold">{{ $event->title }}</h2>
            <p class="text-gray-600 mt-2">
                <span style="background-color: {{ $event->color }}" class="inline-block w-4 h-4 rounded mr-2"></span>
                {{ $event->start_date->format('d M Y H:i') }} - {{ $event->end_date->format('d M Y H:i') }}
            </p>
        </div>
        <span class="px-4 py-2 rounded-lg {{ $event->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
            {{ $event->is_completed ? 'Selesai' : 'Belum Selesai' }}
        </span>
    </div>

    @if ($event->description)
        <div class="mb-6">
            <h3 class="font-bold text-lg mb-2">Deskripsi</h3>
            <p class="text-gray-700">{{ $event->description }}</p>
        </div>
    @endif

    <div class="flex gap-4">
        <a href="{{ route('events.edit', $event) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Edit</a>
        
        <form method="POST" action="{{ route('events.toggle-complete', $event) }}" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                {{ $event->is_completed ? 'Tandai Belum Selesai' : 'Tandai Selesai' }}
            </button>
        </form>

        <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Hapus</button>
        </form>

        <a href="{{ route('events.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">Kembali</a>
    </div>
</div>
@endsection