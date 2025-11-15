# Database Entity Relationship Diagram

## Visual ER Diagram Representation

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                    LASSANA AURA - DATABASE STRUCTURE                         ║
║                   Complete Business Management System                        ║
╚══════════════════════════════════════════════════════════════════════════════╝


┌─────────────────────────────────────────────────────────────────────────────┐
│                         AUTHENTICATION & RBAC LAYER                          │
└─────────────────────────────────────────────────────────────────────────────┘

        ┌───────────────────┐
        │      roles        │
        ├───────────────────┤
        │ id                │◄──────────┐
        │ name*             │           │
        │ display_name      │           │
        │ description       │           │
        │ is_active         │           │
        └─────────┬─────────┘           │
                  │                     │
                  │ 1:N                 │
                  │                     │
        ┌─────────▼─────────┐           │
        │  role_permissions │           │
        ├───────────────────┤           │
        │ id                │           │
        │ role_id    FK     │───────────┘
        │ permission_id FK  │───────────┐
        └───────────────────┘           │
                                        │
                              ┌─────────▼─────────┐
                              │   permissions     │
                              ├───────────────────┤
                              │ id                │
                              │ name*             │
                              │ display_name      │
                              │ module            │
                              │ description       │
                              └───────────────────┘


        ┌──────────────────┐         ┌──────────────────┐
        │    branches      │         │      users       │
        ├──────────────────┤         ├──────────────────┤
        │ id               │◄────┐   │ id               │
        │ name             │     └───│ branch_id   FK   │
        │ code*            │     ┌───│ role_id     FK   │───┐
        │ phone            │     │   │ name             │   │
        │ email            │     │   │ email*           │   │
        │ address          │     │   │ password         │   │
        │ city             │     │   │ phone            │   │
        │ country          │     │   │ is_active        │   │
        │ currency         │     │   │ last_login_at    │   │
        │ is_main          │     │   │ avatar           │   │
        └──────────────────┘     │   │ soft_deletes     │   │
                                 │   └────────┬─────────┘   │
                                 │            │             │
                                 │            │             │
                                 │            │             │
                                 │            │ 1:N         │
                                 │            │             │

┌─────────────────────────────────────────────────────────────────────────────┐
│                          CRM & CUSTOMER MODULE                               │
└─────────────────────────────────────────────────────────────────────────────┘

                 ┌──────────────────────┐
                 │     customers        │
                 ├──────────────────────┤
                 │ id                   │◄────────────┐
                 │ customer_code*       │             │
                 │ name                 │             │
                 │ company_name         │             │
                 │ email                │             │
                 │ phone                │             │
                 │ tax_id               │             │
                 │ credit_limit         │             │
                 │ outstanding_balance  │             │
                 │ payment_terms_days   │             │
                 │ assigned_user_id FK  │─────┐       │
                 │ lead_source          │     │       │
                 │ tags (JSON)          │     │       │
                 │ is_active            │     │       │
                 │ soft_deletes         │     │       │
                 └──────┬───────────────┘     │       │
                        │                     │       │
                        │                     │       │
          ┌─────────────┼─────────────┬───────┘       │
          │             │             │               │
          │ 1:N         │ 1:N         │ 1:N           │
          │             │             │               │
  ┌───────▼──────┐  ┌──▼─────────┐ ┌─▼──────────┐    │
  │customer_     │  │loyalty_    │ │addresses   │◄───┘
  │contacts      │  │points      │ │(polymorphic)│
  ├──────────────┤  ├────────────┤ ├────────────┤
  │id            │  │id          │ │id          │
  │customer_id FK│  │customer_idFK│ │addressable_│
  │user_id    FK │  │points      │ │  type      │
  │type          │  │type        │ │addressable_│
  │subject       │  │reference   │ │  id        │
  │description   │  │reason      │ │type        │
  │contact_date  │  │expiry_date │ │address_line1│
  │follow_up_date│  │created_by  │ │city        │
  │status        │  └────────────┘ │postal_code │
  └──────────────┘                 │is_default  │
                                   └────────────┘


