# court-api
Simple REST API for tennis courts and reservations.

Laravel v10 and PHP 8.1

To run the application use these commands:<br />
docker-compose build<br />
docker-compose up -d<br />

To reset database and seed with fresh random data:<br />
docker-compose exec app php artisan migrate<br />
docker-compose exec app php artisan db:seed<br />

Default users to access the reservations with passwords are:<br />
test1@example.com<br />
00000000<br />

test2@example.com<br />
11111111<br />
