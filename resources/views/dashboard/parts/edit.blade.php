@extends('layouts.dashboard')

@section('title', 'Editar Autoparte')

@section('header', 'Editar Autoparte')

@section('content')
<div class="mb-6">
    <a href="{{ route('dashboard.parts') }}" class="flex items-center text-ios-blue hover:underline">
        <span class="material-icons mr-1">arrow_back</span>
        <span>Volver a Autopartes</span>
    </a>
</div>

<div class="p-6 rounded-lg" x-data="{ previewImage: null, calculateSalePrice() { const purchasePrice = parseFloat(document.getElementById('purchase_price').value) || 0; document.getElementById('sale_price').value = (purchasePrice * 1.1).toFixed(2); } }" x-init="calculateSalePrice()" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <form action="{{ route('dashboard.parts.update', $autoPart) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $autoPart->name) }}" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'"
                    placeholder="Nombre de la autoparte">
                @error('name')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Brand -->
            <div>
                <label for="brand" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Marca</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand', $autoPart->brand) }}" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'"
                    placeholder="Marca de la autoparte">
                @error('brand')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Cantidad</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $autoPart->quantity) }}" min="0" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'"
                    placeholder="Cantidad disponible">
                @error('quantity')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Purchase Price -->
            <div>
                <label for="purchase_price" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Precio de Compra</label>
                <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $autoPart->purchase_price) }}" min="0" step="0.01" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'"
                    placeholder="Precio de compra" @input="calculateSalePrice()">
                @error('purchase_price')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Sale Price (calculated automatically) -->
            <div>
                <label for="sale_price" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Precio de Venta (10% markup)</label>
                <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $autoPart->sale_price) }}" min="0" step="0.01" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'"
                    placeholder="Precio de venta" readonly>
                @error('sale_price')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Car Brand -->
            <div>
                <label for="car_brand_id" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Marca de Auto</label>
                <select name="car_brand_id" id="car_brand_id" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'">
                    <option value="">Seleccionar marca</option>
                    @foreach($carBrands as $brand)
                        <option value="{{ $brand->id }}" {{ old('car_brand_id', $autoPart->car_brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('car_brand_id')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Car Model -->
            <div>
                <label for="car_model_id" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Modelo de Auto</label>
                <select name="car_model_id" id="car_model_id" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'">
                    <option value="">Seleccionar modelo</option>
                    @foreach($carModels as $model)
                        <option value="{{ $model->id }}" {{ old('car_model_id', $autoPart->car_model_id) == $model->id ? 'selected' : '' }}>
                            {{ $model->carBrand->name }} {{ $model->model }} ({{ $model->year }})
                        </option>
                    @endforeach
                </select>
                @error('car_model_id')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Provider (Optional) -->
            <div>
                <label for="provider" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Proveedor (Opcional)</label>
                <input type="text" name="provider" id="provider" value="{{ old('provider', $autoPart->provider) }}"
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-ios-blue focus:border-transparent transition-colors duration-200"
                    :class="darkMode ? 'bg-ios-darkmode-bg border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'"
                    placeholder="Nombre del proveedor">
                @error('provider')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Imagen (Opcional)</label>
                <div class="flex items-center space-x-4">
                    @if($autoPart->image)
                        <div class="w-20 h-20 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $autoPart->image) }}" alt="{{ $autoPart->name }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200"
                        :class="darkMode ? 'border-ios-darkmode-border hover:bg-ios-darkmode-border' : 'border-gray-300 hover:bg-gray-50'">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="!previewImage">
                            <span class="material-icons text-3xl mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">cloud_upload</span>
                            <p class="mb-2 text-sm" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Haz clic para subir</p>
                            <p class="text-xs" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">PNG, JPG o JPEG (máx. 2MB)</p>
                        </div>
                        <div class="h-full w-full flex items-center justify-center" x-show="previewImage">
                            <img :src="previewImage" class="h-full object-contain" />
                        </div>
                        <input id="image" name="image" type="file" class="hidden" accept="image/*"
                            @change="previewImage = URL.createObjectURL($event.target.files[0])" />
                    </label>
                </div>
                @error('image')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Purchase Invoice Upload -->
            <div>
                <label for="purchase_invoice" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Factura de Compra (Opcional)</label>
                @if($autoPart->purchase_invoice)
                    <div class="flex items-center mb-2">
                        <span class="material-icons text-ios-blue mr-2">description</span>
                        <a href="{{ asset('storage/' . $autoPart->purchase_invoice) }}" target="_blank" class="text-ios-blue hover:underline">Ver factura actual</a>
                    </div>
                @endif
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200"
                    :class="darkMode ? 'border-ios-darkmode-border hover:bg-ios-darkmode-border' : 'border-gray-300 hover:bg-gray-50'">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <span class="material-icons text-3xl mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">description</span>
                        <p class="mb-2 text-sm" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">Haz clic para subir</p>
                        <p class="text-xs" :class="darkMode ? 'text-ios-darkmode-text' : 'text-gray-500'">PDF (máx. 2MB)</p>
                    </div>
                    <input id="purchase_invoice" name="purchase_invoice" type="file" class="hidden" accept=".pdf" />
                </label>
                @error('purchase_invoice')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mt-8">
            <a href="{{ route('dashboard.parts') }}" class="px-6 py-2 rounded-lg border transition-colors duration-200"
                :class="darkMode ? 'border-ios-darkmode-border text-ios-darkmode-text hover:bg-ios-darkmode-border' : 'border-gray-300 text-ios-dark hover:bg-gray-100'">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                Actualizar
            </button>
        </div>
    </form>
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
                            Eliminar Autoparte
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                ¿Está seguro que desea eliminar la autoparte "{{ $autoPart->name }}"? Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form action="{{ route('dashboard.parts.destroy', $autoPart) }}" method="POST">
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
    // Function to open the delete confirmation modal
    function openDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
    }
    
    // Function to close the delete confirmation modal
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
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
