# Lassana Aura - Complete Business Management System

## 🚀 Overview

**Lassana Aura** is a comprehensive, enterprise-grade business management system built with Laravel 11. It combines the power of ERP, CRM, POS, Inventory Management, Accounting, and Analytics into one unified platform designed for small to medium-sized businesses.

## ✨ Key Features

### 📊 **Dashboard & Analytics**
- Real-time KPI cards (Revenue, Profit, Stock Value, Receivables, Payables)
- Interactive charts and trend analysis
- Customizable widgets and reports
- Export to PDF/Excel

### 👥 **CRM (Customer Relationship Management)**
- Complete customer profiles with contact history
- Lead source tracking and tagging
- Loyalty points program with expiry management
- Credit limit and outstanding balance tracking
- Customer segmentation and assigned sales representatives

### 💰 **Sales & Invoicing**
- Full Quote → Order → Invoice → Payment workflow
- Multi-line items with product references
- Flexible discount support (line-level and document-level)
- Tax calculations (inclusive/exclusive, multi-rate support)
- Multiple payment methods and partial payments
- Invoice aging and automatic overdue tracking
- PDF generation and email delivery
- WhatsApp/SMS invoice notifications

### 📦 **Inventory Management**
- Multi-warehouse stock tracking
- Real-time stock levels with reserved quantities
- Batch and expiry date tracking
- Complete movement audit trail (FIFO/LIFO)
- Reorder level alerts and recommendations
- Stock adjustments and inter-warehouse transfers
- Barcode and SKU management
- Stock valuation reports

### 🛒 **Purchasing & Supplier Management**
- Supplier profiles with payment terms and lead times
- Purchase Order creation and tracking
- Goods Received Notes (GRN) processing
- Partial receipt support
- Automatic stock updates on GRN
- Supplier aging reports

### 💳 **Finance & Accounting**
- Expense tracking with approval workflows
- Multi-bank account management
- Cash and bank transaction recording
- Profit & Loss statements
- Cash flow reporting
- Invoice and payment reconciliation
- Budget tracking

### 🔐 **User Management & Security**
- Role-Based Access Control (RBAC)
- Fine-grained permissions per module
- Multi-branch user assignments
- Complete activity audit logs
- Session management and 2FA support

### 📱 **Additional Features**
- Multi-channel notifications (Email, SMS, WhatsApp, In-app)
- File attachments for all entities (invoices, expenses, products)
- Multi-branch support with consolidated reporting
- Dark mode support
- Responsive design for mobile and tablet
- RESTful API for integrations

---

## 📁 Project Structure

```
lassnaaura/
├── app/
│   ├── Http/Controllers/     # API and Web Controllers
│   ├── Models/               # 30+ Eloquent Models
│   ├── Services/             # Business Logic Layer
│   └── Providers/            # Service Providers
├── database/
│   ├── migrations/           # 38 Database Tables
│   ├── seeders/              # Sample Data Seeders
│   └── factories/            # Model Factories
├── resources/
│   ├── views/                # Blade Templates
│   ├── js/                   # Vue.js Components
│   └── css/                  # Stylesheets
├── routes/
│   ├── web.php               # Web Routes
│   └── api.php               # API Routes
├── public/                   # Public Assets
├── storage/                  # File Storage
├── tests/                    # Unit & Feature Tests
├── DATABASE_STRUCTURE.md     # Complete DB Schema Documentation
├── SYSTEM_ARCHITECTURE.md    # System Architecture Guide
└── README.md                 # This File
```

---

## 🗄️ Database Schema

The system uses **38 interconnected tables** organized into 7 major modules:

1. **Core System** (5 tables): users, roles, permissions, branches, addresses
2. **CRM** (4 tables): customers, customer_contacts, loyalty_points, addresses
3. **Products & Inventory** (7 tables): products, product_categories, warehouses, product_stock, stock_movements, tax_rates
4. **Sales** (8 tables): sales_quotes, sales_quote_items, sales_orders, sales_order_items, invoices, invoice_items, payments
5. **Purchasing** (4 tables): suppliers, purchase_orders, purchase_order_items, goods_received_notes
6. **Finance** (5 tables): expenses, expense_categories, banks, transactions
7. **Supporting** (5 tables): activity_logs, notifications, attachments, settings

