# Ecommerce

A Laravel-based e-commerce admin panel with product management and Stripe checkout.

## What it does

- **Catalog management** — categories, brands, products (with media/images
  and related products)
- **User management** — admin and regular users, with role-based access
- **Auth** — login, email verification, password reset/forgot-password flow
- **Payments** — checkout via Stripe, with webhook handling for payment events
- **Search & filtering** for products and users

## Stack

- Laravel
- Laravel Sanctum (API auth)
- Laravel Telescope (debugging)
- Stripe PHP SDK
- Vite

## Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# set your DB and Stripe keys in .env

php artisan migrate

npm run dev
php artisan serve
```
