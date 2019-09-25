# Market [![Build Status](https://travis-ci.org/fenow/Market.svg?branch=master)](https://travis-ci.org/fenow/Market.svg?branch=master)

Crypto currency trading automation on exchanges :
- Bittrex (Available)
- Poloniex (soon)
- Kraken (soon)

##Notes
For know opportunities use this command :
```bin/console app:check-opportunity```

For execute trade workflow use this command :
```bin/console app:session-workflow```

##Constraints

N will be between 1 and 1,000,000, inclusive

## Install project

```sh
git clone git@github.com:fenow/Market.git
composer install
cp env.dist .env
bon/console do:mi:mi
```

## Make commands
* `make tests` Execute phpunit 
* `make stan`  Execute phpstan
* `make fixer` Execute php-cs-fixer
* `make precommit` It's a shorcut for execute `stan` and `tests` and `fixer`. You can use it in a git hook to clean and test your code before commit it
