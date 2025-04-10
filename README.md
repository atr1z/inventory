# Sistema de Control de Inventario de Repuestos Automotrices

## Visión General
Este es un sistema de control de inventario basado en web para repuestos automotrices con control de acceso basado en roles, que permite a los encargados administrar completamente el inventario mientras que los vendedores pueden consultar y actualizar cantidades.

## Características
- Control de acceso por roles (roles de Encargado y Vendedor)
- Gestión completa de repuestos automotrices
- Catálogo de modelos de vehículos
- Sistema de autenticación
- Rutas protegidas según roles de usuario
- Experiencia similar a una SPA (Single Page Application)
- Carga de archivos para facturas e imágenes

## Requisitos
- PHP 8.1 o superior
- Composer
- MySQL 5.7 o superior
- Node.js y npm
- Requisitos de Laravel (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)

## Instalación

1. Clonar el repositorio
   ```bash
   git clone https://github.com/atr1z/inventory.git
   cd inventory
   ```

2. Instalar dependencias de PHP
   ```bash
   composer install
   ```

3. Instalar dependencias de JavaScript
   ```bash
   npm install
   ```

4. Configurar la base de datos en el archivo `.env` en caso de utilizar otra base de datos
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventario
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

5. Ejecutar migraciones y seeders de la base de datos
   ```bash
   php artisan migrate --seed
   ```

6. Crear enlace simbólico para el almacenamiento
   ```bash
   php artisan storage:link
   ```

## Ejecutando la Aplicación

1. Iniciar el servidor de desarrollo de Laravel
   ```bash
   php artisan serve
   ```

2. En una terminal separada, compilar los assets para desarrollo
   ```bash
   npm run dev
   ```

3. Acceder a la aplicación en http://localhost:8000

## Usuarios Predeterminados

Después de ejecutar los seeders, puede iniciar sesión con las siguientes cuentas predeterminadas:

- Encargado:
  - Correo: manager@example.com
  - Contraseña: password

- Vendedor:
  - Correo: seller@example.com
  - Contraseña: password

## Despliegue en Producción

1. Configure su entorno a producción en el archivo `.env`
   ```
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Compile los assets para producción
   ```bash
   npm run build
   ```

## Mantenimiento

- Limpiar configuración: `php artisan config:clear`
- Limpiar caché de rutas: `php artisan route:clear`
- Limpiar caché de vistas: `php artisan view:clear`