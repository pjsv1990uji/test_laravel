# Acerca del proyecto Test


Una vez que hayas descargado el proyecto, asegúrate de tener todos los paquetes necesarios instalados. Puedes encontrar la lista de paquetes en el archivo `requirements.txt`.

## Pasos para ejecutar el proyecto

1. Instala las dependencias: 
    ```bash
    composer install
    ```

2. Copia el archivo .env.example y genera el .env.
    ```
    bashcp .env.example .env
    ```

3. Genera la clave de aplicación: 
    ```
    bashphp artisan key:generate
    ```

4. Crea las tablas (se hizo la prueba con sqlite).
    ```
    bashphp artisan migrate
    ```

5. Ejecuta el servidor de desarrollo de Laravel:

    ```bash
    php artisan serve
    ```

6. Compila los assets usando npm, comprobar que se tiene configurado tal como se indica en `https://tailwindcss.com/docs/guides/laravel`:

    ```bash
    npm run dev
    ```

Estos comandos aseguran que la aplicación se ejecute correctamente con todas las dependencias y los assets compilados.

Para los formatos CSS se esta utilizando: `Tailwind CSS`.