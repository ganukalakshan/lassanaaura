# 🚀 Aura ERP - Quick Start Guide

## 🔐 Login
**URL**: http://localhost/lassnaaura/public/login
- **Email**: admin@example.com
- **Password**: password

## 📋 System Overview

### 4 Main Pages

#### 1️⃣ Dashboard (`/aura/dashboard`)
- **Purpose**: View all products and their quantities
- **Layout**: Responsive card grid
- **Shows**: Product name + quantity only (NO pricing visible for overview)

#### 2️⃣ Add Product Details (`/aura/products`)
- **Purpose**: Manage products (add, edit, view)
- **Layout**: Split panel (400px form + data table)
- **Features**:
  - Add new products with cost, price, discount, quantity
  - Edit existing products
  - View all product details including pricing
  - Auto-creates "Main Warehouse" if needed
  - Generates unique SKU automatically

#### 3️⃣ Add Customer (`/aura/customers/add`)
- **Purpose**: Register new customers
- **Layout**: Centered card form (550px max width)
- **Fields**: Name, Phone, Address, Notes
- **Generates**: Unique customer code automatically

#### 4️⃣ Orders (`/aura/orders`)
- **Purpose**: Create sales orders
- **Layout**: POS-style (main area + 420px cart sidebar)
- **Features**:
  - Search and select customer
  - Browse products grid
  - Add to cart
  - View cart total
  - Complete order

## 🚪 Logout Feature

### How to Logout:
1. Click on your **user name/avatar** (top right corner)
2. Dropdown menu appears
3. Click **"Logout"**
4. **Confirmation modal** appears with purple gradient icon
5. Choose:
   - **Cancel** - Stay logged in
   - **Yes, Logout** - Logout and return to login page

### Modal Features:
- ✨ Smooth slide-in animation
- 💜 Purple gradient Aura branding
- 🔒 Prevents accidental logouts
- 📱 Mobile responsive

## 🎨 Design System

### Colors
- **Primary**: Purple gradient (#667eea → #764ba2)
- **Background**: #f8f9fb
- **Text**: #1e293b
- **Success**: Green (#10b981)
- **Error**: Red (#ef4444)

### Typography
- **Font**: Inter (Google Fonts)
- **Icons**: RemixIcon 3.5.0

### Layout
- **Sidebar**: Fixed 260px width, purple gradient
- **Header**: White with user profile dropdown
- **Content**: 40px padding, responsive

## 🗄️ Database Structure

### Tables (10)
1. **users** - Admin users
2. **customers** - Customer records with address
3. **product_categories** - Product categories
4. **products** - Product master data
5. **warehouses** - Warehouse/location data
6. **product_stock** - Inventory per warehouse
7. **sales_orders** - Customer orders
8. **sales_order_items** - Order line items
9. **cache** - Laravel cache
10. **jobs** - Laravel queue jobs

### Key Relationships
```
products → product_categories (category_id)
products → product_stock (product_id)
sales_orders → customers (customer_id)
sales_orders → users (user_id)
sales_order_items → sales_orders (sales_order_id)
sales_order_items → products (product_id)
```

## 🔧 Common Tasks

### Add a Product
1. Go to "Add Product Details"
2. Fill in the form (left panel):
   - Product Name
   - Cost Price
   - Selling Price
   - Discount % (optional)
   - Quantity
   - Category (optional)
3. Click "Add Product"
4. Product appears in table (right panel)

### Edit a Product
1. Go to "Add Product Details"
2. Click "Edit" on any product in the table
3. Form fills with product data
4. Make changes
5. Click "Update Product"

### Add a Customer
1. Go to "Add Customer"
2. Fill in the centered form:
   - Name (required)
   - Phone (required)
   - Address (optional)
   - Notes (optional)
3. Click "Save Customer"
4. Success message appears

### Create an Order
1. Go to "Orders"
2. Search and select a customer
3. Browse products, click to add to cart
4. Adjust quantities in cart
5. Review total
6. Click "Complete Order"

## 🐛 Troubleshooting

### Can't Login
- Check credentials: admin@example.com / password
- Ensure database is running
- Run: `php artisan migrate:fresh --seed`

### Products Not Showing
- Check if products exist in database
- Ensure `is_active = 1` for products
- Check browser console for JS errors

### Warehouse Error
- Controllers auto-create "Main Warehouse"
- If error persists, manually add warehouse in database

### Database Issues
- Database: aura_erp
- Run: `php artisan migrate:fresh --seed`
- Check MySQL is running in Laragon

## 📁 File Structure

```
lassnaaura/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/LoginController.php
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   └── CustomerController.php
│   └── Models/
│       ├── User.php
│       ├── Customer.php
│       ├── Product.php
│       ├── ProductCategory.php
│       ├── ProductStock.php
│       ├── SalesOrder.php
│       ├── SalesOrderItem.php
│       └── Warehouse.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/aura.blade.php (main layout with logout modal)
│       ├── auth/login.blade.php
│       └── aura/
│           ├── dashboard.blade.php
│           ├── products.blade.php
│           ├── customers.blade.php
│           └── orders.blade.php
└── routes/
    └── web.php (9 routes total)
```

## 🎯 Key Features

### ✅ Logout Confirmation Modal
- Beautiful purple gradient design
- Smooth animations
- Prevents accidental logouts
- Mobile responsive

### ✅ Clean Controllers
- Only Aura ERP methods
- No unused legacy code
- Well-documented
- Easy to maintain

### ✅ Auto-Warehouse Creation
- Automatically creates "Main Warehouse"
- No manual setup needed
- Transparent to users

### ✅ Customer Address Simplified
- Direct text field in customers table
- No complex address relationships
- Easy to use

### ✅ Unique Page Layouts
1. Dashboard: Card grid
2. Products: Split panel (form + table)
3. Customers: Centered form
4. Orders: POS-style with cart

## 🔄 System Maintenance

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

### Check Migrations
```bash
php artisan migrate:status
```

## 📞 Support Information

### Admin Credentials
- **Email**: admin@example.com
- **Password**: password
- **Created by**: UserSeeder

### System Info
- **Laravel Version**: 11.x
- **PHP Version**: 8.2+
- **Database**: MySQL (aura_erp)
- **Server**: Laragon

---

**Happy Managing! 🎉**
