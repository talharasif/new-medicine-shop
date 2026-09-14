# Medicine_Shop — Task 2 MVC Demo (No Login)

## MVC folders
- Control
- Model
- View

## Demo mode
Login is intentionally bypassed because authentication belongs to Task 1.
The application automatically creates a demo admin session.

## Features
1. AJAX Customer Search
2. Customer Details and Order Information
3. Medicine Search and Filters
4. Medicine Details
5. Order Search and Status Filter
6. Improved Dashboard with Recent Orders, Low Stock, and Recent Customers

Existing Task 2 functionality is retained:
- Category CRUD with Liquid/Solid type
- Medicine CRUD
- Medicine image upload
- Customer deletion
- Purchase request management
- AJAX + JSON Accept/Reject
- Accepted purchase history
- PHP + JavaScript validation
- PDO prepared statements
- CSRF protection

## Run
1. Import `online_medicine_shop_clean.sql` into phpMyAdmin.
2. Put `Medicine_Shop` inside XAMPP htdocs.
3. Check `config/database.php`.
4. Open:
   http://localhost/Medicine_Shop/public/index.php

No login is required for this demonstration version.


## Final Search CRUD Fix

AJAX search results now preserve the same actions available in the normal tables:
- Medicines: View, Edit, Delete
- Customers: View, Delete
- Purchase Requests: Accept, Reject for pending requests

The duplicate AppControllers.php file has been removed, and CategoryController.php is separate.
