# Complete Business Management System - Database Structure

## Overview
This document describes the complete database schema for the comprehensive business management system including ERP, CRM, Inventory, Sales, Purchasing, Finance, and Analytics modules.

## Database Tables (38 Tables)

### 1. Core System Tables

#### roles
Manages user roles for RBAC (Role-Based Access Control)
- `id` - Primary key
- `name` - Unique role identifier (admin, manager, accountant, cashier, etc.)
- `display_name` - Human-readable role name
- `description` - Role description
- `is_active` - Active status
- `timestamps`

#### permissions
Defines granular permissions for each module
- `id` - Primary key
- `name` - Unique permission identifier (create_invoice, view_reports, etc.)
- `display_name` - Human-readable permission name
- `module` - Module name (sales, inventory, finance, etc.)
- `description` - Permission description
- `timestamps`

#### role_permissions (Pivot Table)
Links roles to permissions (many-to-many)
- `id` - Primary key
- `role_id` - Foreign key to roles
- `permission_id` - Foreign key to permissions
- `timestamps`
- UNIQUE constraint on (role_id, permission_id)

#### users
System users with role-based access
- `id` - Primary key
- `name` - User full name
- `email` - Unique email address
- `email_verified_at` - Email verification timestamp
- `password` - Hashed password
- `phone` - Phone number
- `role_id` - Foreign key to roles
- `branch_id` - Foreign key to branches
- `is_active` - Active status
- `last_login_at` - Last login timestamp
- `avatar` - Profile picture path
- `remember_token` - Remember me token
- `timestamps`
- `soft_deletes`

#### branches
Multi-branch/multi-location support
- `id` - Primary key
- `name` - Branch name
- `code` - Unique branch code
- `phone` - Contact phone
- `email` - Contact email
- `address` - Full address
- `city` - City name
- `postal_code` - Postal/ZIP code
- `country` - Country code (default: LK)
- `currency` - Default currency (default: LKR)
- `is_active` - Active status
- `is_main` - Main branch flag
- `timestamps`

---

### 2. CRM Module Tables

#### customers
Customer master data with CRM features
- `id` - Primary key
- `customer_code` - Unique customer code
- `name` - Customer name
- `company_name` - Company name (if business)
- `email` - Email address
- `phone` - Primary phone
- `mobile` - Mobile number
- `tax_id` - Tax/VAT ID
- `credit_limit` - Credit limit amount
- `outstanding_balance` - Current outstanding balance
- `payment_terms_days` - Payment terms in days (default: 30)
- `assigned_user_id` - Foreign key to users (sales rep)
- `lead_source` - Lead source tracking
- `tags` - JSON array of tags
- `notes` - General notes
- `is_active` - Active status
- `timestamps`
- `soft_deletes`

#### addresses (Polymorphic)
Stores billing and shipping addresses for customers, suppliers, etc.
- `id` - Primary key
- `addressable_type` - Owner model type (Customer, Supplier, etc.)
- `addressable_id` - Owner model ID
- `type` - Address type (billing, shipping, both)
- `address_line1` - Address line 1
- `address_line2` - Address line 2
- `city` - City
- `state` - State/Province
- `postal_code` - Postal code
- `country` - Country code (default: LK)
- `is_default` - Default address flag
- `timestamps`

#### customer_contacts
CRM contact history and activities
- `id` - Primary key
- `customer_id` - Foreign key to customers
- `user_id` - Foreign key to users (who made contact)
- `type` - Contact type (call, email, meeting, note, task)
- `subject` - Contact subject
- `description` - Detailed description
- `contact_date` - When contact was made
- `follow_up_date` - Follow-up date
- `status` - Status (pending, completed, cancelled)
- `timestamps`

#### loyalty_points
Customer loyalty points program
- `id` - Primary key
- `customer_id` - Foreign key to customers
- `points` - Points amount (positive for earned, negative for redeemed)
- `type` - Transaction type (earned, redeemed, expired, adjusted)
- `reference_type` - Reference model (Invoice, Order, etc.)
- `reference_id` - Reference ID
- `reason` - Reason for points
- `expiry_date` - Points expiry date
- `created_by` - Foreign key to users
- `timestamps`

---

### 3. Product & Inventory Module Tables

