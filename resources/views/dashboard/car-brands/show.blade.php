@extends('layouts.dashboard')

@section('title', 'Detalles de Marca')

@section('header', 'Detalles de Marca: {{ $carBrand->name }}')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-sm text-gray-500">Información detallada de la marca y sus modelos asociados.</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('car-brands.edit', $carBrand) }}" class="flex items-center px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors duration-200">
            <span class="material-icons mr-1">edit</span>
            <span>Editar</span>
        </a>
        <a href="{{ route('car-brands.index') }}" class="flex items-center px-4 py-2 border rounded-lg transition-colors duration-200" :class="darkMode ? 'border-ios-darkmode-border text-ios-darkmode-text hover:bg-ios-darkmode-border' : 'border-gray-300 text-gray-700 hover:bg-gray-100'">
            <span class="material-icons mr-1">arrow_back</span>
            <span>Volver</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Brand Information Card -->
    <div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">Información de la Marca</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Nombre</p>
                    <p class="text-lg" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">{{ $carBrand->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Cantidad de Modelos</p>
                    <p class="text-lg" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">{{ $carBrand->carModels->count() }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Fecha de Creación</p>
                    <p class="text-lg" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">{{ $carBrand->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Última Actualización</p>
                    <p class="text-lg" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">{{ $carBrand->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Car Models List Card -->
    <div class="rounded-xl overflow-hidden lg:col-span-2" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">Modelos Asociados</h2>
                <a href="{{ route('car-models.create') }}" class="flex items-center px-3 py-1 text-sm bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    <span class="material-icons text-sm mr-1">add</span>
                    <span>Nuevo Modelo</span>
                </a>
            </div>
            
            @if($carBrand->carModels->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
                        <thead :class="darkMode ? 'bg-ios-darkmode-card' : 'bg-gray-50'">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                                    Modelo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                                    Año
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
                            @foreach($carBrand->carModels as $model)
                            <tr :class="darkMode ? 'bg-ios-darkmode-card hover:bg-ios-darkmode-border' : 'bg-white hover:bg-gray-50'">
                                <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">
                                    {{ $model->model }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">
                                    {{ $model->year }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('car-models.show', $model) }}" class="text-ios-blue hover:text-blue-600 transition-colors duration-200">
                                            <span class="material-icons">visibility</span>
                                        </a>
                                        <a href="{{ route('car-models.edit', $model) }}" class="text-amber-500 hover:text-amber-600 transition-colors duration-200">
                                            <span class="material-icons">edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    <p>No hay modelos asociados a esta marca.</p>
                    <p class="mt-2 text-sm">Puedes agregar un nuevo modelo haciendo clic en el botón "Nuevo Modelo".</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
