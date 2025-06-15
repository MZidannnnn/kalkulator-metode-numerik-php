<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Metode Newton-Raphson</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📈</text></svg>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- Variabel Warna untuk Light & Dark Mode --- */
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

        /* --- Style Dasar & Helper --- */
        * { box-sizing: border-box; transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--background-color); color: var(--text-color); margin: 0; padding: 2rem; }
        .container { max-width: 800px; margin: 20px auto; padding: 2.5rem; background-color: var(--card-background); border-radius: 16px; box-shadow: 0 10px 30px var(--shadow-color); position: relative; }
        h1, h2 { color: var(--heading-color); text-align: center; letter-spacing: -0.5px; }
        h1 { font-weight: 700; margin-bottom: 1rem; }
        h2 { font-weight: 600; margin-top: 2.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--primary-color); display: inline-block; padding-bottom: 0.5rem; }
        .result-section { text-align: center; }

        /* --- Tombol Ganti Tema & Tombol Kembali --- */
        .theme-switcher-container { position: absolute; top: 20px; right: 20px; }
        #theme-switcher { background: var(--card-background); border: 1px solid var(--border-color); color: var(--heading-color); width: 45px; height: 45px; border-radius: 50%; cursor: pointer; font-size: 1.5rem; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px var(--shadow-color); transition: transform 0.3s ease, background-color 0.4s ease; }
        #theme-switcher:hover { transform: scale(1.1); }
        .back-to-home { margin-bottom: 2.5rem; }
        .btn-back { display: inline-block; padding: 10px 20px; background-color: var(--btn-back-bg); color: var(--btn-back-text); text-decoration: none; border-radius: 50px; font-weight: 600; }
        .btn-back:hover { background-color: var(--btn-back-hover); transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

        /* --- Form --- */
        form { display: grid; grid-template-columns: 1fr; gap: 1.25rem; }
        .form-grid-2-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-group { display: flex; flex-direction: column; text-align: left; }
        label { margin-bottom: 0.5rem; font-weight: 600; color: var(--heading-color); font-size: 0.9rem; }
        input[type="text"], input[type="number"] { padding: 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1rem; font-family: 'Poppins', sans-serif; background-color: var(--background-color); color: var(--text-color); }
        input[type="text"]:focus, input[type="number"]:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2); }
        input[type="submit"] { padding: 16px; background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1rem; font-weight: 600; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3); }
        input[type="submit"]:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4); }

        /* --- Tabel --- */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.95rem; }
        th, td { padding: 14px; text-align: center; border-bottom: 1px solid var(--border-color); }
        th { background-color: transparent; color: var(--heading-color); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.85rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: var(--hover-bg); }

        /* --- Kotak Hasil --- */
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
    <h1>Metode Newton-Raphson</h1>

    <div class="back-to-home">
        <a href="index.php" class="btn-back">&larr; Kembali ke Menu Utama</a>
    </div>

    <form method="post">
        <div class="form-group">
            <label for="fungsi">Fungsi f(x)</label>
            <input type="text" id="fungsi" name="fungsi" value="<?= htmlspecialchars($_POST['fungsi'] ?? 'pow(x,2) - 5*x + 6') ?>" required>
        </div>
        <div class="form-group">
            <label for="turunan">Turunan f'(x)</label>
            <input type="text" id="turunan" name="turunan" value="<?= htmlspecialchars($_POST['turunan'] ?? '2*x - 5') ?>" required>
        </div>
        <div class="form-group">
            <label for="turunan_kedua">Turunan Kedua f''(x) (Untuk Uji Konvergensi)</label>
            <input type="text" id="turunan_kedua" name="turunan_kedua" value="<?= htmlspecialchars($_POST['turunan_kedua'] ?? '2') ?>" required>
        </div>
        <div class="form-grid-2-col">
            <div class="form-group">
                <label for="x0">Tebakan Awal (x)</label>
                <input type="text" id="x0" name="x0" value="<?= htmlspecialchars($_POST['x0'] ?? '0') ?>" required>
            </div>
            <div class="form-group">
                <label for="toleransi">Toleransi Error (e)</label>
                <input type="text" id="toleransi" name="toleransi" value="<?= htmlspecialchars($_POST['toleransi'] ?? '0.02') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="max_iter">Iterasi Maksimum</label>
            <input type="number" id="max_iter" name="max_iter" value="<?= htmlspecialchars($_POST['max_iter'] ?? '50') ?>" required>
        </div>
        <input type="submit" name="hitung" value="Hitung Akar">
    </form>

    <?php
    // --- BLOK PHP TIDAK DIUBAH SAMA SEKALI, HANYA DISALIN DARI VERSI SEBELUMNYA ---
    if (isset($_POST['hitung'])) {
        function sanitize_decimal($value) { return str_replace(',', '.', $value); }

        $str_fungsi = $_POST['fungsi'];
        $str_turunan = $_POST['turunan'];
        $str_turunan_kedua = $_POST['turunan_kedua'];
        $x0 = (float)sanitize_decimal($_POST['x0']);
        $toleransi = (float)sanitize_decimal($_POST['toleransi']);
        $max_iter = (int)$_POST['max_iter'];
        
        $f = function($x) use ($str_fungsi) { try { return @eval("return ".preg_replace('/\bx\b/', "($x)", $str_fungsi).";"); } catch (Throwable $e) { return NAN; } };
        $f_turunan = function($x) use ($str_turunan) { try { return @eval("return ".preg_replace('/\bx\b/', "($x)", $str_turunan).";"); } catch (Throwable $e) { return NAN; } };
        $f_turunan_kedua = function($x) use ($str_turunan_kedua) { try { return @eval("return ".preg_replace('/\bx\b/', "($x)", $str_turunan_kedua).";"); } catch (Throwable $e) { return NAN; } };

        if (is_nan($f($x0)) || is_nan($f_turunan($x0)) || is_nan($f_turunan_kedua($x0))) {
             echo "<div class='result-box error-message'>Error: Salah satu fungsi (f(x), f'(x), atau f''(x)) tidak valid.</div>";
        } else {
            echo "<div class='result-section'><h2>Uji Konvergensi Awal</h2>";
            
            $fx0 = $f($x0);
            $f_aksen_x0 = $f_turunan($x0);
            $f_double_aksen_x0 = $f_turunan_kedua($x0);
            $konvergensi_val = NAN;
            $is_konvergen = false;

            if ($f_aksen_x0 != 0) {
                $konvergensi_val = ($fx0 * $f_double_aksen_x0) / pow($f_aksen_x0, 2);
                if (abs($konvergensi_val) < 1) {
                    $is_konvergen = true;
                }
            }
            
            $status_konvergen = $is_konvergen ? "Konvergen" : "Tidak Konvergen, Coba tebakan awal lain";
            $warna_status = $is_konvergen ? "var(--success-text)" : "var(--error-text)";

            echo "<div class='result-box convergence-check'>
                    Nilai Uji Konvergensi |g'(x₀)| = <strong>" . number_format(abs($konvergensi_val), 4) . "</strong><br>
                    Status: <strong style='color: $warna_status;'>" . $status_konvergen . "</strong>
                  </div>";

            if ($is_konvergen) {
                echo "<div class='result-section'><h2>Hasil Perhitungan Iterasi</h2>";
                echo "<table><tr><th>iterasi</th><th>x(old)</th><th>f(x)</th><th>f'(x)</th><th>x(new)</th><th>galat/error</th><th>keterangan</th></tr>";

                $iter = 1;
                $x_old = $x0;
                $keterangan = "";
                $x_new = $x_old;

                while ($iter <= $max_iter) {
                    $fx = $f($x_old);
                    $f_aksen_x = $f_turunan($x_old);
                    $err = abs($fx);

                    if ($f_aksen_x == 0) {
                        echo "<tr><td colspan='7' class='error-message'>Turunan f'(x) bernilai nol. Metode dihentikan.</td></tr>";
                        $keterangan = "Error";
                        break;
                    }

                    $x_new = $x_old - ($fx / $f_aksen_x);
                    $keterangan = ($err <= $toleransi) ? "Berhenti" : "Lanjutkan";

                    echo "<tr><td>".$iter."</td>";
                    printf("<td>%.4f</td><td>%.4f</td><td>%.4f</td><td>%.4f</td><td>%.4f</td>", $x_old, $fx, $f_aksen_x, $x_new, $err);
                    echo "<td>".ucfirst($keterangan)."</td></tr>";

                    if ($keterangan == "Berhenti") break;
                    
                    $x_old = $x_new;
                    $iter++;
                }
                echo "</table>";

                if ($keterangan == "Berhenti") {
                    echo "<div class='result-box final-answer'>Kesimpulan: Akar dari fungsi f(x) adalah = <strong>" . number_format($x_new, 4) . "</strong></div>";
                } else if ($keterangan != "Error") {
                    echo "<div class='result-box error-message'>Solusi tidak konvergen setelah $max_iter iterasi.</div>";
                }
            }
        }
    }
    ?>
</div>

<script>
    const themeSwitcher = document.getElementById('theme-switcher');
    const body = document.body;

    // Fungsi untuk menerapkan tema saat halaman dimuat
    function applyInitialTheme() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            body.classList.add(savedTheme);
            if (savedTheme === 'dark-mode') {
                themeSwitcher.innerHTML = '☀️';
            } else {
                themeSwitcher.innerHTML = '🌙';
            }
        } else {
            // Default ke tema terang jika tidak ada yang tersimpan
            themeSwitcher.innerHTML = '🌙';
        }
    }

    // Fungsi untuk mengganti tema
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
    
    // Panggil fungsi saat halaman dimuat dan saat tombol diklik
    document.addEventListener('DOMContentLoaded', applyInitialTheme);
    themeSwitcher.addEventListener('click', switchTheme);
</script>

</body>
</html>