@extends('layouts.dashboard')

@section('title', 'Lista de Autopartes')

@section('header', 'Lista de Autopartes')

@section('content')
    <div class="rounded-2xl overflow-hidden transition-colors duration-200" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
        <div class="p-5 flex justify-between items-center border-b transition-colors duration-200" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
            <h2 class="text-xl font-semibold transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Autopartes</h2>
            @if(auth()->user()->isEncargado())
            <a href="{{ route('dashboard.parts.new') }}" class="px-4 py-2 bg-ios-blue text-white rounded-full hover:bg-opacity-90 transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nueva Autoparte
            </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            @if(isset($autoParts) && count($autoParts) > 0)
                <table class="min-w-full divide-y transition-colors duration-200" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
                    <thead :class="darkMode ? 'bg-ios-darkmode-card' : 'bg-gray-50'" class="transition-colors duration-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Imagen</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Marca</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Modelo de Auto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Cantidad</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Precio de Venta</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Factura</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Acciones</th>
                        </tr>
                    </thead>
                    <tbody :class="darkMode ? 'bg-ios-darkmode-card divide-y divide-ios-darkmode-border' : 'bg-white divide-y divide-gray-200'" class="transition-colors duration-200">
                        @foreach($autoParts as $part)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($part->image)
                                            <img class="h-12 w-12 rounded-xl object-cover shadow-ios" src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-xl flex items-center justify-center transition-colors duration-200" :class="darkMode ? 'bg-ios-darkmode-border' : 'bg-ios-gray'">
                                                <svg class="h-6 w-6 transition-colors duration-200" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $part->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $part->brand }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ $part->carModel->brand }} {{ $part->carModel->model }} ({{ $part->carModel->year }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="{{ route('dashboard.parts.update-quantity', $part->id) }}" class="flex items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $part->quantity }}" min="0" class="w-16 px-2 py-1 border rounded-lg text-sm transition-colors duration-200" :class="darkMode ? 'bg-ios-darkmode-border border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'">
                                        <button type="submit" class="ml-2 text-ios-blue hover:text-opacity-80 transition-colors duration-200" title="Actualizar cantidad">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">{{ number_format($part->sale_price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($part->in_stock)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-ios-green bg-opacity-20 text-ios-green">
                                            En existencia
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-ios-red bg-opacity-20 text-ios-red">
                                            Agotado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($part->purchase_invoice)
                                        <a href="{{ asset('storage/' . $part->purchase_invoice) }}" target="_blank" class="p-2 rounded-full text-ios-blue hover:bg-ios-blue hover:bg-opacity-10 transition-colors duration-200" title="Ver factura de compra">
                                            <span class="material-icons">description</span>
                                        </a>
                                    @else
                                        <span class="p-2 text-gray-400" title="Sin factura">
                                            <span class="material-icons">description_off</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        @if(auth()->user()->isEncargado())
                                            <a href="{{ route('dashboard.parts.edit', $part->id) }}" class="p-2 rounded-full text-amber-500 hover:bg-amber-500 hover:bg-opacity-10 transition-colors duration-200" title="Editar">
                                                <span class="material-icons">edit</span>
                                            </a>
                                            <button type="button" onclick="openDeleteModal('{{ $part->id }}', '{{ $part->name }}')" class="p-2 rounded-full text-ios-red hover:bg-ios-red hover:bg-opacity-10 transition-colors duration-200" title="Eliminar">
                                                <span class="material-icons">delete</span>
                                            </button>
                                            <form id="delete-form-{{ $part->id }}" action="{{ route('dashboard.parts.destroy', $part->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 transition-colors duration-200" :class="darkMode ? 'text-gray-600' : 'text-gray-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-4 text-base font-medium transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">No hay autopartes</h3>
                    <p class="mt-2 text-sm transition-colors duration-200" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Comienza agregando una nueva autoparte al inventario.</p>
                    @if(auth()->user()->isEncargado())
                        <div class="mt-6">
                            <a href="{{ route('dashboard.parts.new') }}" class="inline-flex items-center px-5 py-2 text-sm font-medium rounded-full text-white bg-ios-blue hover:bg-opacity-90 transition-colors duration-200">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Nueva Autoparte
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             :class="darkMode ? 'bg-ios-darkmode-card' : 'bg-white'">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-ios-red bg-opacity-10 sm:mx-0 sm:h-10 sm:w-10">
                        <span class="material-icons text-ios-red">warning</span>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium" id="modal-title" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                            Eliminar Autoparte
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm" id="delete-message" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                <!-- Dynamic content will be inserted here -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="modal-delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-ios-red text-base font-medium text-white hover:bg-ios-red focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ios-red sm:ml-3 sm:w-auto sm:text-sm">
                        Eliminar
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md shadow-sm px-4 py-2 text-base font-medium sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        :class="darkMode ? 'border border-ios-darkmode-border bg-ios-darkmode-border text-ios-darkmode-text hover:bg-opacity-80' : 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50'">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Store the current part ID being deleted
    let currentPartId = null;
    
    // Function to open the delete confirmation modal
    function openDeleteModal(id, name) {
        currentPartId = id;
        
        // Set the delete form action URL
        const form = document.getElementById('modal-delete-form');
        form.action = `{{ url('dashboard/parts') }}/${id}`;
        
        // Set the confirmation message
        const messageElement = document.getElementById('delete-message');
        messageElement.textContent = `¿Está seguro que desea eliminar la autoparte ${name}?`;
        
        // Show the modal
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
    }
    
    // Function to close the delete confirmation modal
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        currentPartId = null;
    }
    
    // Close modal when clicking outside or pressing escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection
