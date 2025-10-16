@echo off
echo Installing Spatie Laravel Permission package...
composer require spatie/laravel-permission

echo Publishing Spatie package migrations...
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

echo Running migrations...
php artisan migrate

echo Running seeders...
php artisan db:seed

echo Installation complete!
echo Default admin login: admin@admin.com / password
pause