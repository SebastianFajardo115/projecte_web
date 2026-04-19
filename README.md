# Gestor de Videojocs — Laravel 12 + Docker

> Aplicació web per gestionar la teva col·lecció personal de videojocs, amb integració a l'API de RAWG per descobrir i importar jocs directament.

---

## Taula de Continguts

- [Descripció](#descripció)
- [Tecnologies](#tecnologies)
- [Estructura del Projecte](#estructura-del-projecte)
- [Serveis Docker](#serveis-docker)
- [Instal·lació i Posada en Marxa](#installació-i-posada-en-marxa)
- [Configuració](#configuració)
- [Funcionalitats](#funcionalitats)
- [Arquitectura de l'Aplicació](#arquitectura-de-laplicació)
  - [Models](#models)
  - [Controladors](#controladors)
  - [Serveis](#serveis)
  - [Rutes](#rutes)
  - [Migracions](#migracions)
- [Comandes Make](#comandes-make)
- [Gestió de Diversos Projectes Laravel](#gestió-de-diversos-projectes-laravel)
- [Canvi de Versió PHP / Laravel](#canvi-de-versió-php--laravel)
- [Notes i Resolució de Problemes](#notes-i-resolució-de-problemes)

---

## Descripció

**Gestor de Videojocs** és una aplicació web desenvolupada amb **Laravel 12** que permet als usuaris:

- Gestionar la seva col·lecció personal de videojocs (CRUD complet).
- Fer seguiment de l'estat de cada joc: **JUGANT**, **COMPLETAT** o **PENDENT**.
- Afegir detalls addicionals, categories i etiquetes a cada videojoc.
- **Integrar-se amb l'API de RAWG** per descobrir jocs populars i importar-los directament a la col·lecció.
- Panell d'administració per gestionar categories i etiquetes globals (rols d'usuari).

L'entorn de desenvolupament està completament **dockeritzat**: no cal instal·lar PHP, MySQL ni Node de manera local.

---

## Tecnologies

| Tecnologia        | Versió       | Descripció                                  |
|-------------------|-------------|---------------------------------------------|
| **Laravel**       | ^12.0       | Framework PHP per al backend                |
| **PHP**           | 8.4         | Llenguatge de programació principal         |
| **MySQL**         | 8.4         | Base de dades relacional                    |
| **Apache**        | —           | Servidor web dins del contenidor            |
| **Docker**        | —           | Contenidors per a l'entorn de dev.          |
| **Tailwind CSS**  | ^3          | Framework CSS d'utilitats (frontend)        |
| **Vite**          | ^6          | Compilador d'assets frontend                |
| **Laravel Breeze**| ^2.4        | Autenticació (login/registre)               |
| **RAWG API**      | —           | API externa de videojocs                    |
| **phpMyAdmin**    | latest      | Interfície web per a la base de dades       |
| **Code Server**   | latest      | VS Code al navegador (opcional)             |

---

## Estructura del Projecte

```
projecte_web/
├── docker-compose.yml          # Definició de serveis Docker
├── Makefile                    # Comandes d'automatització
├── README.md                   # Aquest fitxer
├── README_Laravel.md           # Guia detallada de l'entorn Laravel+Docker
│
├── docker/
│   └── web/
│       ├── Dockerfile          # Imatge PHP+Apache personalitzada
│       └── php-dev.ini         # Configuració PHP per a desenvolupament
│
└── app/
    └── laravel/                # Projecte Laravel principal
        ├── app/
        │   ├── Http/
        │   │   ├── Controllers/
        │   │   │   ├── VideojocController.php
        │   │   │   ├── CategoriaController.php
        │   │   │   ├── DetallVideojocController.php
        │   │   │   ├── EtiquetaController.php
        │   │   │   ├── GameController.php
        │   │   │   └── ProfileController.php
        │   │   ├── Middleware/
        │   │   └── Requests/
        │   ├── Models/
        │   │   ├── Videojoc.php
        │   │   ├── DetallVideojoc.php
        │   │   ├── Categoria.php
        │   │   ├── Etiqueta.php
        │   │   └── User.php
        │   ├── Services/
        │   │   ├── RawgService.php           # Integració API RAWG
        │   │   └── VideojocFromRawgService.php
        │   └── Providers/
        ├── database/
        │   ├── migrations/
        │   ├── factories/
        │   └── seeders/
        ├── resources/
        │   └── views/
        │       ├── layout.blade.php
        │       ├── landing.blade.php
        │       ├── videojocs/
        │       ├── categorias/
        │       ├── etiquetas/
        │       ├── detall_videojoc/
        │       └── auth/
        └── routes/
            ├── web.php
            └── auth.php
```

---

## Serveis Docker

L'entorn arrenca **5 contenidors** amb `docker-compose`:

| Servei          | Contenidor           | Adreça                              | Descripció                        |
|-----------------|----------------------|-------------------------------------|-----------------------------------|
| `web_php`       | `php-basic-web`      | http://localhost:8000               | PHP bàsic (sense Laravel)         |
| `web_laravel`   | `php-laravel-web`    | http://localhost:8001               | **Aplicació Laravel principal**   |
| `mysql`         | `php-basic-mysql`    | port 3306                           | MySQL 8.4                         |
| `phpmyadmin`    | `php-basic-pma`      | http://localhost:8080               | phpMyAdmin (root / root)          |
| `code`          | `php-basic-code`     | http://localhost:8081               | Code Server (pwd: `alumnat`)      |

> **Base de dades:** Les dades es conserven al volum Docker `php-basic_mysql-data` i no es perden en fer `make down`.

---

## Instal·lació i Posada en Marxa

### Requisits previs
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instal·lat i en execució.
- `make` disponible al sistema (Linux/macOS natiu; Windows: [WSL](https://learn.microsoft.com/ca-es/windows/wsl/) o [Git Bash](https://gitforwindows.org/)).

### Passos

**1. Clonar o descomprimir el projecte**

```bash
# Si el tens en un zip, descomprimeix-lo al teu home d'usuari o a /srv/
```

**2. Arrencar l'entorn**

```bash
make up
```

Això crearà el volum MySQL si no existeix i aixecarà tots els contenidors en segon pla.

**3. Crear el projecte Laravel (si no existeix)**

```bash
make laravel-new
make fix-perms
```

> Executar com a **root** per evitar problemes de permisos.

**4. Configurar la connexió amb MySQL**

Edita `app/laravel/.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=projecte
DB_USERNAME=user
DB_PASSWORD=secret
SESSION_DRIVER=file
```

**5. Generar la clau i netejar caches**

```bash
make art cmd="key:generate"
make art cmd="config:clear"
make art cmd="cache:clear"
make art cmd="view:clear"
```

**6. Executar les migracions**

```bash
make art cmd="migrate"
```

**7. Instal·lar assets frontend i compilar**

```bash
make npm-install
make npm-dev      # en desenvolupament
# o
make npm-build    # per a producció
```

**8. Obrir l'aplicació**

Obre [http://localhost:8001](http://localhost:8001) al navegador.

---

## Configuració

### Variables d'entorn principals (`app/laravel/.env`)

| Variable              | Valor per defecte | Descripció                              |
|-----------------------|-------------------|-----------------------------------------|
| `APP_NAME`            | `Laravel`         | Nom de l'aplicació                      |
| `APP_ENV`             | `local`           | Entorn (local / production)             |
| `APP_KEY`             | (generat)         | Clau de xifrat de l'app                 |
| `DB_CONNECTION`       | `mysql`           | Driver de base de dades                 |
| `DB_HOST`             | `mysql`           | Nom del servei MySQL al Docker          |
| `DB_DATABASE`         | `projecte`        | Nom de la base de dades                 |
| `DB_USERNAME`         | `user`            | Usuari de MySQL                         |
| `DB_PASSWORD`         | `secret`          | Contrasenya de MySQL                    |
| `RAWG_API_KEY`        | —                 | Clau de l'API de RAWG (opcional)        |
| `SESSION_DRIVER`      | `file`            | Driver de sessions                      |

### Versions configurables al `Makefile`

```makefile
PHP_VERSION     ?= 8.4
LARAVEL_VERSION ?= ^12.0
NODE_IMAGE      ?= node:20
```

---

## Funcionalitats

### Autenticació
- Registre i login d'usuaris via **Laravel Breeze**.
- Gestió de perfil d'usuari (editar dades, eliminar compte).
- Sistema de **rols**: usuari estàndard i **administrador** (`admin`).

### Gestió de Videojocs (CRUD)
- Llistar tots els videojocs de l'usuari autenticat.
- Crear un nou videojoc manualment amb: nom, plataforma, any d'estrena, estat i preu.
- Editar i eliminar videojocs existents.
- Canviar l'estat ràpidament amb botons dedicats:
  - **JUGANT** — El joc s'està jugant ara.
  - **COMPLETAT** — El joc ha estat completat.
  - **PENDENT** — El joc és a la llista d'espera.

### Integració RAWG API
- **Pàgina de descoberta** (`/`) amb els jocs populars obtinguts de l'API de RAWG (visible per a usuaris no autenticats).
- **Importar des de RAWG**: els usuaris autenticats poden cercar i importar jocs directament des de l'API, pre-omplint el formulari amb les dades del joc.
- Les crides a l'API es **cachegen durant 1 hora** per millorar el rendiment.
- Fallback a dades mock si l'API no és accessible.

### Detalls del Videojoc
- Afegir una fitxa de detall a cada videojoc: descripció, hores jugades, etc.
- Editar i eliminar els detalls.

### Categories i Etiquetes *(rol admin)*
- Llistar totes les categories i etiquetes del sistema.
- Assignar categories i etiquetes a cada videojoc.
- CRUD complet de categories i etiquetes.

---

## Arquitectura de l'Aplicació

### Models

| Model            | Taula              | Relacions                                          |
|------------------|--------------------|----------------------------------------------------|
| `Videojoc`       | `videojocs`        | hasOne `DetallVideojoc`, hasMany `Categoria`, hasMany `Etiqueta` |
| `DetallVideojoc` | `detall_videojocs` | belongsTo `Videojoc`                               |
| `Categoria`      | `categorias`       | belongsTo `Videojoc`                               |
| `Etiqueta`       | `etiquetas`        | belongsTo `Videojoc`                               |
| `User`           | `users`            | Autenticació + camp `role`                         |

**Estats d'un `Videojoc`:**
```
JUGANT  →  COMPLETAT
JUGANT  →  PENDENT
PENDENT →  JUGANT
```

### Controladors

| Controlador                | Ruta base            | Descripció                              |
|----------------------------|----------------------|-----------------------------------------|
| `VideojocController`       | `/videojocs`         | CRUD + canvi d'estat + integració RAWG  |
| `DetallVideojocController` | `/detall_videojoc`   | CRUD de detalls d'un videojoc           |
| `CategoriaController`      | `/categorias`        | CRUD de categories *(admin)*            |
| `EtiquetaController`       | `/etiquetas`         | CRUD d'etiquetes *(admin)*              |
| `GameController`           | `/games`             | Consulta pública de jocs via RAWG       |
| `ProfileController`        | `/profile`           | Gestió del perfil d'usuari              |

### Serveis

| Servei                      | Descripció                                                             |
|-----------------------------|------------------------------------------------------------------------|
| `RawgService`               | Comunicació amb l'API de RAWG. Suporta cerca, detall per ID i cache.   |
| `VideojocFromRawgService`   | Crea un `Videojoc` a la BD a partir de les dades obtingudes de RAWG.  |

### Rutes

```
GET    /                            → Landing (llista de jocs RAWG, per a guests)
GET    /games                       → Llista pública de jocs RAWG
GET    /games/{id}                  → Detall públic d'un joc RAWG

[Auth]
GET    /dashboard                   → Redirigeix a /videojocs
GET    /videojocs                   → Llista de videojocs
POST   /videojocs                   → Crear videojoc
GET    /videojocs/create            → Formulari de creació manual
GET    /videojocs/create-from-rawg  → Importar des de RAWG
POST   /videojocs/store-from-rawg   → Desar videojoc des de RAWG
GET    /videojocs/{id}              → Veure detall
GET    /videojocs/{id}/edit         → Formulari d'edició
PUT    /videojocs/{id}              → Actualitzar
DELETE /videojocs/{id}              → Eliminar
POST   /videojocs/{id}/complete     → Marcar com a COMPLETAT
POST   /videojocs/{id}/jugar        → Marcar com a JUGANT
POST   /videojocs/{id}/pendent      → Marcar com a PENDENT

[Auth + Admin]
GET    /categorias                  → Llista totes les categories
GET    /etiquetas                   → Llista totes les etiquetes
...    (CRUD complet de categorias i etiquetas)

[Auth]
GET    /profile                     → Editar perfil
PATCH  /profile                     → Actualitzar perfil
DELETE /profile                     → Eliminar compte
```

### Migracions

| Fitxer de migració                              | Taula creada          |
|-------------------------------------------------|-----------------------|
| `0001_01_01_000000_create_users_table`          | `users`               |
| `0001_01_01_000001_create_cache_table`          | `cache`               |
| `0001_01_01_000002_create_jobs_table`           | `jobs`                |
| `2025_12_09_075751_create_videojocs_table`      | `videojocs`           |
| `2026_02_02_121743_create_detall_videojocs_table` | `detall_videojocs`  |
| `2026_02_02_122107_create_categorias_table`     | `categorias`          |
| `2026_02_02_122117_create_etiquetas_table`      | `etiquetas`           |
| `2026_03_17_091600_add_role_to_users_table`     | Afegeix `role` a `users` |

---

## Comandes Make

Totes les comandes s'executen des de l'arrel del repositori (`projecte_web/`).

### Gestió de l'entorn

| Comanda             | Descripció                                          |
|---------------------|-----------------------------------------------------|
| `make up`           | Arrenca tots els serveis Docker                     |
| `make down`         | Para i elimina contenidors (dades conservades)      |
| `make restart`      | Para i torna a arrencar                             |
| `make build`        | Reconstrueix les imatges des de zero                |
| `make logs`         | Mostra els últims logs dels contenidors (live)      |

### Projecte Laravel

| Comanda              | Descripció                                         |
|----------------------|----------------------------------------------------|
| `make laravel-new`   | Crea un nou projecte Laravel a `app/laravel`       |
| `make fix-perms`     | Corregeix permisos i neteja caches de Laravel      |

### Artisan

```bash
make art cmd="migrate"                 # Executar migracions
make art cmd="migrate:fresh --seed"    # Recrear BD i poblar-la
make art cmd="breeze:install blade"    # Instal·lar Breeze
make art cmd="route:list"              # Veure totes les rutes
make art cmd="key:generate"            # Generar clau APP_KEY
make art cmd="config:clear"            # Netejar cache de config
make art cmd="cache:clear"             # Netejar cache
make art cmd="view:clear"              # Netejar cache de vistes
```

### Composer

```bash
make composer cmd="require laravel/breeze --dev"
make composer cmd="update"
```

### NPM / Frontend

| Comanda          | Descripció                                         |
|------------------|----------------------------------------------------|
| `make npm-install` | Instal·la dependències npm                       |
| `make npm-dev`     | Compila assets en mode desenvolupament (Vite)    |
| `make npm-build`   | Compila assets per producció                     |

### Base de dades

| Comanda              | Descripció                                        |
|----------------------|---------------------------------------------------|
| `make dump-db`       | Crea `backup-YYYY-MM-DD.sql` de tota la BD        |
| `make restore-db`    | Restaura l'últim backup trobat                    |

### Neteja

| Comanda                          | Descripció                                    |
|----------------------------------|-----------------------------------------------|
| `make clean`                     | Elimina contenidors en conflicte (sense dades)|
| `make clean-containers`          | Elimina tots els contenidors Docker           |
| `make remove-container NAME="..."` | Elimina un contenidor específic             |
| `make system-update`             | Actualitzar paquets del sistema (com a root)  |
| `make help`                      | Mostra totes les comandes disponibles         |

---

## Gestió de Diversos Projectes Laravel

El servidor web sempre serveix el contingut de `app/laravel/public`. Per gestionar diverses versions:

```bash
# Guardar el projecte actual i crear-ne un de nou
mv app/laravel app/laravel-backup
make laravel-new
make fix-perms

# Tornar a activar el projecte guardat
rm -rf app/laravel
mv app/laravel-backup app/laravel
make fix-perms
```

---

## Canvi de Versió PHP / Laravel

Per actualitzar a una nova versió de Laravel o PHP, modifica el `Makefile`:

```makefile
PHP_VERSION     ?= 8.x          # Versió de PHP compatible
LARAVEL_VERSION ?= ^13.0        # Versió de Laravel
```

Després reconstrueix l'entorn:

```bash
make down
make build
make up
```

> Consulta la [documentació oficial de Laravel](https://laravel.com/docs) per verificar la compatibilitat entre versions de PHP i Laravel.

---

## Notes i Resolució de Problemes

| Problema                                        | Solució                                                   |
|-------------------------------------------------|-----------------------------------------------------------|
| Error "permission denied" a Laravel             | Executa `make fix-perms` com a root                       |
| Laravel mostra error d'SQLite                   | Revisa el fitxer `.env` i assegura que `DB_CONNECTION=mysql` |
| Errors de certificats o xarxa                   | Executa `sudo make system-update` i reinicia la màquina   |
| Port ja en ús (EADDRINUSE)                      | Verifica que no hi ha altres contenidors actius: `docker ps` |
| RAWG API no retorna dades                       | L'app usa dades mock automàticament. Revisa `RAWG_API_KEY` al `.env` |
| Error 500 al obrir Laravel                      | Executa `make art cmd="key:generate"` i `make art cmd="config:clear"` |

---

## Credencials per defecte

| Servei      | Usuari | Contrasenya |
|-------------|--------|-------------|
| MySQL       | `user` | `secret`    |
| phpMyAdmin  | `root` | `root`      |
| Code Server | —      | `alumnat`   |

---

## Llicència

Aquest projecte és de codi obert sota la llicència [MIT](https://opensource.org/licenses/MIT).
