# Contact & Group Management

Aplikasi web sederhana untuk mencatat **Contact**, **No Telp**, dan **Group** dengan relasi many-to-many. Dibuat untuk uji technical test.

## Fitur

- ✅ CRUD Contact (Name + Title: Mr/Mrs/Ms)
- ✅ Multiple No Telp per contact (Mobile/Office/Fax/WhatsApp/Other)
- ✅ CRUD Group (Group Name + Priority: low/med/high)
- ✅ Assign 1 contact ke banyak group (matrix view)
- ✅ Laporan Query A–D:
  - A. Semua data contact + group
  - B. Contact dengan group priority HIGH
  - C. Contact yang belum masuk group
  - D. Group yang belum punya contact

## Tools yang digunakan

| Layer | Stack |
|---|---|
| Bahasa | PHP 8 (native, tanpa framework) |
| Database | MySQL / MariaDB |
| UI | Bootstrap 5 (CDN) + Bootstrap Icons |
| Server lokal | XAMPP |

## Struktur Folder

```text
contact-app/
│
├── index.php                 # Dashboard utama
│
├── config/
│   └── database.php          # Koneksi PDO
│
├── includes/
│   ├── header.php            # <head>, navbar, CSS
│   ├── footer.php            # Penutup HTML
│   └── helpers.php           # Fungsi bantu (redirect, flash)
│
├── contacts/
│   ├── index.php             # List contact + search
│   ├── create.php            # Form tambah contact
│   ├── edit.php              # Form edit contact
│   ├── save.php              # Proses simpan
│   └── delete.php            # Proses hapus
│
├── groups/
│   ├── index.php             # List group
│   ├── create.php            # Form tambah group
│   ├── edit.php              # Form edit group
│   ├── save.php              # Proses simpan
│   └── delete.php            # Proses hapus
│
├── assignments/
│   ├── index.php             # Matrix contact × group
│   ├── edit.php              # Assign 1 contact
│   └── save.php              # Proses simpan assign
│
├── reports/
│   └── index.php             # Laporan Query A–D
│
└── assets/
    └── css/
        └── style.css         # Custom CSS
```


## 🚀 Cara Install

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/contact-app.git
cd contact-app
```

### 2. Pindahkan ke `htdocs`

```bash
# Windows
move contact-app C:\xampp\htdocs\

# macOS / Linux
mv contact-app /Applications/XAMPP/htdocs/
```

### 3. Start XAMPP

Buka **XAMPP Control Panel** → klik **Start** pada **Apache** dan **MySQL**.

### 4. Buat Database

Buka **http://localhost/phpmyadmin** → klik **New** → buat database dengan nama `contactdb`.

Import file `database.sql` (ada di root project) lewat tab **Import**, atau copy-paste isinya ke tab **SQL**.

### 5. Konfigurasi Koneksi

Edit file `config/database.php`:

```php
$host = 'localhost';
$db   = 'contactdb';
$user = 'root';
$pass = '';          // default XAMPP: kosong
```

### 6. Jalankan Aplikasi

Buka browser:

```
http://localhost/contact-app/
```

---

## 📊 Data Contoh

Setelah import `database.sql`, akan tersedia data berikut:

| Title | Name | No Telp | Group |
|---|---|---|---|
| Mr | Muhammad Farhan | 0852-1069-8869, 021-555-0101 | Supplier, Internal QA |
| Ms | Siti Aminah | 0813-3333-4444 | Internal QA |
| Mr | John Lee | +65-8123-4567 | Supplier, Auditor |
| Mrs | Dewi Lestari | 0812-7777-8888 | — |

**Group:** Supplier (high), Customer (high), Internal QA (med), Logistics (low), Auditor (high), Dormant (low)

---

## 🧭 Navigasi Aplikasi

```text
Dashboard (index.php)
   │
   ├── Contacts ──► list ──► create/edit ──► save ──► balik ke list
   │                    └─► delete ──► balik ke list
   │
   ├── Groups  ──► list ──► create/edit ──► save ──► balik ke list
   │                    └─► delete ──► balik ke list
   │
   ├── Assignments ──► matrix ──► klik contact ──► edit ──► save
   │
   └── Reports ──► tab A / B / C / D
```

---