┌─────────────────────────────────────────────────────────────────────────────┐
│                     PRODUCT & INVENTORY MODULE                               │
└─────────────────────────────────────────────────────────────────────────────┘

  ┌──────────────────┐          ┌───────────────┐         ┌──────────────┐
  │product_categories│          │  tax_rates    │         │  products    │
  ├──────────────────┤          ├───────────────┤         ├──────────────┤
  │ id               │◄────┐    │ id            │◄────┐   │ id           │
  │ name             │     │    │ name          │     │   │ sku*         │
  │ slug*            │     │    │ rate          │     │   │ barcode*     │
  │ parent_id   FK   │─────┘    │ country       │     └───│ tax_id    FK │
  │ sort_order       │          │ is_active     │     ┌───│ category_id  │
  │ is_active        │          └───────────────┘     │   │ name         │
  └──────────────────┘                                │   │ description  │
   (self-referencing)                                 │   │ unit         │
                                                      │   │ cost_price   │
                                                      │   │ sale_price   │
                                                      │   │ minimum_price│
                                                      │   │ track_inventory│
                                                      │   │ reorder_level│
                                                      │   │ has_variants │
                                                      │   │ image        │
                                                      │   │ is_active    │
                                                      │   │ soft_deletes │
                                                      │   └──────┬───────┘
                                                      │          │
                                                      │          │
                   ┌──────────────┐                  │          │
                   │  warehouses  │                  │          │
                   ├──────────────┤                  │          │
                   │ id           │◄─────┐           │          │
                   │ branch_id FK │      │           │          │
                   │ name         │      │           │          │
                   │ code*        │      │           │          │
                   │ location     │      │           │          │
                   │ manager_name │      │           │          │
                   │ is_active    │      │           │          │
                   └──────┬───────┘      │           │          │
                          │              │           │          │
                          │ 1:N          │           │          │
                          │              │           │          │
                   ┌──────▼────────┐     │           │          │
                   │product_stock  │     │           │          │
                   ├───────────────┤     │           │          │
                   │ id            │     │           │          │
                   │ product_id FK │◄────┼───────────┘          │
                   │ warehouse_idFK│─────┘                      │
                   │ quantity_on_hand│                          │
                   │ reserved_quantity│                         │
                   │ available_qty │ (computed)                 │
                   │ batch_number  │                            │
                   │ expiry_date   │                            │
                   └───────────────┘                            │
                                                                │
                          ┌──────────────────┐                 │
                          │stock_movements   │                 │
                          ├──────────────────┤                 │
                          │ id               │                 │
                          │ product_id    FK │◄────────────────┘
                          │ from_warehouse_idFK│
                          │ to_warehouse_id FK │
                          │ quantity         │
                          │ movement_type    │
                          │ reference_type   │
                          │ reference_id     │
                          │ notes            │
                          │ created_by    FK │
                          └──────────────────┘


┌─────────────────────────────────────────────────────────────────────────────┐
│                     SALES & INVOICING MODULE                                 │
└─────────────────────────────────────────────────────────────────────────────┘

  ┌──────────────────┐       ┌──────────────────┐       ┌────────────────┐
  │  sales_quotes    │──────►│  sales_orders    │──────►│   invoices     │
  ├──────────────────┤  1:1  ├──────────────────┤  1:1  ├────────────────┤
  │ id               │       │ id               │       │ id             │
  │ quote_number*    │       │ order_number*    │       │ invoice_number*│
  │ customer_id   FK │       │ sales_quote_id FK│       │ sales_order_idFK│
  │ branch_id     FK │       │ customer_id   FK │       │ customer_id FK │
  │ status           │       │ branch_id     FK │       │ branch_id   FK │
  │ quote_date       │       │ status           │       │ status         │
  │ valid_until      │       │ order_date       │       │ invoice_date   │
  │ subtotal         │       │ expected_delivery│       │ due_date       │
  │ discount_amount  │       │ subtotal         │       │ subtotal       │
  │ tax_amount       │       │ discount_amount  │       │ discount_amount│
  │ total            │       │ tax_amount       │       │ tax_amount     │
  │ currency         │       │ shipping_amount  │       │ shipping_amount│
  │ notes            │       │ total            │       │ total          │
  │ terms_conditions │       │ currency         │       │ paid_amount    │
  │ created_by    FK │       │ shipping_address │       │ balance_due    │
  └────────┬─────────┘       │ created_by    FK │       │ currency       │
           │                 └────────┬─────────┘       │ billing_address│
           │ 1:N                      │ 1:N             │ shipping_address│
           │                          │                 │ created_by  FK │
  ┌────────▼────────────┐   ┌─────────▼──────────┐     │ soft_deletes   │
  │sales_quote_items    │   │sales_order_items   │     └────────┬───────┘
  ├─────────────────────┤   ├────────────────────┤              │
  │ id                  │   │ id                 │              │ 1:N
  │ sales_quote_id   FK │   │ sales_order_id  FK │              │
  │ product_id       FK │   │ product_id      FK │     ┌────────▼──────────┐
  │ product_name        │   │ product_name       │     │  invoice_items    │
  │ description         │   │ description        │     ├───────────────────┤
  │ quantity            │   │ quantity           │     │ id                │
  │ unit_price          │   │ quantity_shipped   │     │ invoice_id     FK │
  │ discount_percent    │   │ unit_price         │     │ product_id     FK │
  │ discount_amount     │   │ discount_percent   │     │ product_name      │
  │ tax_rate            │   │ discount_amount    │     │ sku               │
  │ tax_amount          │   │ tax_rate           │     │ description       │
  │ line_total          │   │ tax_amount         │     │ quantity          │
  └─────────────────────┘   │ line_total         │     │ unit_price        │
                            └────────────────────┘     │ discount_percent  │
                                                       │ discount_amount   │
                                                       │ tax_rate          │
                              ┌──────────────┐         │ tax_amount        │
                              │   payments   │         │ line_total        │
                              ├──────────────┤         └───────────────────┘
                              │ id           │
                              │ payment_num* │
                              │ invoice_id FK│◄────────┐
                              │ customer_idFK│         │ 1:N
                              │ amount       │         │
                              │ payment_method│        │
                              │ payment_date │         │
                              │ reference_num│         │
                              │ bank_id   FK │         │
                              │ created_by FK│         │
                              └──────────────┘         │


