# eCommerce Backend (PHP + OOP)

This is a starter boilerplate for a modular eCommerce backend using pure PHP with OOP practices and a custom MVC-style architecture.

## 📁 Structure Overview

```
/app
  /Controllers      → Handle request logic (User, Product, Cart, Order)
  /Models           → Database models
  /Core             → Core components (Router, DB, Auth, Payment, etc.)
/routes             → API route definitions
/config             → Configuration (DB, app settings)
/public             → Entry point (index.php)
/uploads            → Product image uploads
/logs               → Error logs
```

## 🚀 Setup

1. Clone or extract this project.
2. Configure your database in `/config/config.php`.
3. Serve `/public` as your web root.
4. Define routes in `/routes/api.php`.

## 👥 Developer Roles

- **Dev 1**: Auth & Session
- **Dev 2**: Products & Categories
- **Dev 3**: Cart & Orders
- **Dev 4**: Routing, Core, Payments

## 🛡 Security Tips

- Sanitize all user inputs
- Use prepared statements (PDO)
- Handle sessions securely
- Validate file uploads
"# react-php-ecommerce" 
