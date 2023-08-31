build:
	docker compose run -T php composer build

coverage:
	docker compose run -T php composer test:coverage

doc:
	docker compose run -T phpdoc
	sudo chown -R ${UID}:${UID} build

project:
	docker compose run -T php php project.php

.PHONY: build doc
