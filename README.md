# 📦 Stock Management System

![Stock Management System](https://via.placeholder.com/1200x600/667eea/ffffff?text=Stock+Management+System+-+Professional+Inventory+Solution)

> **Sistem Manajemen Stok Modern** - Aplikasi web berbasis Laravel untuk mengelola inventori, transaksi, dan administrasi dengan antarmuka yang professional dan user-friendly.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql)](https://mysql.com)

## 📋 Daftar Isi

-   [👀 Preview Aplikasi](#-preview-aplikasi)
-   [✨ Fitur Utama](#-fitur-utama)
-   [🛠️ Teknologi yang Digunakan](#️-teknologi-yang-digunakan)
-   [📋 Persyaratan Sistem](#-persyaratan-sistem)
-   [🚀 Cara Install](#-cara-install)
-   [⚙️ Konfigurasi](#️-konfigurasi)
-   [🎮 Cara Menggunakan](#-cara-menggunakan)
-   [📝 Struktur Database](#-struktur-database)
-   [🔗 API Endpoints](#-api-endpoints)
-   [🧪 Testing](#-testing)
-   [📦 Deployment](#-deployment)
-   [🤝 Kontribusi](#-kontribusi)
-   [📄 Lisensi](#-lisensi)

## 👀 Preview Aplikasi

![Preview](./public/assets/overview-stock-management.gif)

## ✨ Fitur Utama

### 🔐 **Sistem Autentikasi**

-   ✅ Login/logout admin dengan keamanan tinggi
-   ✅ Manajemen profil admin
-   ✅ Multiple admin support
-   ✅ Session management yang aman

### 👥 **Manajemen Admin (CRUD)**

-   ✅ Tambah, edit, hapus admin
-   ✅ Validasi data input lengkap
-   ✅ Profile management dengan foto
-   ✅ Role-based access control

### 🏷️ **Manajemen Kategori Produk (CRUD)**

-   ✅ Kategori dengan deskripsi lengkap
-   ✅ Relasi dengan produk
-   ✅ SEO-friendly URLs (slug)
-   ✅ Validasi unique kategori

### 📦 **Manajemen Produk (CRUD)**

-   ✅ Upload gambar produk dengan validasi
-   ✅ Manajemen stok real-time
-   ✅ Kategorisasi produk
-   ✅ SEO-optimized URLs
-   ✅ Search & filter functionality

### 🔄 **Sistem Transaksi Lengkap**

-   ✅ **Stock In (Barang Masuk)** - Penambahan stok
-   ✅ **Stock Out (Barang Keluar)** - Pengurangan stok
-   ✅ **Multi-product transactions** - Satu transaksi banyak produk
-   ✅ **Stock validation** - Validasi stok otomatis untuk stock out
-   ✅ **Auto stock update** - Update stok otomatis
-   ✅ **Transaction history** - Riwayat transaksi lengkap

### 📊 **Dashboard & Analitik**

-   ✅ Statistik real-time
-   ✅ Alert produk stok rendah
-   ✅ Grafik transaksi terbaru
-   ✅ Overview performa sistem

### 🎨 **Modern UI/UX**

-   ✅ **Responsive design** - Perfect di mobile & desktop
-   ✅ **Dark theme** dengan gradient professional
-   ✅ **Fixed sidebar** dengan hamburger menu
-   ✅ **Modal confirmations** - Tidak ada alert() browser
-   ✅ **Toast notifications** - Notifikasi modern
-   ✅ **Smooth animations** - Transisi yang halus

## 🛠️ Teknologi yang Digunakan

### **Backend**

-   **Laravel 12.x** - PHP Framework terbaru
-   **PHP 8.2+** - Server-side programming
-   **MySQL 8.0+** - Database management
-   **Eloquent ORM** - Database abstraction

### **Frontend**

-   **Bootstrap 5.3** - CSS Framework
-   **Inter Font** - Modern typography
-   **FontAwesome 6.4** - Icon library
-   **Vanilla JavaScript** - Interactive elements

### **Tools & Libraries**

-   **Composer** - PHP dependency manager
-   **NPM** - Node.js package manager
-   **Laravel Storage** - File management
-   **Laravel Validation** - Input validation
-   **Laravel Authentication** - User authentication

## 📋 Persyaratan Sistem

### **Server Requirements**

-   **PHP >= 8.2**
-   **Composer** (Latest version)
-   **Node.js >= 18.x** dan **NPM**
-   **MySQL >= 8.0** atau **MariaDB >= 10.3**

### **Development Environment**

-   **XAMPP** (Recommended) atau **WAMP/MAMP**
-   **Git** untuk version control
-   **Visual Studio Code** (Recommended IDE)

### **Browser Support**

-   Chrome 90+
-   Firefox 88+
-   Safari 14+
-   Edge 90+

## 🚀 Cara Install

### **Step 1: Clone Repository**

```bash
# Clone project dari GitHub
git clone https://github.com/alifsuryadi/stock-management.git

# Masuk ke directory project
cd stock-management
```

### **Step 2: Install Dependencies**

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### **Step 3: Environment Setup**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Database Configuration**

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stock_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **Step 5: Database Setup**

```bash
# Buat database di phpMyAdmin atau MySQL CLI
CREATE DATABASE stock_management;

# Jalankan migration
php artisan migrate

# Jalankan seeder untuk data sample
php artisan db:seed
```

### **Step 6: Storage & Assets**

```bash
# Link storage untuk upload files
php artisan storage:link

# Build frontend assets
npm run build
```

### **Step 7: Jalankan Aplikasi**

```bash
# Start Laravel development server
php artisan serve

# Aplikasi berjalan di: http://localhost:8000
```

## ⚙️ Konfigurasi

### **Environment Variables**

```env
# Application
APP_NAME="Stock Management System"
APP_ENV=local
APP_KEY=base64:generated_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stock_management
DB_USERNAME=root
DB_PASSWORD=

# File Storage
FILESYSTEM_DRIVER=local

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### **Database Configuration**

```php
// config/database.php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'stock_management'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
],
```

## 🎮 Cara Menggunakan

### **1. Login ke Dashboard Admin**

```
URL: http://localhost:8000/admin/login
Email: admin@example.com
Password: password
```

> **💡 Tips**: Kredensial demo akan muncul otomatis dalam toast notification

### **2. Navigasi Dashboard**

-   **Dashboard**: Overview dan statistik sistem
-   **Kelola Admin**: CRUD management admin
-   **Kategori Produk**: Management kategori
-   **Produk**: Management produk dengan upload gambar
-   **Transaksi**: Catat stock in/out
-   **Profil**: Update profil admin

### **3. Mengelola Produk**

```
1. Buka menu "Produk"
2. Klik "Tambah Produk"
3. Isi form: nama, deskripsi, kategori, stok, gambar
4. Klik "Simpan"
```

### **4. Membuat Transaksi**

```
1. Buka menu "Transaksi" → "Tambah Transaksi"
2. Pilih tipe: Stock In (Masuk) atau Stock Out (Keluar)
3. Pilih produk dan quantity
4. Klik "Tambah Produk" untuk multiple items
5. Klik "Simpan Transaksi"
```

### **5. Fitur Mobile**

-   Hamburger menu untuk navigasi
-   Touch-friendly buttons
-   Responsive tables dengan scroll

## 📝 Struktur Database

### **Tabel Utama**

#### `admins` - Data Admin

```sql
- id (Primary Key)
- slug (Unique, SEO-friendly)
- first_name (VARCHAR)
- last_name (VARCHAR)
- email (Unique)
- birth_date (DATE)
- gender (ENUM: male, female)
- password (HASH)
- created_at, updated_at
```

#### `categories` - Kategori Produk

```sql
- id (Primary Key)
- slug (Unique, SEO-friendly)
- name (VARCHAR, Unique)
- description (TEXT)
- created_at, updated_at
```

#### `products` - Data Produk

```sql
- id (Primary Key)
- slug (Unique, SEO-friendly)
- name (VARCHAR)
- description (TEXT)
- image (VARCHAR, nullable)
- category_id (Foreign Key → categories.id)
- stock (INTEGER, default 0)
- created_at, updated_at
```

#### `transactions` - Header Transaksi

```sql
- id (Primary Key)
- slug (Unique, SEO-friendly)
- transaction_code (VARCHAR, Unique)
- type (ENUM: in, out)
- notes (TEXT, nullable)
- admin_id (Foreign Key → admins.id)
- transaction_date (TIMESTAMP)
- created_at, updated_at
```

#### `transaction_details` - Detail Transaksi

```sql
- id (Primary Key)
- transaction_id (Foreign Key → transactions.id)
- product_id (Foreign Key → products.id)
- quantity (INTEGER)
- created_at, updated_at
```

### **Relasi Database**

```
admins → transactions (1:N)
categories → products (1:N)
transactions → transaction_details (1:N)
products → transaction_details (1:N)
```

## 🔗 API Endpoints

### **Authentication**

```
GET    /admin/login          - Form login
POST   /admin/login          - Proses login
POST   /admin/logout         - Logout
GET    /admin/profile        - Profile admin
PUT    /admin/profile        - Update profile
```

### **Admin Management**

```
GET    /admin/admins         - List admin
GET    /admin/admins/create  - Form tambah admin
POST   /admin/admins         - Store admin
GET    /admin/admins/{slug}  - Detail admin
GET    /admin/admins/{slug}/edit - Form edit admin
PUT    /admin/admins/{slug}  - Update admin
DELETE /admin/admins/{slug}  - Delete admin
```

### **Categories**

```
GET    /admin/categories         - List kategori
POST   /admin/categories         - Store kategori
GET    /admin/categories/{slug}  - Detail kategori
PUT    /admin/categories/{slug}  - Update kategori
DELETE /admin/categories/{slug}  - Delete kategori
```

### **Products**

```
GET    /admin/products         - List produk (with search & filter)
POST   /admin/products         - Store produk
GET    /admin/products/{slug}  - Detail produk
PUT    /admin/products/{slug}  - Update produk
DELETE /admin/products/{slug}  - Delete produk
```

### **Transactions**

```
GET    /admin/transactions         - List transaksi
POST   /admin/transactions         - Store transaksi
GET    /admin/transactions/{slug}  - Detail transaksi
PUT    /admin/transactions/{slug}  - Update transaksi
DELETE /admin/transactions/{slug}  - Delete transaksi
```

## 🧪 Testing

### **Manual Testing**

```bash
# Test login
1. Buka http://localhost:8000/admin/login
2. Login dengan: admin@example.com / password
3. Verifikasi redirect ke dashboard

# Test CRUD operations
1. Test tambah/edit/hapus admin
2. Test tambah/edit/hapus kategori
3. Test tambah/edit/hapus produk dengan gambar
4. Test transaksi stock in/out

# Test validations
1. Test form validation
2. Test stock validation untuk stock out
3. Test unique constraints
```

### **Unit Testing (Optional)**

```bash
# Jalankan test Laravel
php artisan test

# Test specific feature
php artisan test --filter=AdminTest
```

## 📦 Deployment

### **Shared Hosting**

```bash
1. Upload files ke public_html
2. Set DocumentRoot ke /public_html/public
3. Import database via phpMyAdmin
4. Set permission folder storage dan bootstrap/cache
5. Update .env dengan config production
```

### **VPS/Cloud Server**

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev

# Set production environment
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set file permissions
chmod -R 755 storage bootstrap/cache
```

### **Environment Production**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=your_production_host
DB_DATABASE=your_production_db
DB_USERNAME=your_production_user
DB_PASSWORD=your_production_password
```

## 🤝 Kontribusi

Kami welcome kontribusi dari developer lain! Berikut cara berkontribusi:

### **Development Workflow**

```bash
1. Fork repository ini
2. Buat branch feature: git checkout -b feature/AmazingFeature
3. Commit changes: git commit -m 'Add some AmazingFeature'
4. Push ke branch: git push origin feature/AmazingFeature
5. Buat Pull Request
```

### **Coding Standards**

-   Gunakan **PSR-12** coding standard
-   Tulis **comments** yang jelas
-   Buat **migrations** untuk perubahan database
-   Update **README** jika ada perubahan konfigurasi

### **Bug Reports**

Jika menemukan bug, silakan buat issue dengan informasi:

-   PHP version
-   Laravel version
-   Browser yang digunakan
-   Steps to reproduce
-   Expected vs actual behavior

## 📄 Lisensi

Project ini menggunakan **MIT License**. Silakan lihat file [LICENSE](LICENSE) untuk detail lengkap.

```
MIT License

Copyright (c) 2025 Stock Management System

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 📞 Kontak & Support

### **Developer**

-   **Email**: developer@example.com
-   **GitHub**: [@username](https://github.com/alifsuryadi)
-   **LinkedIn**: [Your LinkedIn](https://linkedin.com/in/alifsuryadi)

### **Support**

Jika membutuhkan bantuan:

1. **Dokumentasi**: Baca README ini dengan teliti
2. **Issues**: Buat issue di GitHub untuk bug reports
3. **Discussions**: Gunakan GitHub Discussions untuk pertanyaan umum
4. **Email**: Kontak developer untuk support khusus

---

## 🙏 Acknowledgments

Terima kasih kepada:

-   **Laravel Team** - Framework PHP terbaik
-   **Bootstrap Team** - CSS framework yang powerful
-   **FontAwesome** - Icon library yang lengkap
-   **Contributors** - Semua yang berkontribusi pada project ini

---

## 📊 Project Statistics

![GitHub last commit](https://img.shields.io/github/last-commit/alifsuryadi/stock-management)
![GitHub issues](https://img.shields.io/github/issues/alifsuryadi/stock-management)
![GitHub stars](https://img.shields.io/github/stars/alifsuryadi/stock-management)
![GitHub forks](https://img.shields.io/github/forks/alifsuryadi/stock-management)

**Stock Management System** - _Professional Inventory Solution for Modern Business_ 🚀

> Dibuat dengan ❤️ menggunakan Laravel & Bootstrap