#### product_categories
Hierarchical product categories
- `id` - Primary key
- `name` - Category name
- `slug` - URL-friendly slug
- `description` - Category description
- `parent_id` - Foreign key to parent category (self-referencing)
- `sort_order` - Display order
- `is_active` - Active status
- `timestamps`

#### tax_rates
Tax/VAT configuration
- `id` - Primary key
- `name` - Tax name (VAT, GST, etc.)
- `rate` - Tax rate percentage
- `country` - Country code
- `description` - Tax description
- `is_active` - Active status
- `timestamps`

#### products
Product master with full inventory tracking
- `id` - Primary key
- `sku` - Unique stock keeping unit
- `barcode` - Unique barcode
- `name` - Product name
- `description` - Product description
- `category_id` - Foreign key to product_categories
- `tax_id` - Foreign key to tax_rates
- `unit` - Unit of measure (pcs, kg, ltr, etc.)
- `cost_price` - Purchase cost price
- `sale_price` - Selling price
- `minimum_price` - Minimum allowed selling price
- `track_inventory` - Enable inventory tracking (boolean)
- `reorder_level` - Low stock alert level
- `reorder_quantity` - Suggested reorder quantity
- `has_variants` - Product has variants flag
- `attributes` - JSON product attributes
- `image` - Product image path
- `is_active` - Active status
- `timestamps`
- `soft_deletes`

#### warehouses
Warehouse/location management
- `id` - Primary key
- `branch_id` - Foreign key to branches
- `name` - Warehouse name
- `code` - Unique warehouse code
- `location` - Physical location
- `manager_name` - Warehouse manager
- `phone` - Contact phone
- `is_active` - Active status
- `timestamps`

#### product_stock
Real-time stock levels per warehouse
- `id` - Primary key
- `product_id` - Foreign key to products
- `warehouse_id` - Foreign key to warehouses
- `quantity_on_hand` - Physical quantity
- `reserved_quantity` - Reserved for orders
- `available_quantity` - Computed column (quantity_on_hand - reserved_quantity)
- `batch_number` - Batch number (optional)
- `expiry_date` - Expiry date (optional)
- `timestamps`
- UNIQUE constraint on (product_id, warehouse_id, batch_number)

#### stock_movements
Complete audit trail for all stock changes
- `id` - Primary key
- `product_id` - Foreign key to products
- `from_warehouse_id` - Source warehouse (nullable)
- `to_warehouse_id` - Destination warehouse (nullable)
- `quantity` - Quantity moved
- `movement_type` - Type (in, out, transfer, adjustment, sale, purchase, return)
- `reference_type` - Reference model (PurchaseOrder, Invoice, etc.)
- `reference_id` - Reference ID
- `notes` - Movement notes
- `created_by` - Foreign key to users
- `timestamps`

---

### 4. Sales Module Tables

#### sales_quotes
Customer quotations
- `id` - Primary key
- `quote_number` - Unique quote number
- `customer_id` - Foreign key to customers
- `branch_id` - Foreign key to branches
- `status` - Quote status (draft, sent, accepted, rejected, expired)
- `quote_date` - Quote date
- `valid_until` - Validity date
- `subtotal` - Subtotal amount
- `discount_amount` - Discount amount
- `tax_amount` - Tax amount
- `total` - Total amount
- `currency` - Currency code
- `notes` - Internal notes
- `terms_conditions` - Terms and conditions
- `created_by` - Foreign key to users
- `timestamps`

#### sales_quote_items
Line items for quotes
- `id` - Primary key
- `sales_quote_id` - Foreign key to sales_quotes
- `product_id` - Foreign key to products (nullable)
- `product_name` - Product name snapshot
- `description` - Item description
- `quantity` - Quantity
- `unit_price` - Unit price
- `discount_percent` - Discount percentage
- `discount_amount` - Discount amount
- `tax_rate` - Tax rate
- `tax_amount` - Tax amount
- `line_total` - Line total
- `timestamps`

