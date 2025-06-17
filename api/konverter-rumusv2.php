<?php
// --- Fungsi Konversi (tidak diubah) ---
function konversi_rumus_biasa($rumus) {
    if (empty($rumus)) return '';
    $rumus = preg_replace('/\bpi\b/i', 'pi()', $rumus);
    $rumus = preg_replace('/\be\b/i', 'exp(1)', $rumus);
    $rumus = preg_replace('/(\d)\s*([a-zA-Z\(])/', '$1 * $2', $rumus);
    $rumus = preg_replace('/(\))\s*([\da-zA-Z\(])/', '$1 * $2', $rumus);
    for ($i = 0; $i < 3; $i++) {
        $rumus = preg_replace('/(\([^\)]+\)|[a-zA-Z0-9_.]+)\s*\^\s*(\([^\)]+\)|-?[\d\.]+)/', 'pow($1, $2)', $rumus);
    }
    return trim($rumus);
}

function konversi_rumus_excel($rumus) {
    if (empty($rumus)) return '';
    $rumus = ltrim(trim($rumus), '=');
    $rumus = strtolower($rumus);
    $rumus = preg_replace('/[a-zA-Z]+\d+/', 'x', $rumus);
    return konversi_rumus_biasa($rumus);
}

function konversi_universal($rumus) {
    $rumus_trimmed = trim($rumus);
    if (str_starts_with($rumus_trimmed, '=') || preg_match('/[a-zA-Z]+\d+/', $rumus_trimmed)) {
        return konversi_rumus_excel($rumus);
    } else {
        return konversi_rumus_biasa($rumus);
    }
}

