@extends('layouts.dashboard')

@section('title', 'Detalles del Modelo')

@section('header', 'Detalles del Modelo')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('car-models.index') }}" class="flex items-center text-ios-blue hover:underline">
        <span class="material-icons mr-1">arrow_back</span>
        <span>Volver a Modelos</span>
    </a>
    <a href="{{ route('car-models.edit', $carModel) }}" class="flex items-center px-4 py-2 bg-amber-500 text-white rounded-lg transition-colors duration-200 hover:bg-opacity-90">
        <span class="material-icons mr-2">edit</span>
        <span>Editar</span>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Imagen y detalles básicos -->
    <div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
        <div class="p-6">
            <div class="flex flex-col items-center">
                @if($carModel->image)
                    <img src="{{ asset('storage/' . $carModel->image) }}" 
                         alt="{{ $carModel->brand }} {{ $carModel->model }}" 
                         class="w-full h-48 object-contain rounded-lg mb-4">
                @else
                    <div class="w-full h-48 flex items-center justify-center rounded-lg mb-4" :class="darkMode ? 'bg-ios-darkmode-border' : 'bg-ios-gray'">
                        <span class="material-icons text-5xl" :class="darkMode ? 'text-gray-600' : 'text-gray-400'">directions_car</span>
                    </div>
                @endif
                
                <h2 class="text-xl font-semibold mt-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                    {{ $carModel->brand }} {{ $carModel->model }}
                </h2>
                <span class="px-3 py-1 text-sm rounded-full bg-ios-blue text-white mt-2">
                    {{ $carModel->year }}
                </span>
            </div>
        </div>
    </div>
    
    <!-- Información detallada -->
    <div class="md:col-span-2 rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
        <div class="p-6">
            <h3 class="text-lg font-medium mb-4" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                Información del Modelo
            </h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-4 items-center py-2 border-b" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
                    <div class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Marca</div>
                    <div class="col-span-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $carModel->brand }}</div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 items-center py-2 border-b" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
                    <div class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Modelo</div>
                    <div class="col-span-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $carModel->model }}</div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 items-center py-2 border-b" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
                    <div class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Año</div>
                    <div class="col-span-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $carModel->year }}</div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 items-center py-2 border-b" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
                    <div class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Fecha de creación</div>
                    <div class="col-span-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $carModel->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 items-center py-2">
                    <div class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Última actualización</div>
                    <div class="col-span-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $carModel->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Autopartes relacionadas -->
    <div class="md:col-span-3 rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
        <div class="p-6">
            <h3 class="text-lg font-medium mb-4" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                Autopartes relacionadas
            </h3>
            
            @if($carModel->autoParts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Marca</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Precio de Venta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
                            @foreach($carModel->autoParts as $part)
                                <tr class="hover:bg-opacity-50 transition-colors duration-150" :class="darkMode ? 'hover:bg-ios-darkmode-border' : 'hover:bg-ios-gray'">
                                    <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                                        {{ $part->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                                        {{ $part->brand }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($part->quantity > 0)
                                            <span class="px-2 py-1 text-xs rounded-full bg-ios-green text-white">
                                                {{ $part->quantity }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-ios-red text-white">
                                                Agotado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                                        ${{ number_format($part->sale_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('dashboard.parts.edit', $part) }}" 
                                           class="flex items-center px-3 py-1 bg-ios-blue text-white rounded-lg transition-colors duration-200 hover:bg-opacity-90 w-fit">
                                            <span class="material-icons text-sm mr-1">visibility</span>
                                            <span>Ver</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-lg p-4" :class="darkMode ? 'bg-ios-darkmode-border' : 'bg-ios-gray'">
                    <div class="flex items-center">
                        <span class="material-icons mr-2 text-ios-blue">info</span>
                        <p :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                            No hay autopartes asociadas a este modelo de auto.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
