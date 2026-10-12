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


## Cara Install

### 1. Clone repo
```bash
git clone https://github.com/USERNAME/contact-app.git
cd contact-app