#### sales_orders
Confirmed sales orders
- `id` - Primary key
- `order_number` - Unique order number
- `sales_quote_id` - Foreign key to sales_quotes (nullable)
- `customer_id` - Foreign key to customers
- `branch_id` - Foreign key to branches
- `status` - Order status (pending, confirmed, processing, shipped, delivered, cancelled)
- `order_date` - Order date
- `expected_delivery_date` - Expected delivery
- `subtotal` - Subtotal amount
- `discount_amount` - Discount amount
- `tax_amount` - Tax amount
- `shipping_amount` - Shipping cost
- `total` - Total amount
- `currency` - Currency code
- `shipping_address` - Shipping address
- `notes` - Order notes
- `created_by` - Foreign key to users
- `timestamps`

#### sales_order_items
Line items for orders
- `id` - Primary key
- `sales_order_id` - Foreign key to sales_orders
- `product_id` - Foreign key to products (nullable)
- `product_name` - Product name snapshot
- `description` - Item description
- `quantity` - Ordered quantity
- `quantity_shipped` - Shipped quantity
- `unit_price` - Unit price
- `discount_percent` - Discount percentage
- `discount_amount` - Discount amount
- `tax_rate` - Tax rate
- `tax_amount` - Tax amount
- `line_total` - Line total
- `timestamps`

#### invoices
Customer invoices with payment tracking
- `id` - Primary key
- `invoice_number` - Unique invoice number
- `sales_order_id` - Foreign key to sales_orders (nullable)
- `customer_id` - Foreign key to customers
- `branch_id` - Foreign key to branches
- `status` - Invoice status (draft, sent, partially_paid, paid, overdue, cancelled, refunded)
- `invoice_date` - Invoice date
- `due_date` - Payment due date
- `subtotal` - Subtotal amount
- `discount_amount` - Discount amount
- `tax_amount` - Tax amount
- `shipping_amount` - Shipping cost
- `total` - Total amount
- `paid_amount` - Amount paid
- `balance_due` - Computed column (total - paid_amount)
- `currency` - Currency code
- `billing_address` - Billing address
- `shipping_address` - Shipping address
- `notes` - Invoice notes
- `terms_conditions` - Terms and conditions
- `created_by` - Foreign key to users
- `timestamps`
- `soft_deletes`

#### invoice_items
Line items for invoices
- `id` - Primary key
- `invoice_id` - Foreign key to invoices
- `product_id` - Foreign key to products (nullable)
- `product_name` - Product name snapshot
- `sku` - SKU snapshot
- `description` - Item description
- `quantity` - Quantity
- `unit_price` - Unit price
- `discount_percent` - Discount percentage
- `discount_amount` - Discount amount
- `tax_rate` - Tax rate
- `tax_amount` - Tax amount
- `line_total` - Line total
- `timestamps`

#### payments
Payment tracking for invoices
- `id` - Primary key
- `payment_number` - Unique payment number
- `invoice_id` - Foreign key to invoices (nullable)
- `customer_id` - Foreign key to customers (nullable)
- `amount` - Payment amount
- `payment_method` - Method (cash, bank_transfer, cheque, credit_card, online, mobile_payment)
- `payment_date` - Payment date
- `reference_number` - Reference/transaction number
- `notes` - Payment notes
- `bank_id` - Foreign key to banks (nullable)
- `created_by` - Foreign key to users
- `timestamps`

---

### 5. Purchasing Module Tables

#### suppliers
Supplier master data
- `id` - Primary key
- `supplier_code` - Unique supplier code
- `name` - Supplier name
- `company_name` - Company name
- `email` - Email address
- `phone` - Phone number
- `contact_person` - Contact person name
- `tax_id` - Tax/VAT ID
- `payment_terms_days` - Payment terms in days
- `lead_time_days` - Lead time in days
- `currency` - Default currency
- `address` - Full address
- `notes` - Supplier notes
- `is_active` - Active status
- `timestamps`
- `soft_deletes`

#### purchase_orders
Purchase orders to suppliers
- `id` - Primary key
- `po_number` - Unique PO number
- `supplier_id` - Foreign key to suppliers
- `branch_id` - Foreign key to branches
- `warehouse_id` - Foreign key to warehouses (receiving location)
- `status` - PO status (draft, sent, confirmed, partially_received, received, billed, closed, cancelled)
- `order_date` - Order date
- `expected_date` - Expected delivery date
- `subtotal` - Subtotal amount
- `discount_amount` - Discount amount
- `tax_amount` - Tax amount
- `shipping_amount` - Shipping cost
- `total` - Total amount
- `currency` - Currency code
- `notes` - PO notes
- `terms_conditions` - Terms and conditions
- `created_by` - Foreign key to users
- `timestamps`

