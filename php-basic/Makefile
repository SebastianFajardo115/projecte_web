COMPOSE ?= docker compose

# --------- Arrencada / parada ----------
up:
	$(COMPOSE) up -d web mysql phpmyadmin

up-code:
	$(COMPOSE) up -d web mysql phpmyadmin code

down:
	$(COMPOSE) down

rebuild:
	$(COMPOSE) build --no-cache

ps:
	$(COMPOSE) ps

logs:
	$(COMPOSE) logs -f --tail=200

# --------- Utilitats ----------
sh:
	$(COMPOSE) exec web bash

mysql:
	$(COMPOSE) exec mysql mysql -u root -proot

pma:
	@echo "phpMyAdmin: http://localhost:8080"
web:
	@echo "PHP (Apache): http://localhost:8000"
code:
	@echo "code-server: https://localhost:8081"
