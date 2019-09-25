##
## ---------------------------------------------------------------------------
## BoilerPlate project
## ---------------------------------------------------------------------------
##

precommit: stan fixer tests ## Clean and test code before commit

stan: ## Run PHPStan
	vendor/bin/phpstan analyse src -c phpstan.neon

tests: ## Run Tests
	vendor/phpunit/phpunit/phpunit --verbose

fixer: ## Run Php-cs-fixer
	vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix ./src


.PHONY: precommit tests stan fixer

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help
