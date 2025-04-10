@extends('layouts.dashboard')

@section('title', 'Nueva Autoparte')

@section('header', 'Nueva Autoparte')

@section('content')
<div class="p-6 rounded-lg" x-data="{ previewImage: null, calculateSalePrice() { const purchasePrice = parseFloat(document.getElementById('purchase_price').value) || 0; document.getElementById('sale_price').value = (purchasePrice * 1.1).toFixed(2); } }" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <form action="{{ route('dashboard.parts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                <input type="text" name="brand" id="brand" value="{{ old('brand') }}" required
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
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" min="0" required
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
                <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" min="0" step="0.01" required
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
                <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" min="0" step="0.01" required
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
                        <option value="{{ $brand->id }}" {{ old('car_brand_id') == $brand->id ? 'selected' : '' }}>
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
                        <option value="{{ $model->id }}" {{ old('car_model_id') == $model->id ? 'selected' : '' }}>
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
                <input type="text" name="provider" id="provider" value="{{ old('provider') }}"
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
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
