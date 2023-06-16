# court-api
Simple REST API for tennis courts and reservations.

Laravel v10 and PHP 8.1

To run the application use these commands:
docker-compose build
docker-compose up -d

To reset database and seed with fresh random data:
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

Default users to access reservations are:

test1@example.com 
00000000

test2@example.com 
11111111
