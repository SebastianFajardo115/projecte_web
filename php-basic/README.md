# Php-basic/


##  Estructura
```
.
├─ docker-compose.yml
├─ Makefile
├─ README.md
├─ app/                    
│  └─ index.php             # ficareu els arxius php com per exemple index.php
└─ docker/
   └─ web/
      ├─ Dockerfile
      └─ php-dev.ini
```

##  Ús ràpid

```bash
make up
# Web:        http://localhost
# phpMyAdmin: http://localhost:8080  (user: root / pass: root)

make up-code (opcional si voleu el code server)
# codeserver: http://localhost:8081  (pass: canviarAixo123) (després canviar-ho)
```
Haurieu de ficar dintre de `app/index.php` el que es demana a l'enunciat 1 (prova del funcionament del servidor php).

