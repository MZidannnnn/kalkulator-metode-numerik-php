<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Metode Secant</title>

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>✂️</text></svg>">

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
            --error-bg: #f8d7da;
            --error-border: #f5c6cb;
            --error-text: #721c24;
            --hover-bg: #f7f9fa;
            --btn-back-bg: #f1f3f5;
            --btn-back-hover: #e9ecef;
            --btn-back-text: #495057;
            --transition-speed: 0.4s;
        }
        html.dark-mode {
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
            --error-bg: #6a2c3a;
            --error-border: #8d3d4a;
            --error-text: #f8d7da;
            --hover-bg: #3b5269;
            --btn-back-bg: #2c3e50;
            --btn-back-hover: #4a6278;
            --btn-back-text: #ecf0f1;
        }

        * { box-sizing: border-box; transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease, border-color var(--transition-speed) ease; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--background-color); color: var(--text-color); margin: 0; padding: 2rem; }
        .container { max-width: 800px; margin: 20px auto; padding: 2.5rem; background-color: var(--card-background); border-radius: 16px; box-shadow: 0 10px 30px var(--shadow-color); position: relative; }
        h1, h2 { color: var(--heading-color); text-align: center; letter-spacing: -0.5px; }
        h1 { font-weight: 700; margin-bottom: 1rem; }
        h2 { font-weight: 600; margin-top: 2.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--primary-color); display: inline-block; padding-bottom: 0.5rem; }
        .result-section { text-align: center; }

        .theme-switcher-container { position: absolute; top: 20px; right: 20px; z-index: 100; }
        #theme-switcher { background: var(--card-background); border: 1px solid var(--border-color); color: var(--heading-color); width: 45px; height: 45px; border-radius: 50%; cursor: pointer; font-size: 1.5rem; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px var(--shadow-color); transition: transform 0.3s ease, background-color var(--transition-speed) ease; }
        #theme-switcher:hover { transform: scale(1.1); }
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

        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.95rem;  }
        th, td { padding: 14px; text-align: center; border-bottom: 1px solid var(--border-color); word-wrap: break-word; }
        th { background-color: transparent; color: var(--heading-color); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.85rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: var(--hover-bg); }

        .result-box { margin-top: 1.5rem; padding: 1.25rem; border-radius: 8px; text-align: center; border-left: 5px solid; }
        .final-answer { background-color: var(--success-bg); border-color: var(--success-border); color: var(--success-text); font-size: 1.1em; font-weight: 600; }
        .error-message { background-color: var(--error-bg); border-color: var(--error-border); color: var(--error-text); }
        /* --- PERBAIKAN: CSS untuk Tampilan Responsif di Mobile --- */
@media (max-width: 768px) {
    body {
        padding: 1rem;
    }
    .container {
        padding: 1.5rem;
    }
    .form-grid-2-col {
        grid-template-columns: 1fr; /* Ubah menjadi 1 kolom di layar kecil */
    }
    h1 {
        font-size: 2rem;
    }
    .theme-switcher-container {
        top: 15px;
        right: 15px;
    }
    /* Membuat area tabel bisa di-scroll horizontal */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid var(--border-color);
        border-radius: 8px;
    }
    /* Menghapus margin atas dari tabel karena sudah diatur oleh wrapper */
    table {
        margin-top: 0; 
    }
}
    </style>

    <script>
        (function() {
            try {
                var theme = localStorage.getItem('theme');
                if (theme === 'dark-mode') {
                    document.documentElement.classList.add('dark-mode');
                }
            } catch (e) { }
        })();
    </script>
</head>
<body>

<div class="theme-switcher-container">
    <button id="theme-switcher" title="Ganti Mode">🌙</button>
</div>

