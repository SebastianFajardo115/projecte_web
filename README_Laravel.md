# Entorn PHP + Laravel amb Docker

Aquest entorn permet treballar tant amb PHP bàsic com amb **Laravel**, dins d’una mateixa infraestructura amb **Docker**.  
Inclou serveis per a PHP, MySQL, phpMyAdmin i Laravel, de manera que no cal instal·lar res més.

**IMPORTANT**: Heu de descomprimir la recepta proporcionada "php-Laravel.zip" al **home del vostre usuari** o opcionalment a **/srv/**. Es a dir, ara tindreu dues carpetes la php-basic i la de php-Laravel.  Per a programar amb Laravel utilitzarem aquesta última.

A banda, abans de utilitzar aquesta nova recepta haureu de parar els contenidors de la carpeta "php-basic" per evitar conflictes de ports. Per això us situareu a /srv/php-basic i allí fareu:


```bash
make down
```

---

## Estructura del projecte
```
.
├─ docker-compose.yml
├─ Makefile
├─ README.md
├─ app/
│  ├─ index.php              # Projecte PHP bàsic
│  └─ laravel/               # Projecte Laravel
└─ docker/
   └─ web/
      ├─ Dockerfile
      └─ php-dev.ini
```

---

## Ús ràpid de l’entorn

### 1. Arrencar l’entorn

Important parar abans els contenidors de "l'antiga recepta" a /srv/php-basic!
Després a /srv/php-Laravel com a **root** fer:

```bash
make up
```

Serveis disponibles:
- Web PHP:       http://localhost:8000  
- Web Laravel:   http://localhost:8001  
- phpMyAdmin:    http://localhost:8080  (usuari: root / contrasenya: root)  
- Code Server:   http://localhost:8081  (contrasenya: alumnat)

---

### 2. Crear un projecte Laravel

Aquesta comanda crea el projecte **com a root** dins `app/laravel` i assegura que tingui tots els permisos correctes:

```bash
make laravel-new
make fix-perms
```

És important executar-la amb **l’usuari root** (per exemple, dins la màquina Vagrant com a root).  
Si no es fa així, Laravel pot crear fitxers amb permisos restringits i el servidor no podrà accedir-hi.

---

### 3. Configurar la connexió amb MySQL

Abans de provar Laravel, cal editar el fitxer `app/laravel/.env` i comprovar que hi ha aquesta configuració:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=projecte
DB_USERNAME=user
DB_PASSWORD=secret
SESSION_DRIVER=file

```

Això connecta Laravel amb el servei MySQL del Docker.  
Per defecte, Laravel intenta utilitzar SQLite, però amb aquests valors es farà servir la base de dades MySQL del vostre entorn.

---

### 4. Generar la clau d’aplicació i netejar caches

Un cop creat el projecte i configurat `.env`, cal generar la clau interna de Laravel i buidar les caches.  
Això és necessari perquè Laravel funcioni correctament amb la nova configuració:

```bash
make art cmd="key:generate"
make art cmd="config:clear"
make art cmd="cache:clear"
make art cmd="view:clear"
```

---

### 5. Comandes útils


A continuació es mostren les principals comandes disponibles al projecte. Totes s’executen des de l’arrel del repositori amb `make`.

#### 5.1 Gestió de serveis i contenidors

| Acció                                              | Comanda        |
| -------------------------------------------------- | -------------- |
| Arrencar tots els serveis                          | `make up`      |
| Aturar i eliminar contenidors (sense perdre dades) | `make down`    |
| Reiniciar tots els serveis                         | `make restart` |
| Reconstruir les imatges Docker                     | `make build`   |
| Veure els últims logs                              | `make logs`    |

---

#### 5.2 Projecte Laravel

| Acció                         | Comanda                  |
| ----------------------------- | ------------------------ |
| Crear un nou projecte Laravel | `make laravel-new`       |
| Corregir permisos de Laravel  | `make fix-perms`         |
| Executar comandes Artisan     | `make art cmd="comanda"` |

Exemples habituals:

```bash
make art cmd="migrate"
make art cmd="breeze:install blade"
make art cmd="route:list"
```

---

#### 5.4 Composer (PHP)

| Acció                      | Comanda                       |
| -------------------------- | ----------------------------- |
| Executar comandes Composer | `make composer cmd="comanda"` |

Exemples:

```bash
make composer cmd="require laravel/breeze --dev"
make composer cmd="update"
```

---

#### 5.5 Node / NPM (assets frontend)

| Acció                              | Comanda                  |
| ---------------------------------- | ------------------------ |
| Executar una comanda npm concreta  | `make npm cmd="comanda"` |
| Instal·lar dependències npm        | `make npm-install`       |
| Compilar assets en desenvolupament | `make npm-dev`           |
| Compilar assets per producció      | `make npm-build`         |

Exemples:

```bash
make npm-install
make npm-dev
make npm-build
```

---

#### 5.6 Base de dades i manteniment

| Acció                               | Comanda                            |
| ----------------------------------- | ---------------------------------- |
| Còpia de seguretat de la BD         | `make dump-db`                     |
| Restaurar l’última còpia            | `make restore-db`                  |
| Netejar contenidors antics          | `make clean`                       |
| Eliminar un contenidor concret      | `make remove-container NAME="..."` |
| Eliminar tots els contenidors       | `make clean-containers`            |
| Actualització completa del sistema  | `make system-update`               |
| Mostrar ajuda amb totes les opcions | `make help`                        |

---

### 6. Provar Laravel després de la integració

1. Obrir el navegador a:  
   `http://localhost:8001`  
   Si tot està correcte, apareixerà la pàgina de benvinguda de Laravel.

2. Crear una ruta de prova al fitxer `app/laravel/routes/web.php`:
   ```php
   use Illuminate\Support\Facades\Route;

   Route::get('/', fn () => 'Hola Laravel 12!');
   Route::get('/hola', fn () => 'Hola Món!');
   ```
3. Tornar a carregar la pàgina del navegador:
   - `http://localhost:8001` → mostra “Hola Laravel 12!”
   - `http://localhost:8001/hola` → mostra “Hola Món!”

---

### 7. Comprovar la connexió amb la base de dades

Executa una primera migració per comprovar que Laravel pot connectar-se amb MySQL i crear les seves taules internes:

```bash
make art cmd="migrate"
```

Aquesta comanda crea les taules bàsiques (`users`, `migrations`, etc.) que Laravel inclou per defecte i confirma que la connexió amb la base de dades és correcta.
Si no apareix cap error, l’entorn ja està preparat per començar a treballar amb models i migracions pròpies.

---

### 8. Fer còpies de seguretat

Per crear una còpia de seguretat de totes les bases de dades:
```bash
make dump-db
```

El fitxer de còpia (`backup-YYYY-MM-DD.sql`) es guarda a la mateixa carpeta del projecte.

Per restaurar-lo:
```bash
make restore-db
```
---

### 9. Gestió de diversos projectes Laravel

El projecte Laravel es crea per defecte dins `app/laravel`.
El servidor web del contenidor mostra sempre el contingut de `app/laravel/public`, per tant només un projecte pot estar actiu i visible al navegador alhora.

Tot i això, es poden tenir diversos projectes guardats dins la carpeta `app/`, simplement canviant el nom de cadascun.
Canviar el nom **no afecta namespaces ni configuracions internes** de Laravel.

#### Exemple d’ús

Guardar un projecte i crear-ne un altre:

```bash
mv app/laravel app/laravel-grup1
make laravel-new
make fix-perms
```

Tornar a activar un projecte anterior:

```bash
rm -rf app/laravel
mv app/laravel-grup1 app/laravel
make fix-perms
```

D’aquesta manera es poden tenir diversos projectes guardats (`laravel-grup1`, `laravel-api`, `laravel-prova`, etc.).
Només cal que el projecte que es vulgui veure al navegador es digui `laravel`.
El servidor mostrarà sempre el que estigui dins `app/laravel/public` a l’adreça:

```
http://localhost:8001
```

---

### 10. Canviar de versió de PHP i Laravel

En alguns moments pot ser necessari actualitzar l’entorn a una versió més recent de Laravel o de PHP. Aquest procés s’ha de fer sempre de manera controlada perquè Laravel i PHP siguin compatibles i perquè la recepta continuï funcionant correctament.

A continuació s’explica com fer el canvi de versió de manera ordenada.

#### 10.1. Actualitzar Laravel a una nova versió major

Si en un futur es vol utilitzar una versió posterior de Laravel (per exemple, Laravel 13), cal modificar el valor que apareix al Makefile:

```
LARAVEL_VERSION ?= ^13.0
```

Aquest canvi farà que, en executar `make laravel-new`, es generi un projecte Laravel basat en la nova versió.

#### 10.2. Actualitzar PHP per garantir compatibilitat

Cada nova versió de Laravel pot requerir una versió concreta de PHP.
Per aquest motiu, sempre que es canviï la versió de Laravel, s’ha de modificar també la versió de PHP que utilitza la recepta.

Al Makefile cal actualitzar:

```
PHP_VERSION ?= 8.x
```

on “8.x” ha de ser la versió mínima de PHP compatible amb la versió de Laravel triada.

Després de modificar aquesta línia, s’ha de reconstruir l’entorn:

```
make down
make build
make up
```

Aquest procés assegura que els contenidors es tornin a generar amb la nova versió de PHP i que el projecte sigui compatible amb la nova versió de Laravel.

---

### 11. Comandes Artisan, Composer i Npm 

En aquesta recepta hi ha **tres tipus principals de comandes**, cadascuna amb una funció diferent. És important saber **quan s’ha d’utilitzar cada una**.

#### 11.1 Composer (PHP)

* **`make composer ...`**
* Serveix per **instal·lar o gestionar paquets PHP** del projecte (per exemple Laravel Breeze).
* No executa Laravel, només gestiona dependències.

Exemple:

```bash
make composer cmd="require laravel/breeze --dev"
```

---

#### 11.2 Artisan (Laravel)

* **`make art ...`**
* Serveix per executar **comandes pròpies de Laravel** (migracions, rutes, configuració…).
* Sempre que una comanda comenci per `php artisan`, s’ha d’executar amb `make art`.

Exemples:

```bash
make art cmd="migrate"
make art cmd="breeze:install blade"
make art cmd="route:list"
```

---

#### 11.3 NPM / Node (Frontend)

* **`make npm ...`**, **`make npm-install`**, **`make npm-dev`**, **`make npm-build`**
* Serveixen per **gestionar i compilar els assets frontend** (Tailwind, Vite…).
* No utilitzen el contenidor Laravel, sinó un **contenidor Node temporal**.

Ús habitual:

```bash
make npm-install   # la primera vegada o després d’instal·lar Breeze
make npm-dev       # mentre es treballa a classe
make npm-build     # abans d’un lliurament final
```

---

### 12. Actualitzar la màquina en cas d’errors de sistema ###

En algunes ocasions, sobretot si la màquina virtual o el sistema operatiu fa temps que no s’actualitzen, poden aparèixer errors relacionats amb certificats, rellotge o versions antigues de paquets.
Si això passa, es pot utilitzar l’ordre següent per actualitzar i posar al dia la màquina.

Aquesta comanda:

* actualitza tots els paquets del sistema,
* assegura que els certificats TLS estiguin correctes,
* sincronitza l’hora automàticament,
* reinicia Docker per aplicar els canvis.

Per executar-la, dins la màquina i des de la carpeta del projecte, cal fer:

```bash
sudo make system-update
```

Un cop finalitzada l’actualització, és recomanable reiniciar la màquina.
Aquesta opció només s’hauria d’utilitzar en cas d’errors de sistema o quan s’indiqui des del professorat.


### 13. Notes finals

* Si la recepta s'executa a una màquina que està desactualitzada o dóna errors de certificats, s'ha d'actualitzar fent **sudo make system-update**. Posteriorment, s'ha de reiniciar. Posteriorment tornar-ho a provar amb **make up**.
* Sempre que es creï un projecte nou Laravel cal fer-ho amb **root** i després aplicar `make fix-perms`.
* Les dades de MySQL es conserven automàticament al volum `php-basic_mysql-data`.
* No cal entrar dins els contenidors: totes les comandes es poden fer directament des de l’entorn local o la màquina Vagrant.
* Si hi ha errors de permisos o “permission denied”, repetir `make fix-perms` assegurant-se que el projecte és propietat de root.
* Si Laravel mostra un error d’SQLite, cal revisar el fitxer `.env` i confirmar que utilitza MySQL.
* Quan es treballi amb noves versions de Laravel o es modifiqui el Makefile, sempre s’ha de comprovar quina versió de PHP és compatible amb la versió escollida de Laravel. Si apareixen errors de compatibilitat després d’una actualització, s’ha de revisar l’apartat dedicat al canvi de versió d'aquest Readme (**punt 10**) de Laravel  i PHP, i assegurar que ambdues versions coincideixen amb els requisits oficials del framework. 

---