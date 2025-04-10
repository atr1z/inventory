@extends('layouts.dashboard')

@section('title', 'Marcas de Autos')

@section('header', 'Marcas de Autos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-sm text-gray-500">Administra las marcas de autos disponibles en el sistema.</p>
    </div>
    <a href="{{ route('car-brands.create') }}" class="flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
        <span class="material-icons mr-1">add</span>
        <span>Nueva Marca</span>
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
    <p>{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
    <p>{{ session('error') }}</p>
</div>
@endif

<div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
            <thead :class="darkMode ? 'bg-ios-darkmode-card' : 'bg-gray-50'">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                        Modelos
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
                @forelse($carBrands as $brand)
                <tr :class="darkMode ? 'bg-ios-darkmode-card hover:bg-ios-darkmode-border' : 'bg-white hover:bg-gray-50'">
                    <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">
                        {{ $brand->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="darkMode ? 'bg-ios-darkmode-border text-ios-darkmode-text' : 'bg-gray-100 text-gray-800'">
                            {{ $brand->car_models_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('car-brands.show', $brand) }}" class="text-ios-blue hover:text-blue-600 transition-colors duration-200">
                                <span class="material-icons">visibility</span>
                            </a>
                            <a href="{{ route('car-brands.edit', $brand) }}" class="text-amber-500 hover:text-amber-600 transition-colors duration-200">
                                <span class="material-icons">edit</span>
                            </a>
                            <button type="button" 
                                    onclick="openDeleteModal('{{ $brand->id }}', '{{ $brand->name }}', {{ $brand->car_models_count }})" 
                                    class="text-ios-red hover:text-red-600 transition-colors duration-200">
                                <span class="material-icons">delete</span>
                            </button>
                            <form id="delete-form-{{ $brand->id }}" 
                                  action="{{ route('car-brands.destroy', $brand) }}" 
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr :class="darkMode ? 'bg-ios-darkmode-card' : 'bg-white'">
                    <td colspan="3" class="px-6 py-4 text-center text-sm" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">
                        No hay marcas de autos registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

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
                            Eliminar Marca de Auto
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm" id="delete-message" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                <!-- Dynamic content will be inserted here -->
                            </p>
                            <p class="text-sm mt-2 hidden" id="delete-warning" :class="darkMode ? 'text-ios-red' : 'text-ios-red'">
                                <!-- Warning message for brands with car models -->
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
    // Store the current brand ID being deleted
    let currentBrandId = null;
    
    // Function to open the delete confirmation modal
    function openDeleteModal(id, name, modelsCount) {
        currentBrandId = id;
        
        // Set the delete form action URL
        const form = document.getElementById('modal-delete-form');
        form.action = `{{ route('car-brands.index') }}/${id}`;
        
        // Set the confirmation message
        const messageElement = document.getElementById('delete-message');
        messageElement.textContent = `¿Está seguro que desea eliminar la marca ${name}?`;
        
        // Show warning if the brand has models associated
        const warningElement = document.getElementById('delete-warning');
        if (modelsCount > 0) {
            warningElement.textContent = `Esta marca tiene ${modelsCount} modelos asociados. No se puede eliminar.`;
            warningElement.classList.remove('hidden');
            
            // Disable the delete button
            const deleteButton = form.querySelector('button[type="submit"]');
            deleteButton.disabled = true;
            deleteButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            warningElement.classList.add('hidden');
            
            // Enable the delete button
            const deleteButton = form.querySelector('button[type="submit"]');
            deleteButton.disabled = false;
            deleteButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        // Show the modal
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
    }
    
    // Function to close the delete confirmation modal
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        currentBrandId = null;
    }
    
    // Close modal when clicking outside or pressing escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection
@endsection
