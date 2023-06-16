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

Used .env for Laravel:<br />
// Needed for CORS check<br />
APP_URL=http://localhost:8080<br />

DB_CONNECTION=sqlite<br />
DB_HOST=localhost<br />
DB_PORT=3308<br />
DB_DATABASE=/var/www/court-api/database.sqlite<br />
DB_USERNAME=root<br />
DB_PASSWORD=<br />
<br />
DB_FOREIGN_KEYS=true<br />
