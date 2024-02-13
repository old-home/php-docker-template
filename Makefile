export

composer:
	docker run -v ${PWD}:/app -e LOCAL_GID=$(shell id -g) -e LOCAL_UID=$(shell id -u) ghcr.io/old-home/php composer build
