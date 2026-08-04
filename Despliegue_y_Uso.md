# 8. Despliegue y Uso

> Sistema de Gestión de Inventario, Elaboración y Ventas **EsenCap**.
> Este capítulo describe los requisitos técnicos, el procedimiento de instalación y la forma de ejecutar el sistema tanto en un entorno local de desarrollo como en el entorno de producción.

---

## 8.1 Requisitos técnicos

EsenCap es una aplicación web construida sobre el framework **Laravel 12** con interfaz administrada mediante **Vite**. A continuación se detallan los requisitos de **software** y **dependencias** necesarios para su ejecución.

### Software

| Componente | Desarrollo (Local) | Producción (Render) |
|---|---|---|
| **Sistema operativo** | Windows 10/11, macOS o Linux (cualquier distribución) | Linux Alpine (contenedor Docker, `php:8.2-fpm-alpine`) |
| **Servidor web / de aplicaciones** | Servidor integrado de PHP (`php artisan serve`) | **Nginx** + **PHP-FPM** (proxy de aplicaciones dentro del contenedor) |
| **Lenguaje de programación** | PHP **8.2** o superior (requisito mínimo del framework) | PHP **8.2** (imagen oficial `php:8.2-fpm-alpine`) |
| **Base de datos** | **MySQL 8.0** (o MariaDB equivalente), base local `proyectoesencap` | **PostgreSQL** (Render Database) |

> **Nota de arquitectura:** El proyecto usa una única base de código. En desarrollo la base de datos es MySQL; en producción se utiliza PostgreSQL (también soportada por Laravel mediante el driver `pdo_pgsql`). Las consultas del sistema se escriben en SQL estándar para ser compatibles con ambos motores.

### Dependencias

#### Frameworks

| Framework | Versión | Rol |
|---|---|---|
| Laravel | ^12.0 (instalado: v12.56.0) | Framework principal de backend (rutas, Eloquent ORM, autenticación, colas, Blade) |
| Bootstrap | ^5.3.8 | Framework de estilos y componentes del frontend |
| AdminLTE | ^4.0.0-rc7 | Plantilla de panel de administración (dashboard) |
| Tailwind CSS | ^4.1.18 | Framework de utilidades CSS (procesado por Vite) |
| Vite | ^7.0.7 | Bundler / compilador de assets del frontend |

#### Librerías (PHP — Composer)

| Librería | Versión | Función |
|---|---|---|
| `laravel/ui` | ^4.6 | Generación de scaffolding de autenticación |
| `intervention/image` | ^3.11 | Procesamiento y manipulación de imágenes (fotos de insumos y productos) |
| `diglactic/laravel-breadcrumbs` | ^10.0 | Migas de pan (breadcrumbs) en las vistas |
| `railsware/mailtrap-php` | ^3.11 | Cliente para envío de correos de prueba vía Mailtrap |
| `laravel/tinker` | ^2.10.1 | Consola interactiva de Laravel (desarrollo) |
| `fakerphp/faker` | ^1.23 | Generación de datos ficticios (tests y seeders, solo desarrollo) |
| `phpunit/phpunit` | ^11.5.3 | Framework de pruebas unitarias (solo desarrollo) |
| `nunomaduro/collision`, `mockery/mockery` | ^8.6 / ^1.6 | Soporte de errores y mocks en pruebas (solo desarrollo) |

#### Librerías (Frontend — NPM)

| Librería | Versión | Función |
|---|---|---|
| `admin-lte` | ^4.0.0-rc7 | Tema del panel de administración |
| `apexcharts` | ^5.10.6 | Gráficos analíticos del dashboard (barras, radial, torta, líneas) |
| `sweetalert2` | ^11.26.22 | Alertas y modales de confirmación |
| `convert-units` | ^2.3.4 | Conversión entre unidades de medida |
| `docx` | ^9.7.0 | Generación de documentos Word |
| `puppeteer` | ^25.1.0 | Automatización de navegador (generación de PDF) |
| `axios` | ^1.11.0 | Cliente HTTP para peticiones AJAX |
| `bootstrap` | ^5.3.8 | Componentes de interfaz |
| `@popperjs/core` | ^2.11.6 | Tooltips y popovers de Bootstrap |
| `sass` | ^1.56.1 | Preprocesador de estilos |
| `@tailwindcss/vite` | ^4.0.0 | Plugin de Tailwind para Vite |
| `vite-plugin-compression` | ^0.5.1 | Compresión de assets en el build |

#### Herramientas externas

| Herramienta | Versión | Uso |
|---|---|---|
| Composer | 2.x (local: 2.8.12) | Gestión de dependencias PHP |
| Node.js | v22+ (build) / v24.x (local) | Runtime de JavaScript para la compilación de assets |
| NPM / pnpm | pnpm 11.7.0 (proyecto) | Gestión de dependencias frontend |
| Docker | ^24 | Contenedorización de la aplicación para producción |
| Git | — | Control de versiones del repositorio |
| Render | — | Plataforma de despliegue (PaaS) |
| Mailtrap | — | Bandeja de correo de pruebas (desarrollo) |

---

## 8.2 Instalación y ejecución

El proyecto puede ejecutarse en **dos entornos**: un entorno **local** (para desarrollo) y un entorno **productivo** desplegado en **Render**. A continuación se describe el procedimiento paso a paso para ambos.

### 8.2.1 Requisitos previos (cualquier entorno)

Antes de comenzar, verifique que el equipo cumpla con el siguiente software instalado:

1. **PHP** 8.2 o superior (con extensiones `pdo_mysql`, `mbstring`, `gd`, `zip`, `intl`, `exif`, `bcmath`).
2. **Composer** (gestor de dependencias PHP).
3. **Node.js** y **npm/pnpm** (para compilar la interfaz con Vite).
4. **Git** (para clonar el repositorio).
5. **MySQL 8.0** (para desarrollo local) o acceso a la base de datos de producción.

### 8.2.2 Instalación en entorno local (desarrollo)

Siga estos pasos para levantar el sistema en su computadora:

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/LeandroFR05/Esencap.git
   cd Esencap
   ```

2. **Instalar dependencias de PHP (Composer)**

   ```bash
   composer install
   ```

3. **Configurar el archivo de entorno**

   Cree el archivo `.env` a partir de la plantilla:

   ```bash
   cp .env.example .env
   ```

   Edite las variables de conexión a la base de datos local:

   ```
   APP_NAME=EsenCap
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=proyectoesencap
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generar la clave de la aplicación**

   ```bash
   php artisan key:generate
   ```

5. **Crear la base de datos**

   Cree la base de datos `proyectoesencap` en MySQL (desde phpMyAdmin o línea de comandos):

   ```sql
   CREATE DATABASE proyectoesencap CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. **Ejecutar migraciones y seeders**

   Esto crea las tablas del sistema y carga los datos iniciales (familias, insumos, productos, usuarios):

   ```bash
   php artisan migrate --seed
   ```

7. **Instalar dependencias de frontend y compilar los assets**

   ```bash
   npm install
   npm run build
   ```

   > Durante el desarrollo puede usarse `npm run dev` (modo watch de Vite) para que los cambios de estilos/scripts se reflejen automáticamente.

8. **Ejecutar el servidor**

   ```bash
   php artisan serve
   ```

9. **Acceder al sistema**

   Abra el navegador en `http://localhost:8000` e inicie sesión con las credenciales del usuario administrador creadas por el seeder.

> **Método alternativo:** el proyecto incluye un script automatizado que realiza los pasos 2 a 7 de forma única:

```bash
composer run setup
```

### 8.2.3 Despliegue en producción (Render)

El sistema se publica en la plataforma **Render** mediante un contenedor Docker de construcción en dos etapas:

- **Etapa 1 (Node):** compila los assets del frontend con Vite/pnpm.
- **Etapa 2 (PHP-FPM + Nginx):** sirve la aplicación en el puerto `8080`.

El proyecto ya incluye los archivos necesarios: `Dockerfile`, `render.yaml`, `docker/nginx.conf` y `docker/start.sh`.

1. **Preparar el repositorio en GitHub**

   El proyecto debe estar subido a un repositorio de GitHub accesible por Render.

2. **Crear el servicio web (Web Service)**

   - En el panel de **Render**, seleccione **New → Web Service** y conéctelo al repositorio.
   - Render detecta el archivo `render.yaml` o el `Dockerfile`. Si se usa el blueprint, se crea automáticamente.
   - El servicio se construye con **Docker** y expone el puerto `8080`.

3. **Crear la base de datos PostgreSQL**

   - En **Render**, cree un **PostgreSQL Database** (o use una externa).
   - Desde el dashboard obtenga la cadena de conexión (`Internal Database URL`).

4. **Configurar las variables de entorno**

   En la sección **Environment** del servicio web, defina:

   | Variable | Valor |
   |---|---|
   | `APP_ENV` | `production` |
   | `APP_DEBUG` | `false` |
   | `APP_URL` | `https://esencap.onrender.com` |
   | `APP_KEY` | Clave generada (ej. `php artisan key:generate --show`) |
   | `DB_CONNECTION` | `pgsql` |
   | `DB_HOST` / `DB_PORT` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | Datos del PostgreSQL de Render |
   | `SESSION_DRIVER` | `cookie` |
   | `CACHE_STORE` | `file` |
   | `QUEUE_CONNECTION` | `sync` |
   | `LOG_CHANNEL` | `stderr` |
   | `PORT` | `8080` |

   > Las variables sensibles (`APP_KEY`, `DB_*`) se configuran manualmente en el dashboard y no se suben al repositorio.

5. **Desplegar**

   - Haga clic en **Deploy**. Render construye la imagen Docker y ejecuta automáticamente el script `docker/start.sh`, que realiza el *bootstrap*: `storage:link`, cacheo de configuraciones y `migrate:fresh --seed`.
   - Al finalizar, la aplicación queda disponible en la URL pública asignada.

6. **Verificar el despliegue**

   - Ingrese a `https://esencap.onrender.com/login` y acceda con las credenciales administrador cargadas por el seeder.
   - Verifique que los estilos, imágenes y el panel del dashboard se carguen correctamente.

### 8.2.4 Ejecución del sistema (uso normal)

Una vez desplegado, el sistema se utiliza exclusivamente desde el navegador web:

1. Ingrese a la URL del sistema (`http://localhost:8000` en desarrollo o la URL pública en producción).
2. Inicie sesión con el correo y la contraseña de un usuario registrado.
3. El **Dashboard** muestra las tarjetas de estado y los gráficos analíticos del inventario.
4. Los módulos de trabajo son: **Insumos**, **Productos**, **Lotes** (vencimientos y stock) y **Ventas** (registro e historial).

> Para más detalle sobre cada pantalla, consulte el **Manual de Usuario** incluido en el proyecto (`Manual_de_Usuario.md`) o descargable desde el propio sistema.