#### purchase_order_items
Line items for purchase orders
- `id` - Primary key
- `purchase_order_id` - Foreign key to purchase_orders
- `product_id` - Foreign key to products (nullable)
- `product_name` - Product name snapshot
- `description` - Item description
- `quantity` - Ordered quantity
- `quantity_received` - Received quantity
- `unit_cost` - Unit cost
- `discount_percent` - Discount percentage
- `discount_amount` - Discount amount
- `tax_rate` - Tax rate
- `tax_amount` - Tax amount
- `line_total` - Line total
- `timestamps`

#### goods_received_notes
Goods receipt tracking (GRN)
- `id` - Primary key
- `grn_number` - Unique GRN number
- `purchase_order_id` - Foreign key to purchase_orders
- `warehouse_id` - Foreign key to warehouses (receiving location)
- `received_date` - Receipt date
- `notes` - Receipt notes
- `items` - JSON array of received items with quantities
- `received_by` - Foreign key to users
- `timestamps`

---

### 6. Finance Module Tables

#### expense_categories
Expense category hierarchy
- `id` - Primary key
- `name` - Category name
- `code` - Unique category code
- `description` - Category description
- `parent_id` - Foreign key to parent category (self-referencing)
- `is_active` - Active status
- `timestamps`

#### expenses
Business expense tracking
- `id` - Primary key
- `expense_number` - Unique expense number
- `category_id` - Foreign key to expense_categories
- `branch_id` - Foreign key to branches
- `supplier_id` - Foreign key to suppliers (nullable)
- `title` - Expense title
- `description` - Expense description
- `amount` - Expense amount
- `expense_date` - Date of expense
- `payment_method` - Payment method (cash, bank_transfer, cheque, credit_card)
- `bank_id` - Foreign key to banks (nullable)
- `reference_number` - Reference number
- `status` - Approval status (pending, approved, paid, rejected)
- `notes` - Additional notes
- `created_by` - Foreign key to users
- `approved_by` - Foreign key to users (nullable)
- `approved_at` - Approval timestamp
- `timestamps`

#### banks
Bank account management
- `id` - Primary key
- `branch_id` - Foreign key to branches
- `bank_name` - Bank name
- `account_number` - Unique account number
- `account_holder_name` - Account holder
- `branch_name` - Bank branch name
- `swift_code` - SWIFT/BIC code
- `currency` - Account currency
- `opening_balance` - Opening balance
- `current_balance` - Current balance
- `is_active` - Active status
- `timestamps`

#### transactions
General ledger transactions
- `id` - Primary key
- `transaction_number` - Unique transaction number
- `bank_id` - Foreign key to banks (nullable)
- `type` - Transaction type (debit, credit, deposit, withdrawal, transfer)
- `amount` - Transaction amount
- `transaction_date` - Transaction date
- `reference_type` - Reference model (Invoice, Payment, Expense, etc.)
- `reference_id` - Reference ID
- `description` - Transaction description
- `created_by` - Foreign key to users
- `timestamps`

---

### 7. Supporting Tables

#### activity_logs
Complete audit trail for all system activities
- `id` - Primary key
- `user_id` - Foreign key to users (nullable)
- `entity_type` - Entity model name (Invoice, Product, etc.)
- `entity_id` - Entity ID
- `action` - Action performed (created, updated, deleted, etc.)
- `old_values` - JSON of old values
- `new_values` - JSON of new values
- `ip_address` - User IP address
- `user_agent` - User agent string
- `timestamps`

#### notifications
User notifications (in-app, email, SMS, WhatsApp)
- `id` - Primary key
- `user_id` - Foreign key to users
- `type` - Notification type (info, warning, success, error)
- `title` - Notification title
- `message` - Notification message
- `channel` - Delivery channel (database, email, sms, whatsapp)
- `reference_type` - Reference model (nullable)
- `reference_id` - Reference ID (nullable)
- `data` - JSON additional data
- `read_at` - Read timestamp (nullable)
- `timestamps`

