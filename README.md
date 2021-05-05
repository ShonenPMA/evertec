# Prueba Evertec

Prueba Técnica

## Resumen

  * [Instalación](#instalacion)
  * [Optimizando el proyecto en producción](#optimizando-el-proyecto-en-produccion)

### Instalación

1. Clonar el repositorio en una carpeta(evertec):

> git clone https://github.com/ShonenPMA/evertec.git  evertec

2. Ir a la carpeta y ejecutar el comando:

> composer install --optimize-autoloader --no-dev

3. Copiar el .env.example para generar tus variables de entorno:

> cp .env.example .env

4. Editar tu archivo .env:

> nano .env

> Asignar las variables de entorno:
  * CHECKOUT_URL
  * CHECKOUT_LOGIN
  * CHECKOUT_SECRETKEY
  * CHECKOUT_NONCE

5. Generar la llave de la aplicación:

> php artisan key:generate

6. Ejecutar migraciones y seeders

> php artisan migrate --seed
7. Asignar permisos a las carpetas bootstrap/cache y storage

> chmod -R 775 boostrap/cache
>
> chmod -R 775 storage

8. Generar los assets y copiar los skins del tinymce

> npm install && npm run production
> sudo cp -r node_modules/tinymce/skins public/js/skins/

9. Configurar en public_html el acceso a tu app (Opcional según donde se haga el deploy)

    9.1. Si se usara el proyecto como principal
    > ln -s /home/user/evertec/public public_html 

    9.2 Si se usara el proyecto como secundario

    > ln -s /home/user/evertec/public evertec 

10. Una vez creado nuestro hipervinculo en el paso 9 crearemos el hipervinculo para la carpeta storage

>php artisan storage:link (en el path de tu aplicacion)
### Optimizando el proyecto en producción

Cada vez que se actualice el repositorio y para obtener un mejor rendimiento del aplicativo se deberán ejecutar los siguientes comandos:

> php artisan config:cache
>
> php artisan route:cache
>
> php artisan view:cache


Comandos opcionales y se deberan ejecutar cuando:
1. Si se han añadido nuevos paquetes o modificado el archivo composer.sjon

> composer install --optimize-autoloader --no-dev

2. Se actualizaron los assets o cambió el archivo webpack.mix.js

> npm run production

3. Se crearon nuevas migraciones

> php artisan migrate