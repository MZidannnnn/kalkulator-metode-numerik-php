# Kalkulator Metode Numerik Berbasis Web

![Kalkulator Metode Numerik](https://i.imgur.com/image_e8e952.png) Aplikasi web sederhana yang dibangun dengan PHP native untuk menghitung akar persamaan menggunakan tiga metode numerik populer. Proyek ini dibuat sebagai sarana pembelajaran dan implementasi algoritma metode numerik ke dalam antarmuka yang modern, interaktif, dan mudah digunakan.

## Fitur Utama ✨

* **Tiga Metode Perhitungan**:
    * **Metode Newton-Raphson**: Lengkap dengan uji konvergensi awal menggunakan turunan pertama dan kedua.
    * **Metode Secant**: Alternatif efisien yang tidak memerlukan fungsi turunan.
    * **Metode Iterasi Sederhana**: Dilengkapi dengan uji konvergensi `|g'(x)| < 1` untuk menentukan jenis konvergensi/divergensi.
* **Antarmuka Modern & Elegan**: Didesain agar nyaman dipandang dan mudah digunakan, dengan fokus pada pengalaman pengguna.
* **Mode Gelap & Terang 🌓**: Dilengkapi tombol untuk mengganti tema, di mana pilihan pengguna akan tersimpan otomatis di browser (`localStorage`).
* **Anti-Kedip (No-Flash)**: Implementasi *pre-emptive script* untuk mencegah efek kedipan saat memuat halaman dalam mode gelap.
* **Responsif**: Tampilan dapat menyesuaikan diri dengan baik di berbagai ukuran layar, dari desktop hingga mobile.
* **Validasi Input**: Mampu menangani input desimal dengan format koma (`,`) maupun titik (`.`).

## Teknologi yang Digunakan 🛠️

* **Frontend**: HTML5, CSS3 (termasuk CSS Variables untuk theming), dan JavaScript (untuk interaktivitas tema).
* **Backend**: PHP (untuk semua logika perhitungan dan pemrosesan).
* **Font**: [Poppins](https://fonts.google.com/specimen/Poppins) dari Google Fonts.

## Cara Menjalankan 🚀

1.  Pastikan Anda memiliki server web lokal seperti **XAMPP** atau **Laragon**.
2.  **Clone** atau **unduh** repositori ini.
    ```bash
    git clone [https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git](https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git)
    ```
3.  Letakkan folder proyek ke dalam direktori root server web Anda (`htdocs` untuk XAMPP, `www` untuk Laragon).
4.  Jalankan layanan **Apache** dari panel kontrol server Anda.
5.  Buka browser dan akses alamat: `http://localhost/nama-folder-proyek/`

## Struktur Proyek 🗂️

* `index.php`: Halaman menu utama yang elegan dengan navigasi ke setiap metode.
* `metode-newton.php`: Kalkulator untuk metode Newton-Raphson.
* `metode-secant.php`: Kalkulator untuk metode Secant.
* `metode-iterasi-sederhana.php`: Kalkulator untuk metode Iterasi Sederhana.


### Deployment Attempt
---