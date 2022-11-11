<h1 align="center">Sistem Informasi Inventaris dan Peminjaman Barang Laboratorium ! 👋🏻</h1>


<h4 align="center">Website dibuat dengan <a href="https://laravel.com/" target="_blank">Laravel 8</a>.
</h4>

<h2 id="tentang">🎓 Tentang Website</h2>
Tujuan yang ingin dicapai dari pembuatan Tugas Akhir ini adalah membuat sistem informasi yang dapat digunakan Departemen Teknik Komputer untuk melakukan pendataan inventaris secara terkomputerisasi dan mempercepat proses peminjaman barang.

<p></p>

<h2 id="fitur">✨ Fitur Tersedia</h2>

- Landing Page dan Autentikasi
  - Halaman [homepage, tentang, fitur, kontak]
  - Autentikasi [daftar dan login]
- Fitur Pengelolaan Inventaris dan Data Peminjaman Barang
  - Tersedia daftar barang dengan QR-Code
  - Rekap peminjaman dan pengembalian barang
  - Rekap barang rusak
  - Pengembalian dengan Scan Qr-code
- Fitur Penunjang
  - Export dan Import Csv
  - Export Pdf
  - Input gambar
  - Generate QR-Code
  - Scanner QR-Code

<p></p>

<h2 id="demo">🏠 Halaman Demo</h2>

Halaman demo dapat anda akses di [https://silab18.herokuapp.com/]

<p></p>

<h2 id="download">🐱‍💻 Panduan Menjalankan & Install Aplikasi</h2>

Untuk menjalankan aplikasi atau web ini kamu harus install XAMPP atau web server lain dan mempunyai setidaknya satu web browser yang terinstall di komputer anda.

```bash
# Clone repository ini atau download di
$ git clone [https://github.com/aldysufri17/si_laboratorium.git]

# Kemudian jalankan command composer install, ini akan menginstall resources yang laravel butuhkan
$ composer install

# Lakukan copy .env dengan cara ketik command seperti dibawah 
$ cp .env.example .env

# Generate key juga jangan lupa dengan command dibawah
$ php artisan key:generate

# Jangan lupa migrate database dengan cara membuat database di phpmyadmin atau aplikasi lainnya yang kalian pakai,
# lalu jangan lupa untuk mengganti variable DB_DATABASE di file .env yang di folder project
$ php artisan migrate

# Lalu jalankan aplikasi kalian dengan command dibawah
$ php artisan serve

# Aplikasi berhasil dijalankan menggunakan server lokal!
```
<p></p>
