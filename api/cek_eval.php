<?php
// Setel zona waktu untuk menghindari error terkait zona waktu
date_default_timezone_set('Asia/Makassar');

echo "<h1>Pengecekan Konfigurasi Server PHP</h1>";
echo "<p>Waktu Pengecekan: " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Cek apakah 'eval' ada di dalam daftar fungsi yang dinonaktifkan
$disabled_functions = ini_get('disable_functions');
$is_eval_disabled = false;

// eval adalah konstruksi bahasa, jadi function_exists tidak selalu bisa diandalkan.
// Cara paling pasti adalah mengecek 'disable_functions' di php.ini.
if ($disabled_functions) {
    // Ubah daftar string menjadi array
    $disabled_array = array_map('trim', explode(',', $disabled_functions));
    if (in_array('eval', $disabled_array)) {
        $is_eval_disabled = true;
    }
}

echo "<h2>Status Fungsi eval():</h2>";

if ($is_eval_disabled) {
    echo '<p style="font-size: 20px; color: red; font-weight: bold;">
              Fungsi eval() NONAKTIF (Dinonaktifkan)
          </p>';
    echo '<p>Ini adalah penyebab error "Fungsi f(x) tidak valid" pada kalkulator Anda. Silakan ikuti instruksi untuk mengaktifkannya.</p>';
} else {
    echo '<p style="font-size: 20px; color: green; font-weight: bold;">
              Fungsi eval() AKTIF
          </p>';
    echo '<p>Jika eval() aktif tetapi Anda masih mendapat error, masalahnya mungkin ada pada caching atau hal lain. Coba bersihkan cache browser (Ctrl + F5) atau restart server Anda.</p>';
}

echo "<hr>";
echo "<h3>Informasi Tambahan:</h3>";
echo "<strong>Versi PHP:</strong> " . phpversion() . "<br>";
echo "<strong>Daftar disable_functions:</strong> " . ($disabled_functions ? $disabled_functions : 'Tidak ada') . "<br>";

?>