# Aura ERP Views

This directory contains all the view files for the Aura ERP system.

## Files

- **dashboard.blade.php** - Product overview with card-based grid layout
- **products.blade.php** - Product management with form and table layout
- **customers.blade.php** - Customer registration with centered form layout
- **orders.blade.php** - Order creation with POS-style split panel layout

## Layout

All views extend `layouts/aura.blade.php` which provides:
- Left sidebar navigation
- Header with page title
- Alert messaging system
- User profile display

## Design Philosophy

Each page has a completely unique layout while maintaining consistent branding through:
- Common color scheme (purple gradient)
- Shared typography (Inter font)
- Unified navigation
- Consistent spacing system

## Accessing Pages

- Dashboard: `/aura/dashboard`
- Products: `/aura/products`
- Customers: `/aura/customers/add`
- Orders: `/aura/orders`