#### attachments (Polymorphic)
File attachments for any entity
- `id` - Primary key
- `attachable_type` - Owner model type (Invoice, Expense, etc.)
- `attachable_id` - Owner model ID
- `file_name` - Original file name
- `file_path` - Storage file path
- `file_type` - File extension
- `mime_type` - MIME type
- `file_size` - File size in bytes
- `uploaded_by` - Foreign key to users
- `timestamps`

#### settings
System-wide configuration settings
- `id` - Primary key
- `key` - Unique setting key
- `value` - Setting value (text)
- `type` - Value type (string, integer, boolean, json)
- `group` - Setting group (general, email, payment, etc.)
- `description` - Setting description
- `timestamps`

---

## Entity Relationships (ER Diagram)

### One-to-Many Relationships
- `roles` → `users`
- `branches` → `users`
- `branches` → `warehouses`
- `branches` → `banks`
- `users` → `customers` (assigned_user)
- `customers` → `invoices`
- `customers` → `sales_orders`
- `customers` → `sales_quotes`
- `customers` → `payments`
- `customers` → `customer_contacts`
- `customers` → `loyalty_points`
- `suppliers` → `purchase_orders`
- `product_categories` → `products`
- `tax_rates` → `products`
- `products` → `invoice_items`
- `products` → `stock_movements`
- `warehouses` → `product_stock`
- `sales_quotes` → `sales_orders`
- `sales_orders` → `invoices`
- `invoices` → `invoice_items`
- `invoices` → `payments`
- `purchase_orders` → `purchase_order_items`
- `purchase_orders` → `goods_received_notes`
- `expense_categories` → `expenses`

### Many-to-Many Relationships
- `roles` ↔ `permissions` (via role_permissions)
- `products` ↔ `warehouses` (via product_stock)

### Polymorphic Relationships
- `addresses` → morphTo (Customer, Supplier, etc.)
- `attachments` → morphTo (Invoice, Expense, Product, etc.)

### Self-Referencing Relationships
- `product_categories` → `product_categories` (parent_id)
- `expense_categories` → `expense_categories` (parent_id)

---

## Indexes & Performance

Key indexes have been added to:
- Foreign keys (automatic in most cases)
- Unique constraints (SKU, barcodes, codes, numbers)
- Frequently queried columns (status, dates, types)
- Polymorphic type/id pairs
- Composite indexes for common query patterns

---

## Data Integrity Features

1. **Foreign Key Constraints**: All relationships enforced at database level
2. **Soft Deletes**: Critical tables use soft deletes (customers, suppliers, products, invoices, users)
3. **Computed Columns**: Balance calculations (available_quantity, balance_due)
4. **Unique Constraints**: Prevent duplicate codes, SKUs, emails
5. **Default Values**: Sensible defaults for enums, booleans, amounts
6. **Timestamps**: All tables track created_at and updated_at

---

## Security Considerations

1. **Password Hashing**: User passwords hashed with bcrypt
2. **Soft Deletes**: Important records never hard-deleted
3. **Audit Trail**: activity_logs table tracks all changes
4. **RBAC**: Complete role and permission system
5. **Data Validation**: Enum constraints on status fields

---

## Scaling Considerations

1. **Partitioning**: Large tables (activity_logs, transactions, stock_movements) can be partitioned by date
2. **Archiving**: Old records can be archived to separate tables
3. **Read Replicas**: For heavy reporting workloads
4. **Caching**: Redis for frequently accessed data
5. **Sharding**: Multi-tenant by branch_id if needed

---

## Next Steps for Implementation

1. ✅ Database migrations created and tested
2. ✅ Eloquent models generated
3. ⏳ Model relationships and business logic
4. ⏳ Seeders for sample data
5. ⏳ API controllers and routes
6. ⏳ Business logic services
7. ⏳ Frontend components
8. ⏳ Reports and analytics

---

## Technology Stack

- **Framework**: Laravel 11
- **Database**: MySQL 8.0+
- **ORM**: Eloquent
- **Cache**: Redis
- **Queue**: Redis/Database
- **Storage**: Local/S3
- **Frontend**: Vue 3 + Inertia.js (or Livewire)
