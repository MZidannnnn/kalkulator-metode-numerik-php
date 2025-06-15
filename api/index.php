<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Metode Numerik - Beranda</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏠</text></svg>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a69bd;
            --secondary-color: #6a89cc;
            --background-color: #f8f9fa;
            --card-background: #ffffff;
            --text-color: #343a40;
            --heading-color: #2c3e50;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --btn-back-bg: #f1f3f5;
            --btn-back-hover: #e9ecef;
            --btn-back-text: #495057;
            --transition-speed: 0.4s;
        }

        /* --- PERUBAHAN 1: Gunakan html.dark-mode agar class bisa diterapkan lebih awal --- */
        html.dark-mode {
            --primary-color: #5d8de9;
            --secondary-color: #7a9eeb;
            --background-color: #2c3e50;
            --card-background: #34495e;
            --text-color: #bdc3c7;
            --heading-color: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.2);
            --btn-back-bg: #2c3e50;
            --btn-back-hover: #4a6278;
            --btn-back-text: #ecf0f1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease;
        }
        
        .theme-switcher-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        #theme-switcher {
            background: var(--card-background);
            border: 1px solid var(--border-color);
            color: var(--heading-color);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px var(--shadow-color);
            transition: transform 0.3s ease, background-color var(--transition-speed) ease;
        }
        #theme-switcher:hover {
            transform: scale(1.1);
        }

        .container {
            max-width: 1000px;
            width: 100%;
            text-align: center;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .header p {
            font-size: 1.1rem;
            font-weight: 300;
            color: #7f8c8d;
            max-width: 600px;
            margin: 0 auto 3rem auto;
        }
        html.dark-mode .header p {
            color: #95a5a6;
        }

        .methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .method-card {
            background-color: var(--card-background);
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 4px 15px var(--shadow-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }

        .method-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px var(--shadow-color);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            filter: grayscale(30%);
            transition: filter 0.3s ease;
        }
        .method-card:hover .card-icon {
            filter: grayscale(0%);
        }

        .method-card h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.75rem 0;
            transition: color var(--transition-speed) ease;
        }

        .method-card p {
            font-size: 0.95rem;
            line-height: 1.6;
            flex-grow: 1;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(74, 105, 189, 0.4);
        }
        
        footer {
            margin-top: 4rem;
            font-size: 0.9rem;
            color: #95a5a6;
        }
        html.dark-mode footer {
            color: #7f8c8d;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header, .method-card {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        
        .method-card:nth-child(1) { animation-delay: 0.2s; }
        .method-card:nth-child(2) { animation-delay: 0.4s; }
        .method-card:nth-child(3) { animation-delay: 0.6s; }

    </style>
    
    <script>
        // Skrip ini berjalan secepat mungkin untuk mencegah kedipan tema
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
    <header class="header">
        <h1>Kalkulator Metode Numerik</h1>
        <p>Pilih salah satu metode di bawah ini untuk memulai perhitungan dan menemukan akar persamaan dengan mudah dan akurat.</p>
    </header>

    <main>
        <div class="methods-grid">
            <a href="metode-newton.php" class="method-card">
                <div class="card-icon">📈</div>
                <h2>Newton-Raphson</h2>
                <p>Metode pencarian akar yang sangat cepat dan efisien dengan menggunakan pendekatan garis singgung (turunan pertama).</p>
                <div class="btn">Gunakan Kalkulator</div>
            </a>

            <a href="metode-secant.php" class="method-card">
                <div class="card-icon">✂️</div>
                <h2>Secant</h2>
                <p>Alternatif dari metode Newton-Raphson yang tidak memerlukan turunan fungsi. Cocok untuk fungsi yang rumit diturunkan.</p>
                <div class="btn">Gunakan Kalkulator</div>
            </a>

            <a href="metode-iterasi-sederhana.php" class="method-card">
                <div class="card-icon">🔄</div>
                <h2>Iterasi Sederhana</h2>
                <p>Metode yang mengubah persamaan f(x)=0 menjadi bentuk x=g(x) dan melakukan iterasi hingga menemukan titik tetap.</p>
                <div class="btn">Gunakan Kalkulator</div>
            </a>
        </div>
    </main>
    
    <footer>
        <p>Kalkulator Metode Numerik - &copy; <?= date('Y') ?></p>
    </footer>
</div>

<script>
    const themeSwitcher = document.getElementById('theme-switcher');
    const body = document.body; // body tidak lagi digunakan untuk class, tapi ok untuk referensi

    // Mengatur ikon tombol awal berdasarkan class yang sudah ada di <html>
    function setInitialIcon() {
        if (document.documentElement.classList.contains('dark-mode')) {
            themeSwitcher.innerHTML = '☀️';
        } else {
            themeSwitcher.innerHTML = '🌙';
        }
    }

    // Fungsi untuk mengganti tema saat tombol diklik
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