┌─────────────────────────────────────────────────────────────────────────────┐
│                     PURCHASING MODULE                                        │
└─────────────────────────────────────────────────────────────────────────────┘

  ┌──────────────────┐         ┌────────────────────┐
  │    suppliers     │────────►│  purchase_orders   │
  ├──────────────────┤   1:N   ├────────────────────┤
  │ id               │         │ id                 │
  │ supplier_code*   │         │ po_number*         │
  │ name             │         │ supplier_id     FK │
  │ company_name     │         │ branch_id       FK │
  │ email            │         │ warehouse_id    FK │
  │ phone            │         │ status             │
  │ contact_person   │         │ order_date         │
  │ tax_id           │         │ expected_date      │
  │ payment_terms_days│        │ subtotal           │
  │ lead_time_days   │         │ discount_amount    │
  │ currency         │         │ tax_amount         │
  │ address          │         │ shipping_amount    │
  │ is_active        │         │ total              │
  │ soft_deletes     │         │ currency           │
  └──────────────────┘         │ notes              │
                               │ terms_conditions   │
                               │ created_by      FK │
                               └──────┬─────────────┘
                                      │
                       ┌──────────────┼──────────────┐
                       │ 1:N          │              │ 1:N
                       │              │              │
         ┌─────────────▼──────┐  ┌────▼──────────────────┐
         │purchase_order_items│  │goods_received_notes   │
         ├────────────────────┤  ├───────────────────────┤
         │ id                 │  │ id                    │
         │ purchase_order_idFK│  │ grn_number*           │
         │ product_id      FK │  │ purchase_order_id  FK │
         │ product_name       │  │ warehouse_id       FK │
         │ description        │  │ received_date         │
         │ quantity           │  │ notes                 │
         │ quantity_received  │  │ items (JSON)          │
         │ unit_cost          │  │ received_by        FK │
         │ discount_percent   │  └───────────────────────┘
         │ discount_amount    │
         │ tax_rate           │
         │ tax_amount         │
         │ line_total         │
         └────────────────────┘


