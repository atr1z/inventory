@extends('layouts.dashboard')

@section('title', 'Editar Marca de Auto')

@section('header', 'Editar Marca: {{ $carBrand->name }}')

@section('content')
<div class="mb-6">
    <p class="text-sm text-gray-500">Modifica la información de la marca de auto.</p>
</div>

<div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <div class="p-6">
        <form action="{{ route('car-brands.update', $carBrand) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-700'">Nombre de la Marca</label>
                <input type="text" id="name" name="name" value="{{ old('name', $carBrand->name) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent" :class="darkMode ? 'bg-ios-darkmode-border border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-gray-900'" required>
                @error('name')
                <p class="mt-1 text-sm text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between">
                <div>
                    <a href="{{ route('car-brands.show', $carBrand) }}" class="px-4 py-2 text-sm font-medium rounded-lg border" :class="darkMode ? 'border-ios-darkmode-border text-ios-darkmode-text hover:bg-ios-darkmode-border' : 'border-gray-300 text-gray-700 hover:bg-gray-100'">Cancelar</a>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-ios-blue rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ios-blue">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mt-8 rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-900'">Eliminar Marca</h2>
        <p class="mb-4 text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Esta acción no se puede deshacer. Se eliminarán todos los datos asociados a esta marca.</p>
        
        <button type="button" onclick="openDeleteModal('{{ $carBrand->id }}', '{{ $carBrand->name }}', {{ $carBrand->carModels()->count() }})" class="px-4 py-2 text-sm font-medium text-white bg-ios-red rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ios-red">
            <span class="flex items-center">
                <span class="material-icons mr-1">delete</span>
                <span>Eliminar Marca</span>
            </span>
        </button>
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
        form.action = `{{ route('car-brands.destroy', $carBrand) }}`;
        
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
