install:
	docker compose exec php composer install
php:
	docker compose exec php bash
down:
	docker compose down
up:
	docker compose up -d