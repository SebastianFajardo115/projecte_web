# Guía de Deploy en Railway

## Requisitos previos
- Cuenta en [GitHub](https://github.com)
- Cuenta en [Railway](https://railway.app)
- Cuenta en [RAWG](https://rawg.io) con API key gratuita

---

## Archivos añadidos al proyecto

### `Dockerfile.prod`
Dockerfile de producción autocontenido. A diferencia del Dockerfile de desarrollo, este:
- Copia el código fuente dentro de la imagen
- Instala dependencias PHP (Composer) y Node (npm)
- Compila los assets de frontend (`npm run build`)
- Configura Apache con el DocumentRoot correcto para Laravel

### `start.sh`
Script que se ejecuta cada vez que el contenedor arranca:
1. Corrige el módulo MPM de Apache (necesario en Railway)
2. Cachea la configuración de Laravel
3. Limpia la caché de datos
4. Ejecuta las migraciones de base de datos
5. Arranca Apache

---

## Pasos realizados

### 1. Subir el proyecto a GitHub
El proyecto estaba en GitLab. Railway solo soporta GitHub, así que se añadió GitHub como segundo remote:

```bash
git remote add github https://github.com/TU_USUARIO/projecte_web.git
git push github main
```

### 2. Crear el proyecto en Railway
1. Ir a [railway.app](https://railway.app) → iniciar sesión con GitHub
2. **New Project** → **GitHub Repository** → seleccionar `projecte_web`
3. Railway crea el servicio automáticamente

### 3. Configurar el Dockerfile de producción
En el servicio `projecte_web`:
- **Settings** → **Build** → cambiar Builder de "Railpack" a **Dockerfile**
- **Dockerfile Path:** `Dockerfile.prod`

### 4. Añadir base de datos MySQL
En el canvas del proyecto:
- **+ Add** → **Database** → **MySQL**
- Railway crea el contenedor MySQL y lo conecta automáticamente

### 5. Obtener la API key de RAWG
1. Ir a [rawg.io](https://rawg.io) → registrarse
2. Click en **API** (esquina superior derecha)
3. Rellenar el formulario con la URL del proyecto y una descripción
4. Copiar la API key generada

### 6. Configurar las variables de entorno
En el servicio `projecte_web` → **Variables** → **Raw Editor**, pegar:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:TU_APP_KEY_AQUI
APP_URL=https://TU_URL.up.railway.app
ASSET_URL=https://TU_URL.up.railway.app
DB_CONNECTION=mysql
DB_URL=mysql://root:PASSWORD@shinkansen.proxy.rlwy.net:PORT/railway
SESSION_DRIVER=database
CACHE_STORE=database
RAWG_API_KEY=TU_RAWG_API_KEY
```

> **Nota:** La `DB_URL` completa se obtiene del servicio MySQL en Railway → Variables → `MYSQL_PUBLIC_URL`.

### 7. Generar la APP_KEY
Si no tienes PHP instalado localmente, ejecutar en PowerShell:

```powershell
$rng = [System.Security.Cryptography.RNGCryptoServiceProvider]::new()
$bytes = New-Object byte[] 32
$rng.GetBytes($bytes)
"base64:" + [Convert]::ToBase64String($bytes)
```

---

## Problemas encontrados y soluciones

| Problema | Causa | Solución |
|----------|-------|----------|
| `cd: /var/www/html/laravel: No such file or directory` | Dockerfile usaba Railpack en vez de `Dockerfile.prod` | Cambiar Builder a Dockerfile en Settings |
| `SQLSTATE[HY000] [2002] No such file or directory` | Las referencias `${{MySQL.*}}` no resolvían | Usar la `MYSQL_PUBLIC_URL` directamente como `DB_URL` |
| `More than one MPM loaded` | Apache cargaba varios módulos MPM a la vez | Deshabilitar `mpm_event` y activar `mpm_prefork` en `start.sh` |
| CSS sin cargar (Mixed Content) | Railway termina SSL en su proxy, Laravel generaba URLs con `http://` | Añadir `URL::forceScheme('https')` en `AppServiceProvider` y `ASSET_URL` en variables |
| Imágenes de juegos sin cargar | Caché de datos mock guardada en MySQL | Añadir `php artisan cache:clear` en `start.sh` |

---

## Mantenimiento

### Actualizar la app
Cada `git push` a GitHub lanza un redeploy automático en Railway:

```bash
git push github main
```

### Pausar el servicio (para ahorrar crédito)
Railway → servicio → **Settings** → **Suspend Service**

### Ver logs en tiempo real
Railway → servicio → **Deploy Logs**

### Crédito gratuito
Railway ofrece $5.00 de crédito al mes. Con esta app (Laravel + MySQL, tráfico bajo) dura aproximadamente 25-50 días.
