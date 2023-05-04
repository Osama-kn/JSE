# Coding chalange - Laravel / VueJs By KNOUZ Oussama

This project is a web application built using Laravel and Vue.js. It provides the following features: 
- Ability to create a product via web or CLI
- A listing of products with the ability to sort by price and/or filter by category via the web interface

### Tech Specification
  - Node 15.14.0
  - Laravel 8
  - PHP 7

## Installation

1. Clone the repository to your local machine using `git clone https://github.com/Osama-kn/JSE.git`.
2. Run `composer install` to install the PHP dependencies.
3. Run `npm install` to install the JavaScript dependencies.
4. Create a new database for the project and update the `.env` file with your database credentials.
5. Run `php artisan migrate` to migrate the database.
6. Run `php artisan db:seed` to seed the database with sample data.
7. Run `php artisan storage:link` to create a symbolic link from the `public/storage` directory to the `storage/app/public` directory.
8. Run `php artisan key:generate` to generate a new application key.
9. Run `npm run dev` to build the JavaScript and CSS assets.
10. Run `php artisan serve` to start the local development server.


## Usage

Once you have the project running, you can access it in your web browser at `http://localhost:8000`.

### Creating a Product

To create a product, follow these steps:

1. Navigate to the "Add Product" page.
2. Fill out the product information form.
3. Submit the form to create the product.

Alternatively, you can create a product using the CLI by running the following command:
    `php artisan create:product {name} {description} {price} {image_url} {categories_ids}`

- `{name}`: the name of the product
- `{description}`: a description of the product
- `{price}`: the price of the product
- `{image_url}`: a URL to an image of the product
- `{categories_ids}`: a comma-separated list of category IDs that the product belongs to

### Listing Products

To view a listing of products, follow these steps:

1. Navigate to the "Products" page.
2. Use the "Sort By" dropdown to sort the products by price (ascending or descending).
3. Use the "Filter By Category" input to filter the products by category.

License
----