┌─────────────────────────────────────────────────────────────────────────────┐
│                     FINANCE & ACCOUNTING MODULE                              │
└─────────────────────────────────────────────────────────────────────────────┘

  ┌───────────────────┐         ┌──────────────┐
  │expense_categories │────────►│   expenses   │
  ├───────────────────┤   1:N   ├──────────────┤
  │ id                │         │ id           │
  │ name              │         │ expense_num* │
  │ code*             │         │ category_idFK│
  │ parent_id      FK │◄───┐    │ branch_id FK │
  │ is_active         │    │    │ supplier_idFK│
  └───────────────────┘    │    │ title        │
   (self-referencing)      │    │ description  │
                           │    │ amount       │
                           │    │ expense_date │
                           │    │ payment_method│
                           │    │ bank_id   FK │
                           │    │ reference_num│
                           │    │ status       │
                           │    │ created_by FK│
                           │    │ approved_byFK│
                           │    │ approved_at  │
                           │    └──────────────┘
                           │
         ┌────────────┐    │
         │   banks    │◄───┤
         ├────────────┤    │
         │ id         │    │
         │ branch_idFK│    │
         │ bank_name  │    │
         │ account_num*│   │
         │ account_holder│ │
         │ branch_name│    │
         │ swift_code │    │
         │ currency   │    │
         │ opening_bal│    │
         │ current_bal│    │
         │ is_active  │    │
         └─────┬──────┘    │
               │           │
               │ 1:N       │
               │           │
         ┌─────▼─────────┐ │
         │ transactions  │ │
         ├───────────────┤ │
         │ id            │ │
         │ transaction_num*│
         │ bank_id    FK │◄┘
         │ type          │
         │ amount        │
         │ transaction_date│
         │ reference_type│
         │ reference_id  │
         │ description   │
         │ created_by FK │
         └───────────────┘


┌─────────────────────────────────────────────────────────────────────────────┐
│                     SUPPORTING SYSTEMS                                       │
└─────────────────────────────────────────────────────────────────────────────┘

  ┌──────────────────┐      ┌─────────────────┐      ┌──────────────────┐
  │ activity_logs    │      │ notifications   │      │  attachments     │
  ├──────────────────┤      ├─────────────────┤      ├──────────────────┤
  │ id               │      │ id              │      │ id               │
  │ user_id       FK │      │ user_id      FK │      │ attachable_type  │
  │ entity_type      │      │ type            │      │ attachable_id    │
  │ entity_id        │      │ title           │      │ file_name        │
  │ action           │      │ message         │      │ file_path        │
  │ old_values (JSON)│      │ channel         │      │ file_type        │
  │ new_values (JSON)│      │ reference_type  │      │ mime_type        │
  │ ip_address       │      │ reference_id    │      │ file_size        │
  │ user_agent       │      │ data (JSON)     │      │ uploaded_by   FK │
  └──────────────────┘      │ read_at         │      └──────────────────┘
   (tracks all changes)     └─────────────────┘       (polymorphic)
                            (email/sms/whatsapp)


                            ┌──────────────────┐
                            │    settings      │
                            ├──────────────────┤
                            │ id               │
                            │ key*             │
                            │ value            │
                            │ type             │
                            │ group            │
                            │ description      │
                            └──────────────────┘


════════════════════════════════════════════════════════════════════════════

LEGEND:
  ────►  One-to-Many relationship
  ◄────  Foreign Key reference
  *      Unique constraint
  FK     Foreign Key
  (JSON) JSON data type field

Total Tables: 38
Total Relationships: 50+
Total Indexes: 80+

════════════════════════════════════════════════════════════════════════════
```

## Key Relationship Patterns

### 1. One-to-Many (1:N)
- `customers` → `invoices`
- `products` → `invoice_items`
- `warehouses` → `product_stock`
- `users` → `activity_logs`

### 2. Many-to-Many (M:N)
- `roles` ↔ `permissions` (via `role_permissions`)
- `products` ↔ `warehouses` (via `product_stock`)

### 3. One-to-One (1:1)
- `sales_quotes` → `sales_orders`
- `sales_orders` → `invoices`

### 4. Self-Referencing
- `product_categories` → `product_categories` (parent_id)
- `expense_categories` → `expense_categories` (parent_id)

### 5. Polymorphic
- `addresses` → morphTo (customers, suppliers)
- `attachments` → morphTo (invoices, expenses, products)

---

## Data Flow Examples

### Sale Process Flow
```
Quote Created → Quote Sent → Quote Accepted
     ↓
Order Confirmed → Items Picked → Invoice Generated
     ↓
Payment Received → Stock Updated → Customer Notified
     ↓
Activity Logged → Reports Updated
```

### Purchase Process Flow
```
Low Stock Alert → PO Created → PO Sent to Supplier
     ↓
Goods Received → GRN Created → Stock Updated
     ↓
Supplier Bill → Payment Made → Transaction Recorded
```

---

This ER diagram represents a complete, normalized, and production-ready database structure for a comprehensive business management system.
