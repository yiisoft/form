build: assets html

assets:
	docker run --rm -it -w /app/ -u `id -u`:`id -g` -v ./:/app node:21.5.0-alpine3.19 /app/assets.sh

html:
	docker run --rm -it -w /app/ -u `id -u`:`id -g` -v ./../:/app php:8.3-alpine3.19 /app/themes-preview/html.sh
