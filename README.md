# Laravel E-Commerce API & Admin Dashboard

A full-featured e-commerce backend built with **Laravel 13**. It serves a **RESTful API** consumed by a mobile application and ships with a **bilingual (Arabic / English) Blade admin dashboard** for managing the store. It integrates online payments, real-time and push notifications, and an AI-powered natural-language product search.

---

## Features

### RESTful API (mobile app)
- **Authentication with Laravel Sanctum**: register, login, logout, email verification, forgot/reset password, profile and password management
- **Catalog**: home feed, categories, products with variants, sizes and units
- **Cart & Wishlist**: add, update and remove items
- **Addresses**: CRUD with a "main address" flag
- **Orders**: checkout, order history, order details, and product rating after delivery
- **Delivery time slots** and **discount codes**
- **Contact / support messages**
- **Localized responses** (Arabic / English) via a locale middleware
- Consistent JSON responses through API Resources and a shared response trait

### Payments: Paymob
- Payment intention creation through the Paymob API
- Secure **webhook** handling with **HMAC signature verification**
- Payment status tracking linked to orders

### Notifications
- **Pusher** real-time broadcasting (Laravel Echo) for new orders and new user messages in the admin dashboard
- **Firebase Cloud Messaging (FCM)** push notifications to mobile devices (device token registration endpoint)
- Email replies to customer messages

### AI-Powered Search
- **Google Gemini** turns a free-text query (e.g. *"something spicy under 100 EGP"*) into structured filters (category, industry, price range)
- **Laravel Scout + Meilisearch** hybrid / semantic search using Gemini embeddings

### Admin Dashboard (Blade)
- Session-based admin login
- Dashboard with sales statistics, earning reports and monthly charts
- Management of products, variants, sizes, units, categories, industries, branches, delivery times, discount codes and sales/offers
- Order management with status workflow and timeline
- User management and a customer messages inbox with email reply
- Live notifications for new orders and messages
- Full **RTL / LTR** support (Arabic & English)

---

## Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.3+ |
| Framework | Laravel 13 |
| Auth | Laravel Sanctum |
| Database | MySQL (SQLite also supported) |
| Search | Laravel Scout, Meilisearch |
| AI | Google Gemini API |
| Payments | Paymob |
| Real-time | Pusher, Laravel Echo |
| Push notifications | Firebase Cloud Messaging (kreait/laravel-firebase) |
| Frontend (admin) | Blade, Bootstrap 5, Vite, Tailwind CSS |
| Testing | Pest |

---

## Installation

### Requirements
- PHP 8.3+ and Composer
- Node.js & npm
- MySQL
- Meilisearch (optional, for search features)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/mariamm7md3/laravel-ecommerce-api.git
cd laravel-ecommerce-api

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Create the environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Configure your database and service keys in .env
#    (DB_*, PUSHER_*, PAYMOB_*, GEMINI_API_KEY, MEILISEARCH_*, FIREBASE_CREDENTIALS)

# 7. Run migrations and seed sample data
php artisan migrate --seed

# 8. Link the storage folder (for uploaded images)
php artisan storage:link

# 9. Build assets and start the server
npm run build
php artisan serve
```

For development you can run the server, queue worker and Vite together with:

```bash
composer run dev
```

### Optional services
- **Search index**: `php artisan scout:sync-index-settings` then `php artisan scout:import "App\Models\Product"`
- **Firebase**: place your service-account JSON at the path set in `FIREBASE_CREDENTIALS` (this file is git-ignored)
- **Paymob webhook**: point your Paymob transaction callback to `POST /api/webhooks/paymob`

---

## Screenshots

> _Screenshots coming soon._

| Dashboard | Products | Orders |
|---|---|---|
| ![Dashboard](docs/screenshots/dashboard.png) | ![Products](docs/screenshots/products.png) | ![Orders](docs/screenshots/orders.png) |

---

## Note on the Admin UI Template

The admin dashboard UI is built on top of **Vuexy**, a commercially licensed admin template by **Pixinvent**. Because its license does not allow public redistribution, **the template's assets (`public/assets/vendor`, images, fonts and its stock JS/CSS) are not included in this repository**. Only the project's own Blade views and custom scripts/styles are published.

To run the admin dashboard locally you need your own Vuexy license; copy its `assets` folder into `public/assets/` (the project's custom files there will be kept). The REST API works fully without it.

---

## License

The original source code in this repository is released under the [MIT License](LICENSE). Third-party packages and the Vuexy template are subject to their own licenses.

## Author

**Mariam Mohamed Mansour**: [GitHub](https://github.com/mariamm7md3)
