# 💰 RICOX — Gestor de Finanzas Personales

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel)
![FilamentPHP](https://img.shields.io/badge/FilamentPHP-5-orange?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.3-purple?style=for-the-badge&logo=php)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**RICOX** es un gestor de finanzas personales completo construido con Laravel 12 y FilamentPHP 5. Incluye dashboard, movimientos, presupuestos, metas, deudas, reportes PDF, asistente IA, 2FA, PWA y mucho más.

</div>

---

## ✨ Características principales

- 📊 **Dashboard** con widgets de ahorro, presupuestos, metas, deudas y más
- 💸 **Movimientos** con categorías, subcategorías y recurrentes
- 🎯 **Presupuestos** con alertas automáticas
- 🏆 **Metas de ahorro** con seguimiento de progreso
- 💳 **Deudas** con abonos parciales
- 📄 **Reportes PDF** — mensual, anual, por cuenta, metas y deudas
- 🤖 **Asistente IA** con Claude (chat flotante)
- 🔮 **Análisis predictivo** y correlaciones
- 🗓️ **Mapa de calor** de gastos
- 📐 **Regla 50/30/20** con historial
- 💱 **Tipos de cambio** con historial
- 🔐 **2FA** con Google Authenticator
- 🛡️ **Auditoría de seguridad**
- 🔒 **PIN de acceso**
- 📱 **PWA** instalable con notificaciones push
- 🗄️ **Backup y restauración** en JSON
- 📥 **Importar CSV y estados de cuenta PDF**
- 🏅 **Logros y nivel financiero**
- 🧮 **Calculadora financiera**
- 💚 **Health Check** del sistema

---

## 📋 Requisitos

| Requisito | Versión mínima |
|-----------|---------------|
| PHP | 8.3+ |
| Laravel | 12 |
| MySQL | 8.0+ |
| Composer | 2.x |
| Node.js | 18+ |
| NPM | 9+ |
| Extensión GD | PHP |
| Extensión ZIP | PHP |
| Extensión OpenSSL | PHP |

---

## 🚀 Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/AbrahamCueva/gestor-finanzas.git
cd gestor-finanzas
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias Node

```bash
npm install
```

### 4. Copiar el archivo de entorno

```bash
cp .env.example .env
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Configurar el archivo `.env`

Abre `.env` y configura lo siguiente:

```env
APP_NAME=NOMBRE_QUE_MAS_PREFIERAS
APP_URL=http://localhost:8000

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ricox
DB_USERNAME=root
DB_PASSWORD=

# Correo (para recuperación de PIN y alertas)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu@gmail.com
MAIL_FROM_NAME="NOMBRE_QUE_MAS_PREFIERAS"

# API de Claude (para el asistente IA)
ANTHROPIC_API_KEY=sk-ant-api03-...

# VAPID para notificaciones push PWA (generadas con php artisan app:generar-vapid-keys)
VAPID_PUBLIC_KEY=
VAPID_PRIVATE_KEY=
VAPID_SUBJECT=mailto:tu@gmail.com

# Admin email (para acceder durante mantenimiento)
ADMIN_EMAIL=tu@gmail.com
```

### 7. Crear la base de datos

Crea una base de datos MySQL llamada `ricox` (o el nombre que hayas puesto en `.env`):

```sql
CREATE DATABASE ricox CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 8. Ejecutar las migraciones

```bash
php artisan migrate
```

### 9. Crear el enlace de almacenamiento

```bash
php artisan storage:link
```

### 10. Compilar los assets

```bash
npm run build
```

### 11. Crear el usuario administrador

```bash
php artisan make:filament-user
```

Ingresa tu nombre, email y contraseña cuando lo solicite.

### 12. Publicar assets de Filament

```bash
php artisan filament:assets
```

### 13. Generar claves VAPID para PWA (opcional)

```bash
php artisan app:generar-vapid-keys
```

Copia las claves generadas a tu `.env`.

### 14. Generar iconos PWA (opcional)

```bash
php artisan app:generar-iconos-p-w-a
```

### 15. Iniciar el servidor

```bash
php artisan serve
```

Visita `http://localhost:8000` en tu navegador.

---

## ⚙️ Configuración adicional

### Scheduler (tareas automáticas)

Para que funcionen las notificaciones automáticas, tipos de cambio y limpieza de logs, debes configurar el scheduler de Laravel.

**En desarrollo (Windows/Laragon):**
```bash
php artisan schedule:work
```

**En producción (Linux/cPanel):**
Agrega al crontab:
```
* * * * * cd /ruta/a/ricox && php artisan schedule:run >> /dev/null 2>&1
```

Las tareas programadas incluyen:
- `08:00` diario — Actualizar tipos de cambio
- `09:00` diario — Verificar notificaciones inteligentes
- `08:00` lunes — Resumen semanal
- `03:00` día 1 de cada mes — Limpieza de logs antiguos

### Queue Worker (colas)

```bash
php artisan queue:work
```

### Exportación CSV/XLSX

Publica las migraciones necesarias:
```bash
php artisan vendor:publish --tag=filament-actions-migrations
php artisan migrate
```

---

## 📦 Dependencias principales

```bash
# PDF
composer require barryvdh/laravel-dompdf

# Parser PDF (importar estados de cuenta)
composer require smalot/pdfparser

# 2FA
composer require pragmarx/google2fa-laravel
composer require bacon/bacon-qr-code

# Push notifications
composer require minishlink/web-push

# Tipos de cambio (HTTP cliente ya incluido en Laravel)
# No requiere instalación adicional
```

> **Nota:** Estas dependencias ya están en `composer.json`. Al correr `composer install` se instalan automáticamente.

---

## 🔧 Comandos útiles

| Comando | Descripción |
|---------|-------------|
| `php artisan ricox:tipos-cambio` | Actualizar tipos de cambio |
| `php artisan ricox:notificaciones` | Verificar notificaciones inteligentes |
| `php artisan ricox:limpiar-logs --force` | Limpiar logs antiguos |
| `php artisan app:generar-vapid-keys` | Generar claves VAPID para PWA |
| `php artisan app:generar-iconos-p-w-a` | Generar iconos PWA |
| `php artisan optimize:clear` | Limpiar toda la caché |
| `php artisan migrate:fresh --seed` | Resetear DB con datos de prueba |
| `php artisan filament:assets` | Publicar assets de Filament |
| `php artisan schedule:work` | Ejecutar scheduler en desarrollo |
| `php artisan queue:work` | Ejecutar worker de colas |

---

## 🌐 Configuración para producción

### 1. Optimizar la aplicación

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
npm run build
```

### 2. Variables de entorno en producción

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com
```

### 3. Permisos de carpetas

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

## 🔐 Primer inicio de sesión

1. Visita `http://localhost:8000`
2. Haz clic en **Ingresar**
3. Usa el email y contraseña que creaste con `php artisan make:filament-user`
4. Al primer acceso el sistema te pedirá configurar el **2FA** con Google Authenticator
5. Escanea el QR con la app e ingresa el código de 6 dígitos
6. Completa el **Onboarding** — crea tu primera cuenta y categoría
7. ¡Listo! Ya puedes usar RICOX

---

## 📱 Instalar como PWA

1. Abre RICOX en Chrome o Edge en tu celular
2. Aparecerá un banner en la parte inferior con **"Instalar RICOX"**
3. Toca **Instalar**
4. La app se agregará a tu pantalla de inicio
5. Activa las **notificaciones push** cuando el sistema te lo solicite

---

## 🤖 Configurar el Asistente IA

1. Crea una cuenta en [console.anthropic.com](https://console.anthropic.com)
2. Ve a **API Keys** y crea una nueva clave
3. Agrega crédito en **Billing** (mínimo $5)
4. Copia la clave a tu `.env`:
   ```env
   ANTHROPIC_API_KEY=sk-ant-api03-...
   ```
5. Corre `php artisan config:clear`
6. El botón morado ✦ aparecerá en todas las páginas

---

## 📧 Configurar correo con Gmail

1. Activa la **verificación en 2 pasos** en tu cuenta de Google
2. Ve a [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
3. Crea una contraseña de aplicación para "Correo"
4. Úsala en `MAIL_PASSWORD` de tu `.env`

---

## 🗂️ Estructura del proyecto

```
ricox/
├── app/
│   ├── Console/Commands/          # Comandos artisan personalizados
│   ├── Filament/
│   │   ├── Pages/                 # Páginas personalizadas
│   │   ├── Resources/             # Resources de Filament
│   │   └── Widgets/               # Widgets del dashboard
│   ├── Http/
│   │   ├── Controllers/           # Controladores (2FA, Onboarding, etc.)
│   │   └── Middleware/            # Middlewares personalizados
│   ├── Models/                    # Modelos Eloquent
│   ├── Observers/                 # Observers de modelos
│   ├── Providers/                 # Service Providers
│   └── Services/                  # Servicios de negocio
├── database/migrations/           # Migraciones
├── public/
│   ├── icons/                     # Iconos PWA
│   ├── manifest.json              # Manifest PWA
│   └── sw.js                      # Service Worker
├── resources/views/
│   ├── 2fa/                       # Vistas de autenticación 2FA
│   ├── filament/                  # Vistas personalizadas de Filament
│   ├── pdf/                       # Vistas para generación de PDFs
│   ├── pin/                       # Vistas del PIN de acceso
│   └── errors/                    # Páginas de error personalizadas
└── routes/
    ├── web.php                    # Rutas web
    └── console.php                # Tareas programadas
```

---

## 🐛 Solución de problemas comunes

### Error: `cURL error 77` (SSL en Laragon)
Agrega `->withoutVerifying()` solo en desarrollo al hacer requests HTTP externos.

### Error: `Unable to find observer`
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: `Class not found`
```bash
composer dump-autoload
php artisan optimize:clear
```

### Los widgets no cargan
```bash
php artisan filament:assets
php artisan optimize:clear
```

### Las migraciones fallan
Verifica que la base de datos exista y las credenciales en `.env` sean correctas.

### El PDF no genera
Verifica que la extensión `gd` y `dom` de PHP estén habilitadas.

### El 2FA no funciona
Verifica que la hora del servidor esté sincronizada (NTP). Los códigos TOTP son sensibles al tiempo.

---

## 📄 Licencia

Este proyecto está bajo la licencia **MIT**. Puedes usarlo, modificarlo y distribuirlo libremente.

---

## 👨‍💻 Autor

Desarrollado por **Abraham Rico** — [@AbrahamCueva](https://github.com/AbrahamCueva)

---

<div align="center">

⭐ Si te gustó el proyecto, dale una estrella en GitHub

</div>
