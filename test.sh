echo "Running tests for Users app..."
docker-compose exec -T users php artisan test

# Run tests for second Laravel app
echo "Running tests for Notifications app..."
docker-compose exec -T notifications php artisan test