# Acerca del proyecto Test


Una vez que hayas descargado el proyecto, asegúrate de tener todos los paquetes necesarios instalados. Puedes encontrar la lista de paquetes en el archivo `requirements.txt`.

## Pasos para ejecutar el proyecto

1. Instala las dependencias una vez que se encuentre dentro de la carpeta clonada: 
    ```bash
    composer install
    ```

2. Copia el archivo .env.example y genera el .env.
    ```bash
    cp .env.example .env
    ```

3. Genera la clave de aplicación: 
    ```bash
    php artisan key:generate
    ```

4. Crear las tablas (se hizo la prueba con sqlite, por lo que si se desea trabajar con lo mismo se debe cambiar la configuracion en el .env a DB_CONNECTION=sqlite previo a ejecutar el siguiente comando).
    ```bash
    php artisan migrate
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