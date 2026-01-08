# 📦 Inventory Management System

Backend menggunakan **Lumen (REST API)** dan Frontend menggunakan **Laravel 12**.

---

## 📁 Struktur Folder

```
inventory-api      → Backend (Lumen API)
inventory-web      → Frontend (Laravel 12)
```

---

## 🛠️ Requirements

Pastikan sudah terinstall:

* PHP >= 8.1
* Composer
* MySQL / MariaDB
* Git (opsional)

---

## 🗄️ Database Setup

Buat database baru dengan nama:

```
nuyy_db
```

---

## 🚀 Backend (Lumen API)

### 1️⃣ Masuk ke folder backend

```bash
cd backend_api
```

### 2️⃣ Install dependency

```bash
composer install
```

### 3️⃣ Copy file environment

```bash
cp .env.example .env
```

### 4️⃣ Konfigurasi database (`.env`)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nuyy_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Jalankan migration

```bash
php artisan migrate
```

### 6️⃣ Jalankan server API

```bash
php -S localhost:8000 -t public
```

📌 API akan berjalan di:

```
http://localhost:8000
```

---

## 🌐 Frontend (Laravel 12)

### 1️⃣ Masuk ke folder frontend

```bash
cd frontend_web
```

### 2️⃣ Install dependency

```bash
composer install
```

### 3️⃣ Copy file environment

```bash
cp .env.example .env
```

### 4️⃣ Generate application key

```bash
php artisan key:generate
```

### 5️⃣ Konfigurasi API URL (`.env`)

```env
API_URL=http://localhost:8000
```

### 6️⃣ Jalankan server frontend

```bash
php artisan serve --port=8001
```

📌 Aplikasi dapat diakses melalui:

```
http://localhost:8001
```

---

## ✨ Fitur Utama

* Manajemen Category (CRUD)
* Manajemen Product (CRUD)
* Frontend terhubung ke backend menggunakan REST API
* Validasi data di backend (API)

---

## 📌 Catatan

* Backend **tidak menggunakan Blade**, hanya REST API
* Frontend **tidak langsung mengakses database**
* Komunikasi data menggunakan HTTP Request

---

## 👨‍💻 Author

Nama: Davina AS \
Framework: Lumen & Laravel 12
