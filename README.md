# Clevyr Skill Browser
===

# Clevyr Skill Browser

### How to make it work:

You'll need (1) Docker Desktop running, (2) access to Anne S's Clevyr Skill Inventory spreadsheet, and a (3) Google API service account with the Google Sheets & Google Drive APIs enabled. 

After setting up your service account, download the credentials JSON file and place it in the `/storage` folder.

With that done, clone this repository and copy `.env.example` to `.env` then configure that last four lines of `.env` with your Google API variables.

In your terminal, `cd` into the repository's root directory. Then type:

```
source .zshrc
dc up -d
```

You should now be able to access the site at https://clevyr.run.

## Import 

To import data, go to /import . If everything looks good, click "Import!" and wait about 10-15 seconds.

You should now be able to browse the data contained in Anne's spreadsheet.

## Linting
```
# PHP Linting
docker-compose exec app ./vendor/bin/phpstan analyse

# JS Linting
docker-compose exec hot npm run lint
docker-compose exec hot npm run stylelint-lint
```

## [Laravel Pint](https://laravel.com/docs/9.x/pint)
Laravel Pint is an opinionated PHP code style fixer for minimalists.
```
./vendor/bin/pint
```

## Testing
```
# Run the PHP Pest / UnitTest Tests
docker-compose exec app php artisan test

# Run the Laravel Dusk (i.e. browser-driven) tests
# NOTE: You have to disable the Vite hot reloader to run these.
docker-compose stop hot && docker-compose exec app php artisan pest:dusk && docker-compose start hot
```
