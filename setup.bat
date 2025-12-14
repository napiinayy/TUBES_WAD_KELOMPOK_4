echo "Setting up project..."
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
echo "Setup complete! Run 'php artisan serve' to start."