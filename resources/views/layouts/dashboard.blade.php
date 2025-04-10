<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sistema de Inventario</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ios-blue': '#007AFF',
                        'ios-gray': '#F2F2F7',
                        'ios-dark': '#1C1C1E',
                        'ios-light': '#FFFFFF',
                        'ios-green': '#34C759',
                        'ios-red': '#FF3B30',
                        'ios-darkmode-bg': '#000000',
                        'ios-darkmode-card': '#1C1C1E',
                        'ios-darkmode-border': '#38383A',
                        'ios-darkmode-text': '#FFFFFF'
                    },
                    fontFamily: {
                        'ios': ['-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', 'sans-serif']
                    },
                    boxShadow: {
                        'ios': '0 2px 10px rgba(0, 0, 0, 0.05)',
                        'ios-dark': '0 2px 10px rgba(0, 0, 0, 0.2)'
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('styles')
</head>
<body x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="darkMode ? 'dark bg-ios-darkmode-bg text-ios-darkmode-text' : 'bg-ios-gray text-ios-dark'" class="min-h-screen font-ios transition-colors duration-200" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <div x-data="{sidebarOpen: false}" class="flex h-screen" :class="darkMode ? 'bg-ios-darkmode-bg' : 'bg-ios-gray'">
        <!-- iOS-style Sidebar -->
        <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 border-r" :class="darkMode ? 'bg-ios-darkmode-card border-ios-darkmode-border shadow-ios-dark' : 'bg-ios-light border-gray-200 shadow-ios'">
            <div class="flex items-center justify-center h-16 border-b" :class="darkMode ? 'bg-ios-darkmode-card border-ios-darkmode-border' : 'bg-ios-light border-gray-200'">
                <div class="flex items-center">
                    <span class="mx-2 text-xl font-medium" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">Inventario</span>
                </div>
            </div>

            <nav class="mt-5 space-y-1">
                <a class="flex items-center px-6 py-3 rounded-lg mx-2 transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text hover:bg-ios-darkmode-border hover:text-ios-blue' : 'text-ios-dark hover:bg-ios-gray hover:text-ios-blue'" href="{{ route('dashboard.parts') }}">
                    <span class="material-icons mr-3 text-ios-blue">list</span>
                    <span>Autopartes</span>
                </a>

                @if(auth()->user()->isEncargado())
                <a class="flex items-center px-6 py-3 rounded-lg mx-2 transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text hover:bg-ios-darkmode-border hover:text-ios-blue' : 'text-ios-dark hover:bg-ios-gray hover:text-ios-blue'" href="{{ route('dashboard.parts.new') }}">
                    <span class="material-icons mr-3 text-ios-blue">add_circle</span>
                    <span>Nueva Autoparte</span>
                </a>

                <a class="flex items-center px-6 py-3 rounded-lg mx-2 transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text hover:bg-ios-darkmode-border hover:text-ios-blue' : 'text-ios-dark hover:bg-ios-gray hover:text-ios-blue'" href="{{ route('car-models.index') }}">
                    <span class="material-icons mr-3 text-ios-blue">directions_car</span>
                    <span>Modelos de Autos</span>
                </a>

                <a class="flex items-center px-6 py-3 rounded-lg mx-2 transition-colors duration-200" :class="darkMode ? 'text-ios-darkmode-text hover:bg-ios-darkmode-border hover:text-ios-blue' : 'text-ios-dark hover:bg-ios-gray hover:text-ios-blue'" href="{{ route('car-brands.index') }}">
                    <span class="material-icons mr-3 text-ios-blue">branding_watermark</span>
                    <span>Marcas de Autos</span>
                </a>
                @endif
            </nav>

            <div class="absolute bottom-0 w-full border-t" :class="darkMode ? 'border-ios-darkmode-border bg-ios-darkmode-card' : 'border-gray-200 bg-ios-light'">
                <form method="POST" action="{{ route('auth.sign-out') }}" class="px-6 py-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-ios-red hover:bg-ios-gray rounded-lg transition-colors duration-200">
                        <span class="material-icons mr-3">logout</span>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-ios-light shadow-ios'">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-ios-blue focus:outline-none lg:hidden">
                        <span class="material-icons">menu</span>
                    </button>

                    <div class="mx-4 text-lg font-semibold" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                        @yield('header', 'Dashboard')
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="flex items-center justify-center p-2 rounded-full transition-colors duration-200" :class="darkMode ? 'bg-ios-darkmode-border text-ios-darkmode-text' : 'bg-ios-gray text-ios-dark'">
                        <span class="material-icons" x-show="!darkMode">dark_mode</span>
                        <span class="material-icons" x-show="darkMode">light_mode</span>
                    </button>
                    
                    <div class="relative">
                        <div class="flex items-center" :class="darkMode ? 'text-ios-darkmode-text' : 'text-ios-dark'">
                            <span class="mr-2 font-medium">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>
                            <span class="px-3 py-1 text-xs text-white rounded-full" style="background-color: {{ auth()->user()->isEncargado() ? '#34C759' : '#007AFF' }}">
                                {{ auth()->user()->isEncargado() ? 'Encargado' : 'Vendedor' }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto transition-colors duration-200" :class="darkMode ? 'bg-ios-darkmode-bg' : 'bg-ios-gray'">
                <div class="container px-6 py-8 mx-auto">
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm border-l-4 border-ios-green rounded-lg" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'" role="alert">
                            <div class="flex items-center">
                                <span class="material-icons mr-2 text-ios-green">check_circle</span>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm border-l-4 border-ios-red rounded-lg" :class="darkMode ? 'bg-ios-darkmode-card shadow-ios-dark' : 'bg-white shadow-ios'" role="alert">
                            <div class="flex items-center">
                                <span class="material-icons mr-2 text-ios-red">error</span>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
