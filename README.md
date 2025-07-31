# 🌱 Greenvana — Laravel E-Commerce Project

Ini adalah proyek e-commerce berbasis Laravel yang dirancang untuk kebutuhan bisnis online. Panduan ini menjelaskan langkah-langkah awal hingga menjalankan proyek di komputer lokal.

> Laravel menggunakan versi **8.x**

---

## 📂 1. Clone atau Download Project

Pastikan kamu sudah memiliki folder project ini. Jika dari GitHub:

```bash
git clone https://github.com/gradinggroup/greenvana.git
cd greenvana
```

---

## ⚙️ 2. Persiapan Sistem

Pastikan kamu telah menginstal komponen berikut:

| Komponen      | Versi Terpakai | Link Download                                              |
| ------------- | -------------- | ---------------------------------------------------------- |
| PHP           | 7.4 s.d 8.0    | [Download PHP](https://windows.php.net/download/)          |
| Composer      | Terbaru        | [Download Composer](https://getcomposer.org/download/)     |
| Node.js & NPM | Node 16/18     | [Download Node.js](https://nodejs.org/)                    |
| XAMPP         | 7.4.30         | [Download XAMPP](https://www.apachefriends.org/index.html) |

---

## 🛠️ 3. Konfigurasi Project dan Database

1. Install dependency:

```bash
composer install
npm install
```

2. Atur file `.env` sesuai database lokal kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=greenvana
DB_USERNAME=root
DB_PASSWORD=
```

3. Import database `greenvana.sql` yang ada di folder:

```plaintext
/database/greenvana.sql
```

Gunakan phpMyAdmin atau tool database lainnya.

---

## 🚀 4. Menjalankan Project

1. Bersihkan cache, config, dan view:

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

2. Jalankan server frontend:

```bash
npm run dev
```

3. Jalankan server Laravel:

```bash
php artisan serve
```

Project by **Grading Group Company**
