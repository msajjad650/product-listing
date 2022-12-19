# product-listing

1. Clone project
```
git clone https://github.com/msajjad650/product-listing.git
```

3. Goto .env file and update database strings
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product-listing
DB_USERNAME=root
DB_PASSWORD=
```

2. Goto project directory and do composer install
```
cd product-listing
composer install
```

4. Run Migrations
```
php artisan migrate
```

5. Run project
```
php artisan serve
```

6. Import all products
```
127.0.0.1:8000/importProducts
```
and in termial run
```
php artisan queue:work
```

Product Listing
1. Import porducts
2. Product listing (/products)
3. View Product details
4. Pagination
5. Basic Filters
