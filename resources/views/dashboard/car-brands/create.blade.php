@extends('layouts.dashboard')

@section('title', 'Nueva Marca de Auto')

@section('header', 'Nueva Marca de Auto')

@section('content')
<div class="mb-6">
    <p class="text-sm text-gray-500">Completa el formulario para crear una nueva marca de auto.</p>
</div>

<div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <div class="p-6">
        <form action="{{ route('car-brands.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-700'">Nombre de la Marca</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent" :class="darkMode ? 'bg-ios-darkmode-border border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-gray-900'" required>
                @error('name')
                <p class="mt-1 text-sm text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('car-brands.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg border" :class="darkMode ? 'border-ios-darkmode-border text-ios-darkmode-text hover:bg-ios-darkmode-border' : 'border-gray-300 text-gray-700 hover:bg-gray-100'">Cancelar</a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-ios-blue rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ios-blue">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
