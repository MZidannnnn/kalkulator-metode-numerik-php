<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Metode Iterasi Sederhana</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🧮</text></svg>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --background-color: #ecf0f1;
            --card-background: #ffffff;
            --text-color: #555;
            --heading-color: #2c3e50;
            --border-color: #dce4e8;
            --shadow-color: rgba(44, 62, 80, 0.1);
            --success-bg: #d4edda;
            --success-border: #c3e6cb;
            --success-text: #155724;
            --info-bg: #d1ecf1;
            --info-border: #bee5eb;
            --info-text: #0c5460;
            --error-bg: #f8d7da;
            --error-border: #f5c6cb;
            --error-text: #721c24;
            --hover-bg: #f7f9fa;
            --btn-back-bg: #f1f3f5;
            --btn-back-hover: #e9ecef;
            --btn-back-text: #495057;
        }
        body.dark-mode {
            --primary-color: #4a90e2;
            --secondary-color: #3a7ac8;
            --background-color: #2c3e50;
            --card-background: #34495e;
            --text-color: #bdc3c7;
            --heading-color: #ffffff;
            --border-color: #4a6278;
            --shadow-color: rgba(0, 0, 0, 0.2);
            --success-bg: #2a5a3a;
            --success-border: #3c7d50;
            --success-text: #d4edda;
            --info-bg: #2c5a6d;
            --info-border: #3d7a8d;
            --info-text: #d1ecf1;
            --error-bg: #6a2c3a;
            --error-border: #8d3d4a;
            --error-text: #f8d7da;
            --hover-bg: #3b5269;
            --btn-back-bg: #2c3e50;
            --btn-back-hover: #4a6278;
            --btn-back-text: #ecf0f1;
        }
        * { box-sizing: border-box; transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--background-color); color: var(--text-color); margin: 0; padding: 2rem; }
        .theme-switcher-container { position: absolute; top: 20px; right: 20px; }
        #theme-switcher { background: var(--card-background); border: 1px solid var(--border-color); color: var(--heading-color); width: 45px; height: 45px; border-radius: 50%; cursor: pointer; font-size: 1.5rem; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px var(--shadow-color); transition: transform 0.3s ease, background-color 0.4s ease; }
        #theme-switcher:hover { transform: scale(1.1); }
        .container { max-width: 800px; margin: 20px auto; padding: 2.5rem; background-color: var(--card-background); border-radius: 16px; box-shadow: 0 10px 30px var(--shadow-color); position: relative; }
        h1, h2 { color: var(--heading-color); text-align: center; letter-spacing: -0.5px; }
        h1 { font-weight: 700; margin-bottom: 1rem; }
        h2 { font-weight: 600; margin-top: 2.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--primary-color); display: inline-block; padding-bottom: 0.5rem; }
        .result-section { text-align: center; }
        .back-to-home { margin-bottom: 2.5rem; }
        .btn-back { display: inline-block; padding: 10px 20px; background-color: var(--btn-back-bg); color: var(--btn-back-text); text-decoration: none; border-radius: 50px; font-weight: 600; }
        .btn-back:hover { background-color: var(--btn-back-hover); transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        form { display: grid; grid-template-columns: 1fr; gap: 1.25rem; }
        .form-grid-2-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-group { display: flex; flex-direction: column; text-align: left; }
        label { margin-bottom: 0.5rem; font-weight: 600; color: var(--heading-color); font-size: 0.9rem; }
        input[type="text"], input[type="number"] { padding: 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1rem; font-family: 'Poppins', sans-serif; background-color: var(--background-color); color: var(--text-color); }
        input[type="text"]:focus, input[type="number"]:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2); }
        input[type="submit"] { padding: 16px; background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1rem; font-weight: 600; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3); }
        input[type="submit"]:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4); }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.95rem;
            /* --- PERBAIKAN --- */
            table-layout: fixed; /* Memaksa kolom memiliki lebar yang sama */
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            /* --- PERBAIKAN --- */
            word-wrap: break-word; /* Membungkus teks/angka yang sangat panjang */
        }

        th { background-color: transparent; color: var(--heading-color); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.85rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: var(--hover-bg); }
        .result-box { margin-top: 1.5rem; padding: 1.25rem; border-radius: 8px; text-align: center; border-left: 5px solid; }
        .final-answer { background-color: var(--success-bg); border-color: var(--success-border); color: var(--success-text); font-size: 1.1em; font-weight: 600; }
        .error-message { background-color: var(--error-bg); border-color: var(--error-border); color: var(--error-text); }
        .convergence-check { background-color: var(--info-bg); border-color: var(--info-border); color: var(--info-text); line-height: 1.6; }
    </style>
