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

## Teknologi

| Layer | Stack |
|---|---|
| Bahasa | PHP 8 (native, tanpa framework) |
| Database | MySQL / MariaDB |
| UI | Bootstrap 5 (CDN) + Bootstrap Icons |
| Server lokal | XAMPP |

## Struktur Folder
contact-app/
├── index.php # Dashboard
├── config/ # Koneksi database
├── includes/ # Header, footer, helpers
├── contacts/ # Modul contact
├── groups/ # Modul group
├── assignments/ # Modul assign
├── reports/ # Modul laporan
└── assets/css/ # Custom CSS


## Cara Install

### 1. Clone repo
```bash
git clone https://github.com/USERNAME/contact-app.git
cd contact-app