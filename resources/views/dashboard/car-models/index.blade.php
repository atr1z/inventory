@extends('layouts.dashboard')

@section('title', 'Modelos de Autos')

@section('header', 'Modelos de Autos')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('car-models.create') }}" class="flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg transition-colors duration-200 hover:bg-opacity-90">
        <span class="material-icons mr-2">add</span>
        <span>Nuevo Modelo</span>
    </a>
</div>

<div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    @if($carModels->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b" :class="darkMode ? 'border-ios-darkmode-border' : 'border-gray-200'">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Marca</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Modelo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Año</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Autopartes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y" :class="darkMode ? 'divide-ios-darkmode-border' : 'divide-gray-200'">
                    @foreach($carModels as $carModel)
                        <tr class="hover:bg-opacity-50 transition-colors duration-150" :class="darkMode ? 'hover:bg-ios-darkmode-border' : 'hover:bg-ios-gray'">
                            <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                                {{ $carModel->carBrand->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                                {{ $carModel->model }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                                {{ $carModel->year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full bg-ios-blue text-white">
                                    {{ $carModel->auto_parts_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($carModel->image)
                                    <img src="{{ asset('storage/' . $carModel->image) }}" 
                                         alt="{{ $carModel->carBrand->name }} {{ $carModel->model }}" 
                                         class="h-10 w-auto rounded-lg object-cover">
                                @else
                                    <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('car-models.show', $carModel) }}" 
                                       class="p-2 rounded-full text-ios-blue hover:bg-ios-blue hover:bg-opacity-10 transition-colors duration-200">
                                        <span class="material-icons">visibility</span>
                                    </a>
                                    <a href="{{ route('car-models.edit', $carModel) }}" 
                                       class="p-2 rounded-full text-amber-500 hover:bg-amber-500 hover:bg-opacity-10 transition-colors duration-200">
                                        <span class="material-icons">edit</span>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ $carModel->id }}', '{{ $carModel->carBrand->name }} {{ $carModel->model }}', {{ $carModel->auto_parts_count }})" 
                                            class="p-2 rounded-full text-ios-red hover:bg-ios-red hover:bg-opacity-10 transition-colors duration-200">
                                        <span class="material-icons">delete</span>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $carModel->id }}" 
                                      action="{{ route('car-models.destroy', $carModel) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-12 px-4">
            <span class="material-icons text-5xl mb-4 text-gray-400">directions_car</span>
            <p class="text-lg mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">No hay modelos de autos registrados</p>
            <a href="{{ route('car-models.create') }}" class="flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg transition-colors duration-200 hover:bg-opacity-90">
                <span class="material-icons mr-2">add</span>
                <span>Agregar Modelo</span>
            </a>
        </div>
    @endif
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
                            Eliminar Modelo de Auto
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm" id="delete-message" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                <!-- Dynamic content will be inserted here -->
                            </p>
                            <p class="text-sm mt-2 hidden" id="delete-warning" :class="darkMode ? 'text-ios-red' : 'text-ios-red'">
                                <!-- Warning message for models with auto parts -->
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
    // Store the current model ID being deleted
    let currentModelId = null;
    
    // Function to open the delete confirmation modal
    function openDeleteModal(id, name, autoPartsCount) {
        currentModelId = id;
        
        // Set the delete form action URL
        const form = document.getElementById('modal-delete-form');
        form.action = `/dashboard/car-models/${id}`;
        
        // Set the confirmation message
        const messageElement = document.getElementById('delete-message');
        messageElement.textContent = `¿Está seguro que desea eliminar el modelo ${name}?`;
        
        // Show warning if the model has auto parts associated
        const warningElement = document.getElementById('delete-warning');
        if (autoPartsCount > 0) {
            warningElement.textContent = `Este modelo tiene ${autoPartsCount} autopartes asociadas. No se puede eliminar.`;
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
        currentModelId = null;
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
