<?php
// File: api-wolfram.php

header('Content-Type: application/json');

// --- Pastikan AppID Anda sudah terisi di sini ---
$appID = '9GG7GV-PKL34PARA7'; // Ganti dengan AppID Anda yang benar

if ($appID === 'GANTI_DENGAN_APPID_ANDA') {
    echo json_encode(['error' => 'AppID Wolfram|Alpha belum diatur di file api-wolfram.php']);
    exit();
}

// Fungsi untuk membersihkan rumus Excel
function konversi_excel_ke_matematika($rumus) {
    if (empty($rumus)) return '';
    $rumus = ltrim(trim($rumus), '=');
    $rumus = strtolower($rumus);
    $rumus = preg_replace('/[a-zA-Z]+\d+/', 'x', $rumus);
    return $rumus;
}

// Ambil rumus yang dikirim dari JavaScript
$g_input_raw = $_GET['formula'] ?? '';

if (empty($g_input_raw)) {
    echo json_encode(['error' => 'Tidak ada rumus yang diterima.']);
    exit();
}

$g_input_cleaned = konversi_excel_ke_matematika($g_input_raw);

$query = "derivative of " . $g_input_cleaned;
$query_encoded = urlencode($query);
$apiUrl = "http://api.wolframalpha.com/v2/query?input={$query_encoded}&appid={$appID}&format=plaintext";

$response_xml = @file_get_contents($apiUrl);

if ($response_xml === FALSE) {
    echo json_encode(['error' => 'Gagal terhubung ke server Wolfram|Alpha.']);
    exit();
}

$xml = simplexml_load_string($response_xml);
$derivative = 'Tidak ditemukan dari Wolfram|Alpha';

if ($xml && isset($xml['success']) && $xml['success'] == 'true') {
    $found = false;
    foreach ($xml->pod as $pod) {
        if (isset($pod['title']) && (string)$pod['title'] == 'Derivative') {
            $full_response = (string)$pod->subpod->plaintext;
            
            // --- PERBAIKAN UTAMA: Ambil bagian kanan dari tanda '=' ---
            if (strpos($full_response, '=') !== false) {
                $parts = explode('=', $full_response);
                $derivative = trim(end($parts)); // Ambil bagian terakhir setelah di-split
            } else {
                $derivative = $full_response; // Fallback jika tidak ada '='
            }
            // --- AKHIR PERBAIKAN ---
            
            $found = true;
            break;
        }
    }
    if (!$found && isset($xml->pod[1]->subpod->plaintext)) {
         $derivative_full = (string)$xml->pod[1]->subpod->plaintext;
         if (strpos($derivative_full, '=') !== false) {
            $parts = explode('=', $derivative_full);
            $derivative = trim(end($parts));
        } else {
            $derivative = $derivative_full;
        }
    }

} else {
    $derivative = 'Wolfram|Alpha tidak dapat memproses rumus ini.';
}

// Kembalikan hasil yang sudah bersih dalam format JSON
echo json_encode(['derivative' => $derivative]);

?>