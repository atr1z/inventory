@extends('layouts.dashboard')

@section('title', 'Nuevo Modelo de Auto')

@section('header', 'Nuevo Modelo de Auto')

@section('content')
<div class="mb-6">
    <a href="{{ route('car-models.index') }}" class="flex items-center text-ios-blue hover:underline">
        <span class="material-icons mr-1">arrow_back</span>
        <span>Volver a Modelos</span>
    </a>
</div>

<div class="rounded-xl overflow-hidden" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'">
    <div class="p-6">
        <form action="{{ route('car-models.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label for="car_brand_id" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                    Marca
                </label>
                <select 
                       class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-ios-blue transition-all duration-200 @error('car_brand_id') border-ios-red ring-1 ring-ios-red @enderror" 
                       :class="darkMode ? 'bg-ios-darkmode-border border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'" 
                       id="car_brand_id" name="car_brand_id" required>
                    <option value="" disabled selected>Seleccione una marca</option>
                    @foreach($carBrands as $brand)
                        <option value="{{ $brand->id }}" {{ old('car_brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('car_brand_id')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
                <div class="mt-2 flex justify-end">
                    <a href="{{ route('car-brands.create') }}" class="text-xs text-ios-blue hover:underline flex items-center">
                        <span class="material-icons text-xs mr-1">add</span>
                        <span>Agregar nueva marca</span>
                    </a>
                </div>
            </div>
            
            <div class="mb-6">
                <label for="model" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                    Modelo
                </label>
                <input type="text" 
                       class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-ios-blue transition-all duration-200 @error('model') border-ios-red ring-1 ring-ios-red @enderror" 
                       :class="darkMode ? 'bg-ios-darkmode-border border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'" 
                       id="model" name="model" value="{{ old('model') }}" required>
                @error('model')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="year" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                    Año
                </label>
                <input type="number" 
                       class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-ios-blue transition-all duration-200 @error('year') border-ios-red ring-1 ring-ios-red @enderror" 
                       :class="darkMode ? 'bg-ios-darkmode-border border-ios-darkmode-border text-ios-darkmode-text' : 'bg-white border-gray-300 text-ios-dark'" 
                       id="year" name="year" value="{{ old('year') }}" 
                       min="1900" max="{{ date('Y') + 1 }}" required>
                @error('year')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-8">
                <label for="image" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                    Imagen (opcional)
                </label>
                <div class="flex items-center justify-center w-full">
                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200" 
                           :class="darkMode ? 'border-ios-darkmode-border hover:bg-ios-darkmode-border' : 'border-gray-300 hover:bg-gray-50'">
                        <div id="image-preview" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <span class="material-icons text-3xl mb-2" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                add_photo_alternate
                            </span>
                            <p class="mb-2 text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                <span>Haga clic para seleccionar una imagen</span>
                            </p>
                            <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                JPG, PNG o GIF (máx. 2MB)
                            </p>
                        </div>
                        <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                    </label>
                </div>
                <div id="file-name-display" class="mt-2 text-center text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></div>
                @error('image')
                    <p class="mt-1 text-xs text-ios-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-ios-blue text-white rounded-lg transition-colors duration-200 hover:bg-opacity-90">
                    <span class="material-icons mr-2">save</span>
                    <span>Guardar Modelo</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview selected image and display file name with size validation
    document.getElementById('image').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('image-preview');
        const fileNameDisplay = document.getElementById('file-name-display');
        const fileInput = document.getElementById('image');
        
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const fileSize = file.size / 1024 / 1024; // Convert to MB
            
            // Check if file size exceeds 2MB
            if (fileSize > 2) {
                // Create alert element
                const alertElement = document.createElement('div');
                alertElement.className = 'fixed top-4 right-4 bg-ios-red text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center';
                alertElement.innerHTML = `
                    <span class="material-icons mr-2">error</span>
                    <div>
                        <p class="font-medium">Error de tamaño de archivo</p>
                        <p class="text-sm">El archivo excede el tamaño máximo de 2MB.</p>
                    </div>
                    <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.remove()">
                        <span class="material-icons">close</span>
                    </button>
                `;
                
                document.body.appendChild(alertElement);
                
                // Remove alert after 5 seconds
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.remove();
                    }
                }, 5000);
                
                // Reset file input
                fileInput.value = '';
                fileNameDisplay.textContent = '';
                return;
            }
            
            // Display file name
            fileNameDisplay.textContent = file.name;
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Replace the entire content with the image preview
                previewContainer.innerHTML = `<div class="flex flex-col items-center justify-center w-full h-32">
                    <img src="${e.target.result}" class="h-full object-contain" />
                </div>`;
            }
            
            reader.readAsDataURL(file);
        } else {
            // Reset to default view if no file selected
            fileNameDisplay.textContent = '';
            previewContainer.innerHTML = `<div class="flex flex-col items-center justify-center pt-5 pb-6">
                <span class="material-icons text-3xl mb-2" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    add_photo_alternate
                </span>
                <p class="mb-2 text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    <span>Haga clic para seleccionar una imagen</span>
                </p>
                <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    JPG, PNG o GIF (máx. 2MB)
                </p>
            </div>`;
        }
    });
</script>
@endsection
