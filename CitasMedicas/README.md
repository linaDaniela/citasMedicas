<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
  
## EPS 

Este proyecto es una aplicación web desarrollada en Laravel para la gestión de citas médicas. Permite a los usuarios agendar, consultar y administrar citas de manera eficiente.

### Características principales

- Registro y autenticación de usuarios.
- Gestión de pacientes, médicos y especialidades.
- Programación y cancelación de citas.
- Panel de administración para gestión de datos.
- Notificaciones por correo electrónico.

### Requisitos

- PHP >= 8.2
- Composer
- MySQL 
- Node.js y NPM (para assets frontend)

### Instalación

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/tu-usuario/citasMedicas.git
    cd citasMedicas
    ```
2. Instalar dependencias de PHP:
    ```bash
    composer install
    ```
3. Copiar el archivo de entorno y configura tus variables:
    ```bash
    cp .env.example .env
    ```
4. Generar la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```
5. Configurar la base de datos en el archivo `.env`.
6. Ejecutar las migraciones:
    ```bash
    php artisan migrate
    ```
7. Instalar dependencias frontend y compila assets:
    ```bash
    npm install
    npm run dev
    ```
8. Iniciar el servidor de desarrollo:
    ```bash
    php artisan serve
    ```

### Uso

Accede a `http://localhost:8000` en tu navegador para comenzar a utilizar la aplicación.

### Contribución

Las contribuciones son bienvenidas. Por favor, abre un issue o pull request para sugerencias o mejoras.

### Licencia

Este proyecto está bajo la licencia MIT.
## About Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser verdaderamente gratificante. Laravel simplifica el desarrollo al facilitar tareas comunes en muchos proyectos web, como:

- [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
- [Potente contenedor de inyección de dependencias](https://laravel.com/docs/container).
- Múltiples opciones de almacenamiento para sesiones y caché.
- ORM de base de datos expresivo e intuitivo.
- Migraciones de esquemas independientes de la base de datos.
- Procesamiento robusto de trabajos en segundo plano.
- Difusión de eventos en tiempo real.

Laravel es accesible, potente y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Aprendiendo Laravel

Laravel cuenta con la documentación y biblioteca de videotutoriales más extensa y completa de todos los frameworks de aplicaciones web modernos, lo que facilita enormemente sus inicios.

También puedes probar el [Laravel Bootcamp](https://bootcamp.laravel.com), donde te guiaremos en la creación de una aplicación moderna de Laravel desde cero.

Si no te apetece leer, [Laracasts](https://laracasts.com) puede ayudarte. Laracasts contiene miles de videotutoriales sobre diversos temas, como Laravel, PHP moderno, pruebas unitarias y JavaScript. Mejora tus habilidades explorando nuestra completa biblioteca de videos.
## Patrocinadores de Laravel

Agradecemos a los siguientes patrocinadores por financiar el desarrollo de Laravel. Si te interesa ser patrocinador, visita el programa de Socios de Laravel (https://partners.laravel.com).

### Socios Premium

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Autor 
- Lina Cepeda