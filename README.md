<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Challenge Laravel

Para ejecutar el proyecto es necesario instalar las siguientes dependencias:

- PHP 8.1+
- Mysql 8.0+
- Composer 2.3.5

## Pasos para ejecutar el proyecto
- Para instalar el proyecto es necesario ejecutar el comando `composer install` desde el directorio de trabajo.
- Crear una base de datos llamada `dropea`.
- Configurar el archivo `.env`.
- Para correr las migraciones es necesario ejecutar el comando `php artisan migrate` desde el directorio de trabajo.
- Para ejecutar el proyecto es necesario ejecutar el comando `php artisan serve` desde el directorio de trabajo.
- Para ejecutar los tests es necesario ejecutar el comando `php artisan test` desde el directorio de trabajo.

## API
Los endpoints de la API son:
-   [POST] /api/storeEntries: Guardar las entradas en la base de datos.
-   [GET] /api/{category}: Obtener todas las entidades de una categoría.