</head>
<body>

<div class="theme-switcher-container">
    <button id="theme-switcher" title="Ganti Mode">🌙</button>
</div>

<div class="container">
    <h1>Metode Iterasi Sederhana</h1>

    <div class="back-to-home">
        <a href="index.php" class="btn-back">&larr; Kembali ke Menu Utama</a>
    </div>

    <form method="post">
        <div class="form-group">
            <label for="fungsi_f">Fungsi f(x) (Untuk Cek Error)</label>
            <input type="text" id="fungsi_f" name="fungsi_f" value="<?= htmlspecialchars($_POST['fungsi_f'] ?? 'pow(x,2) - 2*x - 3') ?>" required>
        </div>
        <div class="form-group">
            <label for="fungsi_g">Fungsi Iterasi g(x) (Bentuk dari x = g(x))</label>
            <input type="text" id="fungsi_g" name="fungsi_g" value="<?= htmlspecialchars($_POST['fungsi_g'] ?? 'sqrt(2*x + 3)') ?>" required>
        </div>
        <div class="form-group">
            <label for="turunan_g">Turunan g'(x) (Untuk Uji Konvergensi)</label>
            <input type="text" id="turunan_g" name="turunan_g" value="<?= htmlspecialchars($_POST['turunan_g'] ?? '1/sqrt(2*x + 3)') ?>" required>
        </div>
        <div class="form-grid-2-col">
            <div class="form-group">
                <label for="x0">Tebakan Awal (x<sub>0</sub>)</label>
                <input type="text" id="x0" name="x0" value="<?= htmlspecialchars($_POST['x0'] ?? '4') ?>" required>
            </div>
            <div class="form-group">
                <label for="toleransi">Toleransi Error (e)</label>
                <input type="text" id="toleransi" name="toleransi" value="<?= htmlspecialchars($_POST['toleransi'] ?? '0.001') ?>" required>
            </div>
        </div>
        <div class="form-group">
             <label for="max_iter">Iterasi Maksimum</label>
            <input type="number" id="max_iter" name="max_iter" value="<?= htmlspecialchars($_POST['max_iter'] ?? '20') ?>" required>
        </div>
        <input type="submit" name="hitung" value="Hitung Akar">
    </form>
    
    <?php
    // KODE PHP TIDAK DIUBAH
    if (isset($_POST['hitung'])) {
        function sanitize_decimal($value) { return str_replace(',', '.', $value); }

        $str_f = $_POST['fungsi_f'];
        $str_g = $_POST['fungsi_g'];
        $str_g_turunan = $_POST['turunan_g'];
        $x0 = (float)sanitize_decimal($_POST['x0']);
        $toleransi = (float)sanitize_decimal($_POST['toleransi']);
        $max_iter = (int)$_POST['max_iter'];
        
        $f = function($x) use ($str_f) { try { return @eval("return ".preg_replace('/\bx\b/', "($x)", $str_f).";"); } catch (Throwable $e) { return NAN; } };
        $g = function($x) use ($str_g) { try { return @eval("return ".preg_replace('/\bx\b/', "($x)", $str_g).";"); } catch (Throwable $e) { return NAN; } };
        $g_turunan = function($x) use ($str_g_turunan) { try { return @eval("return ".preg_replace('/\bx\b/', "($x)", $str_g_turunan).";"); } catch (Throwable $e) { return NAN; } };

        if (is_nan($f($x0)) || is_nan($g($x0)) || is_nan($g_turunan($x0))) {
             echo "<div class='result-box error-message'>Error: Salah satu fungsi (f(x), g(x), atau g'(x)) tidak valid.</div>";
        } else {
            echo "<div class='result-section'><h2>Uji Konvergensi Awal</h2>";
            
            $g_aksen_x0 = $g_turunan($x0);
            $is_konvergen = false;

            if ($g_aksen_x0 > 0 && $g_aksen_x0 < 1) {
                $status_konvergen = "Konvergen Monoton";
                $is_konvergen = true;
            } elseif ($g_aksen_x0 < 0 && $g_aksen_x0 > -1) {
                $status_konvergen = "Konvergen Berisolasi";
                $is_konvergen = true;
            } elseif ($g_aksen_x0 > 1) {
                $status_konvergen = "Divergen Monoton";
            } elseif ($g_aksen_x0 < -1) {
                $status_konvergen = "Divergen Berisolasi";
            } elseif ($g_aksen_x0 == 0) {
                 $status_konvergen = "Konvergen (Sangat Cepat)";
                $is_konvergen = true;
            } else {
                $status_konvergen = "Syarat Batas (g'(x) = 1 atau -1), Konvergensi Tidak Terjamin";
            }

            $warna_status = $is_konvergen ? "var(--success-text)" : "var(--error-text)";

            echo "<div class='result-box convergence-check'>
                    Nilai Uji |g'(x₀)| = <strong>" . number_format(abs($g_aksen_x0), 5) . "</strong><br>
                    Status: <strong style='color: $warna_status;'>" . $status_konvergen . "</strong>
                  </div>";
            
            echo "<div class='result-section'><h2>Hasil Perhitungan Iterasi</h2>";
            echo "<table><tr><th>Iterasi</th><th>X</th><th>g(x)</th><th>f(x)</th><th>Keterangan</th></tr>";

            $iter = 1;
            $x_curr = $x0;
            $keterangan = "";
            $akar_final = $x_curr;

            while ($iter <= $max_iter) {
                $fx = $f($x_curr);
                $err = abs($fx);
                $gx = $g($x_curr);
                
                if ($is_konvergen) {
                    $keterangan = ($err < $toleransi) ? "Berhenti" : "Lanjutkan";
                } else {
                    $keterangan = "Lanjutkan (Divergen)";
                }

                // Untuk angka yang sangat besar, format ke notasi ilmiah
                $x_display = (abs($x_curr) > 1e6) ? sprintf('%.4e', $x_curr) : sprintf('%.6f', $x_curr);
                $gx_display = (abs($gx) > 1e6) ? sprintf('%.4e', $gx) : sprintf('%.6f', $gx);
                $fx_display = (abs($fx) > 1e6) ? sprintf('%.4e', $fx) : sprintf('%.6f', $fx);

                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $iter, $x_display, $gx_display, $fx_display, ucfirst($keterangan));
                
                if ($keterangan == "Berhenti" || is_nan($gx) || is_infinite($gx)) {
                    $akar_final = $x_curr;
                    break;
                }
                
                $x_curr = $gx;
                $iter++;
            }
            echo "</table>";

            if ($keterangan == "Berhenti") {
                echo "<div class='result-box final-answer'>Hasil = <strong>" . number_format($akar_final, 6) . "</strong></div>";
            } else if ($is_konvergen) {
                echo "<div class='result-box error-message'>Solusi tidak konvergen setelah $max_iter iterasi.</div>";
            } else {
                 echo "<div class='result-box error-message'>Iterasi dihentikan karena terdeteksi divergen dan nilai terus membesar.</div>";
            }
        }
    }
    ?>
</div>

<script>
    const themeSwitcher = document.getElementById('theme-switcher');
    const body = document.body;

    function applyInitialTheme() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            body.classList.add(savedTheme);
            themeSwitcher.innerHTML = (savedTheme === 'dark-mode') ? '☀️' : '🌙';
        } else {
            themeSwitcher.innerHTML = '🌙';
        }
    }

    function switchTheme() {
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            themeSwitcher.innerHTML = '☀️';
            localStorage.setItem('theme', 'dark-mode');
        } else {
            themeSwitcher.innerHTML = '🌙';
            localStorage.setItem('theme', 'light');
        }
    }
    
    document.addEventListener('DOMContentLoaded', applyInitialTheme);
    themeSwitcher.addEventListener('click', switchTheme);
</script>

</body>
</html>