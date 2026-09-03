# Amazon Clone (PHP & MySQL)

A web application built using **PHP**, **MySQL**, **HTML**, and **CSS**. This project includes a user-facing interface to browse products by category and a dedicated admin panel to manage users, categories, and products.

---

## Features

### User Panel
* **Product Catalog:** Browse products and category pages (`index.php`, `category.php`).
* **Responsive Layout:** Basic styling managed via `style.css`.

### Admin Panel (`/admin`)
* **Dashboard:** Central administrative overview (`dashboard.php`).
* **User Management:** Add, list, and view registered users (`add_user.php`, `users.php`).
* **Category Management:** Create and organize product categories (`add_category.php`).
* **Product Management:** Add, edit, and view inventory (`add_product.php`, `edit_product.php`, `products.php`).
* **Authentication:** Dedicated admin login and logout system (`login.php`, `logout.php`).

---

## Tech Stack

* **Backend:** PHP
* **Database:** MySQL
* **Frontend:** HTML5, CSS3
* **Server Environment:** XAMPP / Apache

---

## Directory Structure

```text
amazon-clone/
├── admin/
│   ├── add_category.php
│   ├── add_product.php
│   ├── add_user.php
│   ├── dashboard.php
│   ├── edit_product.php
│   ├── login.php
│   ├── logout.php
│   ├── products.php
│   └── users.php
├── config/
│   └── db.php
├── uploads/
├── category.php
├── index.php
└── style.css
```

---

## Local Installation Setup

1. **Database Configuration**
   * Open XAMPP Control Panel and start **Apache** and **MySQL**.
   * Open phpMyAdmin (`http://localhost/phpmyadmin`).
   * Create a new MySQL database.
   * Update your database credentials (host, username, password, database name) inside `config/db.php`.

2. **Run the Project**
   * **User View:** Open `http://localhost/amazon-clone/index.php` in your browser.
   * **Admin View:** Open `http://localhost/amazon-clone/admin/login.php` to log into the admin dashboard.
