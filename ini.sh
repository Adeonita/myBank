docker-compose build
docker-compose up -d
docker exec -it php.mybank.dev composer install
docker exec -it php.mybank.dev php artisan migrate
docker exec -it php.mybank.dev php artisan db:seed
# php -i | grep rdkafka [confirma que a ext foi instalada]

docker exec -it php.mybank.dev composer require enqueue/rdkafka

echo "Running in: http://localhost:80"