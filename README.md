# Seminar Participant Registration — MVC PHP 8 + MySQL

Aplikasi UTS Pemrograman Web sesuai instruksi: PHP 8, PDO, MVC tanpa framework, prepared statement, routing GET/POST sederhana, CRUD peserta, dan login session tanpa role.

## 1. Kebutuhan
- XAMPP dengan PHP 8 atau lebih baru
- MySQL/MariaDB
- Apache dengan `mod_rewrite` aktif

## 2. Instalasi
1. Ekstrak folder `NIM_Nama_UTS` ke `C:\xampp\htdocs\`.
2. Jalankan Apache dan MySQL dari XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin`.
4. Pilih menu **Import**, lalu impor file `database/db_seminar_registration.sql`.
5. Periksa `config/database.php`. Pengaturan bawaan XAMPP: host `localhost`, database `db_seminar_registration`, username `root`, password kosong.
6. Buka `http://localhost/NIM_Nama_UTS/public/`.

Jika folder proyek diganti namanya, sesuaikan URL. Jika Apache tidak mengaktifkan `.htaccess`, aktifkan `mod_rewrite` dan `AllowOverride All` pada konfigurasi Apache.

## 3. Login
- Username: `admin`
- Password: `admin123`

Password disimpan sebagai hash dan diverifikasi dengan `password_verify()`.

## 4. Fitur dan route
| Method | Route | Fungsi |
|---|---|---|
| GET | `/login` | Form login |
| POST | `/login` | Proses login |
| GET | `/logout` | Keluar dan menghapus session |
| GET | `/participants` | Daftar peserta |
| GET | `/participants/create` | Form tambah |
| POST | `/participants/store` | Simpan peserta |
| GET | `/participants/edit/{id}` | Form ubah peserta |
| POST | `/participants/update` | Perbarui peserta |
| POST | `/participants/delete` | Hapus peserta dengan konfirmasi |

Semua route `/participants` wajib login. Tidak ada sistem role.

## 5. Validasi
- Kode, nama, dan institusi wajib diisi.
- Email wajib diisi dan harus valid.
- Kategori hanya `GENERAL` atau `STUDENT`.
- Kode peserta unik; duplikasi ditampilkan sebagai pesan kesalahan.
- Nilai form tetap ditampilkan ketika validasi gagal.
- Seluruh query input menggunakan PDO prepared statement.

## 6. Skenario pengujian UTS
1. Login dengan `admin / admin123`.
2. Pastikan data awal `P001` (Dina) dan `P002` (Budi) tampil.
3. Tambah peserta: kode `P003`, nama `Sari`, email `sari@example.com`, institusi `University X`, kategori `GENERAL`.
4. Ubah institusi peserta `P003` menjadi `STT Mandala`.
5. Hapus peserta `P002`, lalu setujui konfirmasi.
6. Coba simpan email tidak valid, kode kosong, dan kategori di luar pilihan. Sistem harus menampilkan pesan validasi.
7. Logout. Coba buka `/participants` langsung; sistem harus mengarahkan ke login.

## 7. Struktur folder
```text
NIM_Nama_UTS/
├── app/
│   ├── controllers/       AuthController.php, ParticipantController.php
│   ├── core/              Database.php, Router.php, Controller.php
│   ├── models/            User.php, Participant.php
│   └── views/             auth/ dan participants/
├── config/                database.php
├── database/              db_seminar_registration.sql
├── public/                index.php, .htaccess, assets/style.css
└── README.md
```

## 8. Pengumpulan
Ganti nama folder menjadi `NIM_Nama_UTS` sesuai NIM dan nama sendiri sebelum dikumpulkan. Sertakan file SQL dan screenshot hasil login, daftar peserta, tambah, ubah, hapus, serta validasi.