<div class="container">
    <h1>Kalkulator Metode Secant</h1>

    <div class="back-to-home">
        <a href="index.php" class="btn-back">&larr; Kembali ke Menu Utama</a>
    </div>

    <form method="post">
        <div class="form-group" style="grid-column: 1 / -1;">
            <label for="fungsi">Fungsi f(x)</label>
            <input type="text" id="fungsi" name="fungsi" value="<?= htmlspecialchars($_POST['fungsi'] ?? 'x + exp(x)') ?>" required>
        </div>
        <div class="form-grid-2-col">
            <div class="form-group">
                <label for="x0">Tebakan Awal (x<sub>0</sub>)</label>
                <input type="text" id="x0" name="x0" value="<?= htmlspecialchars($_POST['x0'] ?? '0') ?>" required>
            </div>
            <div class="form-group">
                <label for="x1">Tebakan Awal (x<sub>1</sub>)</label>
                <input type="text" id="x1" name="x1" value="<?= htmlspecialchars($_POST['x1'] ?? '0.5') ?>" required>
            </div>
            <div class="form-group">
                <label for="toleransi">Toleransi Error (e)</label>
                <input type="text" id="toleransi" name="toleransi" value="<?= htmlspecialchars($_POST['toleransi'] ?? '0.0001') ?>" required>
            </div>
            <div class="form-group">
                <label for="max_iter">Iterasi Maksimum</label>
                <input type="number" id="max_iter" name="max_iter" value="<?= htmlspecialchars($_POST['max_iter'] ?? '50') ?>" required>
            </div>
        </div>
        <input type="submit" name="hitung" value="Hitung Akar">
    </form>

    <?php
    if (isset($_POST['hitung'])) {
        function sanitize_decimal($value) {
            return str_replace(',', '.', $value);
        }

        $str_fungsi = $_POST['fungsi'];
        $x0 = (float)sanitize_decimal($_POST['x0']);
        $x1 = (float)sanitize_decimal($_POST['x1']);
        $toleransi = (float)sanitize_decimal($_POST['toleransi']);
        $max_iter = (int)$_POST['max_iter'];
        $error_fungsi = false;

        $f = function ($x) use ($str_fungsi) {
            if (!is_numeric($x)) return NAN;
            try {
                $eval_str = preg_replace('/\bx\b/', "($x)", $str_fungsi);
                return @eval("return $eval_str;");
            } catch (Throwable $e) {
                return NAN;
            }
        };

        if (is_nan($f($x0))) {
            echo "<div class='result-box error-message'>Error: Fungsi f(x) tidak valid atau menghasilkan error.</div>";
            $error_fungsi = true;
        }

        if (!$error_fungsi) {
            echo "<div class='result-section'><h2>Hasil Perhitungan</h2>";
                echo "<div class='table-wrapper'>";

            echo "<table>
                    <tr>
                        <th>Iterasi</th>
                        <th>x<sub>i-1</sub></th>
                        <th>x<sub>i</sub></th>
                        <th>f(x<sub>i</sub>)</th>
                        <th>x<sub>i+1</sub></th>
                        <th>Galat Absolut</th>
                        <th>Keterangan</th>
                    </tr>";

            $iter = 1;
            $x_prev = $x0;
            $x_curr = $x1;
            $x_next = $x_curr;
            $keterangan = ""; 

            while ($iter <= $max_iter) {
                $fx_prev = $f($x_prev);
                $fx_curr = $f($x_curr);

                $denominator = ($fx_curr - $fx_prev);
                if ($denominator == 0) {
                    echo "<tr><td colspan='7' class='error-message'>Denominator bernilai nol. Metode dihentikan.</td></tr>";
                    $keterangan = "Error";
                    break;
                }

                $x_next = $x_curr - $fx_curr * ($x_curr - $x_prev) / $denominator;
                $err = abs($x_next - $x_curr);

                $keterangan = ($err <= $toleransi) ? "Berhenti" : "Lanjutkan";

                echo "<tr>";
                echo "<td>" . $iter . "</td>";
                printf("<td>%.5f</td>", $x_prev);
                printf("<td>%.5f</td>", $x_curr);
                printf("<td>%.5f</td>", $fx_curr);
                printf("<td>%.5f</td>", $x_next);
                printf("<td>%.5f</td>", $err);
                echo "<td>" . ucfirst($keterangan) . "</td>";
                echo "</tr>";
                
                if ($keterangan == "Berhenti") {
                    break;
                }

                $x_prev = $x_curr;
                $x_curr = $x_next;
                $iter++;
            }
            echo "</table>";
                echo "</div>";


            if ($keterangan == "Berhenti") {
                echo "<div class='result-box final-answer'>Kesimpulan Akar = <strong>" . number_format($x_next, 5) . "</strong></div>";
            } else if ($keterangan != "Error") {
                echo "<div class='result-box error-message'>Solusi tidak konvergen setelah $max_iter iterasi.</div>";
            }
        }
    }
    ?>
</div>

<script>
    const themeSwitcher = document.getElementById('theme-switcher');
    
    function setInitialIcon() {
        if (document.documentElement.classList.contains('dark-mode')) {
            themeSwitcher.innerHTML = '☀️';
        } else {
            themeSwitcher.innerHTML = '🌙';
        }
    }

    function switchTheme() {
        document.documentElement.classList.toggle('dark-mode');
        if (document.documentElement.classList.contains('dark-mode')) {
            themeSwitcher.innerHTML = '☀️';
            localStorage.setItem('theme', 'dark-mode');
        } else {
            themeSwitcher.innerHTML = '🌙';
            localStorage.setItem('theme', 'light');
        }
    }
    
    document.addEventListener('DOMContentLoaded', setInitialIcon);
    themeSwitcher.addEventListener('click', switchTheme);
</script>

</body>
</html>