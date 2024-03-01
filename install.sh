cd users && composer install

cd ..

cd notifications && composer install

cd ..

docker compose build

docker compose up -d