**📖 See [DATABASE_STRUCTURE.md](DATABASE_STRUCTURE.md) for complete schema details with relationships.**

---

## 🏗️ System Architecture

### Technology Stack

**Backend:**
- Laravel 11 (PHP 8.2+)
- MySQL 8.0+ / PostgreSQL 14+
- Redis (Cache & Queue)
- Eloquent ORM

**Frontend:**
- Vue 3 / React (SPA)
- Inertia.js or Livewire
- Tailwind CSS
- Chart.js / ApexCharts
- Vite (Build Tool)

**Integrations:**
- Email: SMTP / SendGrid / SES
- SMS: Twilio
- WhatsApp: Twilio / WhatsApp Business API
- Payments: Stripe, PayPal, local gateways
- PDF: DomPDF / Snappy

**📖 See [SYSTEM_ARCHITECTURE.md](SYSTEM_ARCHITECTURE.md) for complete architecture documentation.**

---

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+ or PostgreSQL 14+
- Redis (optional but recommended)

### Step 1: Clone Repository
```bash
git clone https://github.com/ganukalakshan/lassanaaura.git
cd lassanaaura/lassnaaura
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Configuration
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lassanaaura
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Run Migrations
```bash
# Run all migrations (creates 38 tables)
php artisan migrate

# Optional: Seed with sample data
php artisan db:seed
```

### Step 6: Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### Step 7: Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## 📚 Documentation

- **[DATABASE_STRUCTURE.md](DATABASE_STRUCTURE.md)** - Complete database schema with ER diagrams
- **[SYSTEM_ARCHITECTURE.md](SYSTEM_ARCHITECTURE.md)** - System architecture and module breakdown
- **API Documentation** - Coming soon (Swagger/OpenAPI)
- **User Manual** - Coming soon

---

## 🔑 Default User Roles

| Role | Description | Access Level |
|------|-------------|--------------|
| **Admin** | Full system access | All modules |
| **Manager** | Operations management | Most modules except system settings |
| **Accountant** | Finance and reporting | Finance, Reports, Sales (read) |
| **Cashier** | Sales and payments | Sales, Invoices, Payments |
| **Sales Rep** | CRM and sales | CRM, Quotes, Orders (limited) |
| **Warehouse Staff** | Inventory operations | Inventory, Stock movements |

---

## 📊 Key Modules

### 1. Dashboard
- Revenue, profit, and expense KPIs
- Sales trends and charts
- Low stock alerts
- Recent transactions
- Real-time notifications

### 2. CRM
- Customer list with search and filters
- Contact history timeline
- Loyalty points management
- Customer aging reports

### 3. Sales
- Quote management
- Order processing
- Invoice generation
- Payment recording
- Aging reports

### 4. Inventory
- Product catalog
- Multi-warehouse stock levels
- Stock movements history
- Reorder recommendations
- Stock valuation

### 5. Purchasing
- Supplier management
- Purchase order creation
- Goods receiving
- Supplier payments

### 6. Finance
- Expense tracking
- Bank account management
- Profit & Loss reports
- Cash flow statements

### 7. Reports
- Sales reports
- Inventory reports
- Financial reports
- Customer reports
- Export to Excel/PDF

---

## 🔧 Configuration

### Email Setup
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### SMS/WhatsApp (Twilio)
```env
TWILIO_SID=your-twilio-sid
TWILIO_AUTH_TOKEN=your-auth-token
TWILIO_WHATSAPP_FROM=whatsapp:+1234567890
```

### Payment Gateway
```env
STRIPE_KEY=your-stripe-key
STRIPE_SECRET=your-stripe-secret
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

---

## 🚢 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure production database
- [ ] Set up Redis for cache and queue
- [ ] Configure email service
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up automated backups
- [ ] Configure SSL/TLS certificate
- [ ] Set up monitoring (Sentry, New Relic)

### Server Requirements
- PHP 8.2+ with extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- MySQL 8.0+ or PostgreSQL 14+
- Nginx or Apache with mod_rewrite
- Redis 7+ (recommended)
- Supervisor for queue workers

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License.

---

## 👨‍💻 About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
