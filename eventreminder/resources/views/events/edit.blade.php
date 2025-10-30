@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Edit Event</h2>

    <form method="POST" action="{{ route('events.update', $event) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Judul Event</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('description', $event->description) }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Tanggal & Waktu Mulai</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Tanggal & Waktu Selesai</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Warna</label>
            <div class="flex gap-2">
                @foreach(['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899'] as $color)
                    <label class="flex items-center">
                        <input type="radio" name="color" value="{{ $color }}" {{ old('color', $event->color) == $color ? 'checked' : '' }} class="mr-2">
                        <span class="w-8 h-8 rounded" style="background-color: {{ $color }}"></span>
                    </label>
                @endforeach
            </div>
            @error('color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update Event</button>
            <a href="{{ route('events.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">Batal</a>
        </div>
    </form>
</div>
@endsection