// Inisialisasi variabel
$input_f = ''; $output_f = '';
$input_f1 = ''; $output_f1 = '';
$input_f2 = ''; $output_f2 = '';
$input_g = ''; $output_g = '';
$input_g1 = ''; $output_g1 = '';
$show_results = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $show_results = true;
    
    $input_f = $_POST['f_input'] ?? '';
    $output_f = konversi_universal($input_f);

    $input_f1 = $_POST['f1_input'] ?? '';
    $output_f1 = konversi_universal($input_f1);

    $input_f2 = $_POST['f2_input'] ?? '';
    $output_f2 = konversi_universal($input_f2);
    
    $input_g = $_POST['g_input'] ?? '';
    $output_g = konversi_universal($input_g);
    
    $input_g1 = $_POST['g1_input'] ?? '';
    $output_g1 = konversi_universal($input_g1);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Persiapan Rumus</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🧪</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #16a085;
            --secondary-color: #1abc9c;
            --background-color: #ecf0f1;
            --card-background: #ffffff;
            --text-color: #555;
            --heading-color: #2c3e50;
            --border-color: #dce4e8;
            --shadow-color: rgba(44, 62, 80, 0.1);
            --transition-speed: 0.4s;
        }
        html.dark-mode {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --background-color: #2c3e50;
            --card-background: #34495e;
            --text-color: #bdc3c7;
            --heading-color: #ffffff;
            --border-color: #4a6278;
            --shadow-color: rgba(0, 0, 0, 0.2);
        }
        * { box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--background-color); color: var(--text-color); margin: 0; padding: 2rem; transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease; }
        .theme-switcher-container { position: absolute; top: 20px; right: 20px; z-index: 100; }
        #theme-switcher { background: var(--card-background); border: 1px solid var(--border-color); color: var(--heading-color); width: 45px; height: 45px; border-radius: 50%; cursor: pointer; font-size: 1.5rem; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px var(--shadow-color); transition: transform 0.3s ease, background-color var(--transition-speed) ease; }
        #theme-switcher:hover { transform: scale(1.1); }
        .container { max-width: 800px; margin: 20px auto; padding: 2.5rem; background-color: var(--card-background); border-radius: 16px; box-shadow: 0 10px 30px var(--shadow-color); position: relative; }
        h1, h2, h3 { color: var(--heading-color); text-align: center; letter-spacing: -0.5px; }
        h1 { font-weight: 700; margin-bottom: 0.5rem; }
        p.subtitle { text-align: center; margin-top:0; margin-bottom: 2.5rem; color: #7f8c8d; }
        html.dark-mode p.subtitle { color: #95a5a6; }
        h2 { font-weight: 600; margin-top: 2.5rem; margin-bottom: 1.5rem; }
        h3 { font-weight: 600; text-align: left; margin-top: 2rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--primary-color); }
        .back-to-home { margin-bottom: 2rem; }
        .btn-back { display: inline-block; padding: 10px 20px; background-color: var(--background-color); color: var(--text-color); text-decoration: none; border-radius: 50px; font-weight: 600; transition: all 0.3s ease; }
        .btn-back:hover { background-color: var(--border-color); }
        form { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        .form-group { position: relative; display: flex; flex-direction: column; text-align: left; margin-bottom: 1rem; }
        label { margin-bottom: 0.5rem; font-weight: 600; color: var(--heading-color); font-size: 0.9rem; }
        textarea { padding: 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1.1rem; font-family: 'Menlo', 'Consolas', monospace; background-color: var(--background-color); color: var(--text-color); min-height: 80px; resize: vertical; }
        textarea:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(22, 160, 133, 0.2); }
        textarea.output-box { background-color: var(--background-color); color: var(--primary-color); font-weight: 600; cursor: text; }
        input[type="submit"] { grid-column: 1 / -1; padding: 16px; background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1rem; font-weight: 600; transition: all 0.3s ease; }
        .results-container { margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; }
        .btn-auto-derive {
            position: absolute;
            bottom: 10px;
            right: 10px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        .btn-auto-derive:hover { opacity: 1; }
        .btn-auto-derive:disabled { background-color: #95a5a6; cursor: wait; }
    </style>
    
    <script>
        (function() { try { var theme = localStorage.getItem('theme'); if (theme === 'dark-mode') { document.documentElement.classList.add('dark-mode'); } } catch (e) { } })();
    </script>
</head>
<body>

<div class="theme-switcher-container">
    <button id="theme-switcher" title="Ganti Mode">🌙</button>
</div>

<div class="container">
    <h1>Pusat Persiapan Rumus</h1>
    <p class="subtitle">Masukkan rumus biasa atau rumus Excel, program akan otomatis mengonversinya.</p>

    <div class="back-to-home">
        <a href="index.php" class="btn-back">&larr; Kembali ke Menu Utama</a>
    </div>

    <form method="post">
        
        <h3>Untuk Semua Metode</h3>
        <div class="form-group">
            <label for="f_input">Rumus Utama f(x)</label>
            <textarea id="f_input" name="f_input" placeholder="Contoh: x^2 - 5x" required><?= htmlspecialchars($input_f) ?></textarea>
        </div>
        
        <h3>Untuk Metode Newton-Raphson</h3>
        <div class="form-group">
            <label for="f1_input">Turunan Pertama f'(x)</label>
            <textarea id="f1_input" name="f1_input" placeholder="Opsional"><?= htmlspecialchars($input_f1) ?></textarea>
        </div>
        <div class="form-group">
            <label for="f2_input">Turunan Kedua f''(x)</label>
            <textarea id="f2_input" name="f2_input" placeholder="Opsional"><?= htmlspecialchars($input_f2) ?></textarea>
        </div>

        <h3>Untuk Metode Iterasi Sederhana</h3>
        <div class="form-group">
            <label for="g_input">Bentuk Iterasi g(x)</label>
            <textarea id="g_input" name="g_input" placeholder="Contoh: sqrt(2x + 3)"><?= htmlspecialchars($input_g) ?></textarea>
        </div>
        <div class="form-group g-derivative-group">
            <label for="g1_input">Turunan g'(x)</label>
            <textarea id="g1_input" name="g1_input" placeholder="Isi manual atau hitung otomatis dari g(x) di atas"><?= htmlspecialchars($input_g1) ?></textarea>
            <button type="button" id="hitung-g-aksen" class="btn-auto-derive">Hitung g'(x) Otomatis</button>
        </div>
        
        <input type="submit" value="Konversi Semua Rumus">
    </form>
    
    <?php if ($show_results): ?>
    <div class="results-container">
        <h2>Hasil Konversi (Siap Copy-Paste)</h2>

        <?php if (!empty($output_f)): ?>
        <div class="form-group"><label>f(x) dalam format PHP:</label><textarea class="output-box" readonly><?= htmlspecialchars($output_f) ?></textarea></div>
        <?php endif; ?>

        <?php if (!empty($output_f1)): ?>
        <div class="form-group"><label>f'(x) dalam format PHP:</label><textarea class="output-box" readonly><?= htmlspecialchars($output_f1) ?></textarea></div>
        <?php endif; ?>

        <?php if (!empty($output_f2)): ?>
        <div class="form-group"><label>f''(x) dalam format PHP:</label><textarea class="output-box" readonly><?= htmlspecialchars($output_f2) ?></textarea></div>
        <?php endif; ?>

        <?php if (!empty($output_g)): ?>
        <div class="form-group"><label>g(x) dalam format PHP:</label><textarea class="output-box" readonly><?= htmlspecialchars($output_g) ?></textarea></div>
        <?php endif; ?>
        
        <?php if (!empty($output_g1)): ?>
        <div class="form-group"><label>g'(x) dalam format PHP:</label><textarea class="output-box" readonly><?= htmlspecialchars($output_g1) ?></textarea></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<script>
    const themeSwitcher = document.getElementById('theme-switcher');
    function setInitialIcon() { if (document.documentElement.classList.contains('dark-mode')) { themeSwitcher.innerHTML = '☀️'; } else { themeSwitcher.innerHTML = '🌙'; } }
    function switchTheme() { document.documentElement.classList.toggle('dark-mode'); if (document.documentElement.classList.contains('dark-mode')) { themeSwitcher.innerHTML = '☀️'; localStorage.setItem('theme', 'dark-mode'); } else { themeSwitcher.innerHTML = '🌙'; localStorage.setItem('theme', 'light'); } }
    document.addEventListener('DOMContentLoaded', setInitialIcon);
    themeSwitcher.addEventListener('click', switchTheme);

    const btnHitungG = document.getElementById('hitung-g-aksen');
    const gInput = document.getElementById('g_input');
    const g1Input = document.getElementById('g1_input');

    btnHitungG.addEventListener('click', function() {
        const formula = gInput.value;
        if (formula.trim() === '') {
            alert('Kolom g(x) harus diisi terlebih dahulu!');
            return;
        }

        btnHitungG.disabled = true;
        btnHitungG.textContent = 'Memproses...';
        g1Input.value = 'Menghubungi server Wolfram|Alpha...';

        fetch(`api-wolfram.php?formula=${encodeURIComponent(formula)}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    g1Input.value = `Error: ${data.error}`;
                } else {
                    g1Input.value = data.derivative;
                }
                btnHitungG.disabled = false;
                btnHitungG.textContent = "Hitung g'(x) Otomatis";
            })
            .catch(error => {
                g1Input.value = 'Gagal terhubung. Cek console (F12) untuk detail.';
                console.error('Error:', error);
                btnHitungG.disabled = false;
                btnHitungG.textContent = "Hitung g'(x) Otomatis";
            });
    });
</script>

</body>
</html>