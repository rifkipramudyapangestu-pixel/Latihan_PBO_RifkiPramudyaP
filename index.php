<?php
/**
 * ============================================================================
 * INDEX.PHP - Komponen Antarmuka (View)
 * ============================================================================
 * 
 * File ini bertindak sebagai halaman utama (View) yang menampilkan data tiket
 * bioskop secara dinamis dari database. Di sini diimplementasikan konsep:
 * 
 * 1. POLIMORFISME: Satu variabel ($tiket) dapat merujuk ke objek dari class
 *    yang berbeda-beda (TiketReguler / TiketImax / TiketVelvet), dan ketika
 *    method yang sama dipanggil (hitungTotalHarga(), tampilkanInformasiFasilitas()),
 *    hasilnya berbeda-beda sesuai implementasi masing-masing class anak.
 * 
 * 2. ABSTRAKSI & ENKAPSULASI: Data hanya bisa diakses melalui method publik
 *    yang telah didefinisikan, bukan langsung ke properti internal objek.
 * ============================================================================
 */

// ============================================================================
// SECTION 1: REQUIRE SEMUA FILE CLASS DAN KONEKSI
// ============================================================================
require_once __DIR__ . '/koneksi/database.php';
require_once __DIR__ . '/TiketReguler.php';
require_once __DIR__ . '/TiketImax.php';
require_once __DIR__ . '/TiketVelvet.php';

// ============================================================================
// SECTION 2: KONEKSI DATABASE & FETCH DATA
// ============================================================================

// Membuat objek dari class Database (Enkapsulasi koneksi di dalam class)
$database = new Database();
$conn = $database->getConnection();

// Array penampung objek tiket, dikelompokkan berdasarkan jenis studio
$tiketReguler = [];
$tiketImax    = [];
$tiketVelvet  = [];

try {
    // Query mengambil seluruh data dari tabel_tiket, diurutkan berdasarkan jadwal tayang
    $query = "SELECT * FROM tabel_tiket ORDER BY jadwal_tayang ASC";
    $stmt  = $conn->prepare($query);
    $stmt->execute();

    /**
     * ====================================================================
     * POLIMORFISME - Instansiasi Objek Berdasarkan Jenis Studio
     * ====================================================================
     * Di sinilah inti dari Polimorfisme terjadi.
     * Berdasarkan nilai kolom 'jenis_studio' dari database, kita membuat
     * objek dari class anak yang BERBEDA (TiketReguler, TiketImax, TiketVelvet).
     * 
     * Meskipun ketiga class ini adalah turunan dari abstract class Tiket,
     * masing-masing memiliki implementasi method yang BERBEDA
     * (hitungTotalHarga() dan tampilkanInformasiFasilitas()).
     * ====================================================================
     */
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        switch ($row['jenis_studio']) {

            case 'Reguler':
                // Instansiasi TiketReguler dengan atribut spesifik: tipeAudio & lokasiBaris
                $tiket = new TiketReguler(
                    $row['id_tiket'],
                    $row['nama_film'],
                    $row['jadwal_tayang'],
                    $row['jumlah_kursi'],
                    $row['harga_dasar_tiket'],
                    $row['tipe_audio'],       // Properti tambahan TiketReguler
                    $row['lokasi_baris']       // Properti tambahan TiketReguler
                );
                $tiketReguler[] = $tiket;
                break;

            case 'IMAX':
                // Instansiasi TiketImax dengan atribut spesifik: kacamata3DId & efekGerakFitur
                $tiket = new TiketImax(
                    $row['id_tiket'],
                    $row['nama_film'],
                    $row['jadwal_tayang'],
                    $row['jumlah_kursi'],
                    $row['harga_dasar_tiket'],
                    $row['kacamata_3D_id'],    // Properti tambahan TiketImax
                    $row['efek_gerak_fitur']   // Properti tambahan TiketImax
                );
                $tiketImax[] = $tiket;
                break;

            case 'Velvet':
                // Instansiasi TiketVelvet dengan atribut spesifik: bantalSelimutPack & layananButler
                $tiket = new TiketVelvet(
                    $row['id_tiket'],
                    $row['nama_film'],
                    $row['jadwal_tayang'],
                    $row['jumlah_kursi'],
                    $row['harga_dasar_tiket'],
                    $row['bantal_selimut_pack'], // Properti tambahan TiketVelvet
                    $row['layanan_butler']        // Properti tambahan TiketVelvet
                );
                $tiketVelvet[] = $tiket;
                break;
        }
    }
} catch (PDOException $e) {
    echo "Error mengambil data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Tiket Bioskop - Latihan PBO TRPL1A Rifki Pramudya Pangestu">
    <title>Sistem Tiket Bioskop | Latihan PBO - Rifki Pramudya P.</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter untuk tipografi modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Konfigurasi Tailwind Custom -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* ============================================================
         * Custom CSS untuk animasi dan efek visual tambahan
         * ============================================================ */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animasi fade-in saat halaman dimuat */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Stagger animation delay untuk tiap card */
        .card-delay-1 { animation-delay: 0.1s; }
        .card-delay-2 { animation-delay: 0.2s; }
        .card-delay-3 { animation-delay: 0.3s; }
        .card-delay-4 { animation-delay: 0.4s; }
        .card-delay-5 { animation-delay: 0.5s; }

        /* Efek hover pada card */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Tab active state */
        .tab-btn {
            transition: all 0.3s ease;
            position: relative;
        }
        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 60%;
            height: 3px;
            border-radius: 3px;
            transition: transform 0.3s ease;
        }
        .tab-btn.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }

        /* Badge pulse animation */
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .badge-pulse {
            animation: pulse-subtle 2s ease-in-out infinite;
        }

        /* Konten tab: transisi tampil/sembunyi */
        .tab-content { 
            display: none; 
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .tab-content.active { 
            display: block; 
            opacity: 1;
        }

        /* Tampilan informasi fasilitas (pre-formatted text) */
        .fasilitas-box {
            font-family: 'Courier New', monospace;
            font-size: 0.7rem;
            line-height: 1.4;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>

<body class="bg-slate-950 text-white min-h-screen">

    <!-- ================================================================
         HEADER / HERO SECTION
         ================================================================ -->
    <header class="relative overflow-hidden">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950"></div>
        <!-- Decorative circles -->
        <div class="absolute top-[-80px] right-[-80px] w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-40px] left-[-60px] w-48 h-48 bg-purple-500/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-6 py-14 text-center">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
                Latihan PBO — TRPL 1A
            </p>
            <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-white via-indigo-200 to-purple-300 bg-clip-text text-transparent leading-tight">
                🎬 Sistem Informasi Tiket Bioskop
            </h1>
            <p class="mt-4 text-slate-400 text-base max-w-2xl mx-auto">
                Implementasi konsep <span class="text-indigo-300 font-medium">Abstraksi</span>, 
                <span class="text-purple-300 font-medium">Enkapsulasi</span>, 
                <span class="text-sky-300 font-medium">Pewarisan (Inheritance)</span>, dan 
                <span class="text-emerald-300 font-medium">Polimorfisme</span> 
                menggunakan PHP OOP &mdash; Rifki Pramudya Pangestu.
            </p>

            <!-- Statistik ringkas -->
            <div class="mt-8 flex justify-center gap-6 flex-wrap">
                <div class="bg-white/5 backdrop-blur border border-white/10 rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold text-indigo-400"><?= count($tiketReguler) ?></p>
                    <p class="text-xs text-slate-400 mt-1">Studio Reguler</p>
                </div>
                <div class="bg-white/5 backdrop-blur border border-white/10 rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold text-sky-400"><?= count($tiketImax) ?></p>
                    <p class="text-xs text-slate-400 mt-1">Studio IMAX</p>
                </div>
                <div class="bg-white/5 backdrop-blur border border-white/10 rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold text-amber-400"><?= count($tiketVelvet) ?></p>
                    <p class="text-xs text-slate-400 mt-1">Studio Velvet</p>
                </div>
            </div>
        </div>
    </header>

    <!-- ================================================================
         MAIN CONTENT - TAB LAYOUT
         ================================================================ -->
    <main class="max-w-7xl mx-auto px-6 py-10">

        <!-- ============================================================
             TAB NAVIGATION
             Pengguna dapat berpindah antar kategori studio
             ============================================================ -->
        <div class="flex justify-center mb-10">
            <div class="inline-flex bg-slate-900/80 backdrop-blur border border-slate-700/50 rounded-2xl p-1.5 gap-1">
                
                <button id="tab-reguler" onclick="switchTab('reguler')"
                    class="tab-btn active px-6 py-3 rounded-xl text-sm font-semibold 
                           bg-indigo-600 text-white shadow-lg shadow-indigo-500/25
                           after:bg-indigo-400">
                    🎥 Studio Reguler
                    <span class="ml-2 bg-white/20 text-xs px-2 py-0.5 rounded-full"><?= count($tiketReguler) ?></span>
                </button>

                <button id="tab-imax" onclick="switchTab('imax')"
                    class="tab-btn px-6 py-3 rounded-xl text-sm font-semibold 
                           text-slate-400 hover:text-white hover:bg-slate-800
                           after:bg-sky-400">
                    🌌 Studio IMAX
                    <span class="ml-2 bg-white/10 text-xs px-2 py-0.5 rounded-full"><?= count($tiketImax) ?></span>
                </button>

                <button id="tab-velvet" onclick="switchTab('velvet')"
                    class="tab-btn px-6 py-3 rounded-xl text-sm font-semibold 
                           text-slate-400 hover:text-white hover:bg-slate-800
                           after:bg-amber-400">
                    ✨ Studio Velvet
                    <span class="ml-2 bg-white/10 text-xs px-2 py-0.5 rounded-full"><?= count($tiketVelvet) ?></span>
                </button>
            </div>
        </div>

        <!-- ============================================================
             TAB CONTENT: STUDIO REGULER
             ============================================================ -->
        <div id="content-reguler" class="tab-content active">
            <!-- Section Header -->
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-white">🎥 Jadwal Studio Reguler</h2>
                <p class="text-slate-400 text-sm mt-1">Tarif standar murni — tanpa biaya tambahan fasilitas</p>
                <div class="mt-2 inline-block bg-indigo-500/10 border border-indigo-500/30 rounded-lg px-4 py-1.5">
                    <code class="text-indigo-300 text-xs font-mono">hitungTotalHarga() = jumlah_kursi × hargaDasarTiket</code>
                </div>
            </div>

            <!-- Grid Card Tiket Reguler -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
                /**
                 * POLIMORFISME: Meskipun $tiket bisa berisi objek dari class mana saja,
                 * di sini kita memanggil hitungTotalHarga() dan hasilnya akan mengikuti
                 * implementasi di class TiketReguler (jumlah_kursi * hargaDasarTiket).
                 */
                $index = 0;
                foreach ($tiketReguler as $tiket): 
                    $index++;
                    $delayClass = 'card-delay-' . min($index, 5);
                ?>
                <div class="card-hover animate-fade-in-up <?= $delayClass ?> opacity-0 
                            bg-gradient-to-br from-slate-800/80 to-slate-900/80 
                            backdrop-blur border border-slate-700/50 rounded-2xl overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 px-5 py-4 border-b border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <span class="bg-indigo-500/20 text-indigo-300 text-xs font-bold px-3 py-1 rounded-full border border-indigo-500/30">
                                REGULER
                            </span>
                            <span class="text-slate-500 text-xs font-mono">#TKT-<?= str_pad($tiket->getId(), 3, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <h3 class="text-lg font-bold text-white mt-3"><?= htmlspecialchars($tiket->getNamaFilm()) ?></h3>
                    </div>

                    <!-- Card Body -->
                    <div class="px-5 py-4 space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">📅 Jadwal</span>
                            <span class="text-slate-300"><?= date('d M Y, H:i', strtotime($tiket->getJadwalTayang())) ?> WIB</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">💺 Kursi</span>
                            <span class="text-slate-300"><?= $tiket->getJumlahKursi() ?> kursi</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">🔊 Audio</span>
                            <span class="text-indigo-300 font-medium"><?= htmlspecialchars($tiket->getTipeAudio()) ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">📍 Baris</span>
                            <span class="text-indigo-300 font-medium"><?= htmlspecialchars($tiket->getLokasiBaris()) ?></span>
                        </div>
                    </div>

                    <!-- Card Footer: Total Harga (Polimorfisme) -->
                    <div class="px-5 py-4 bg-slate-900/50 border-t border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 text-xs uppercase tracking-wider">Total Harga</span>
                            <!-- 
                                POLIMORFISME: Memanggil hitungTotalHarga() 
                                Implementasi dari class TiketReguler: jumlah_kursi * hargaDasarTiket 
                            -->
                            <span class="text-xl font-extrabold text-emerald-400">
                                Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.') ?>
                            </span>
                        </div>
                        <p class="text-slate-600 text-xs mt-1 text-right">Harga dasar: Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.') ?>/kursi</p>
                    </div>

                    <!-- Informasi Fasilitas (Polimorfisme) -->
                    <details class="group">
                        <summary class="px-5 py-3 text-xs text-indigo-400 cursor-pointer hover:text-indigo-300 
                                       border-t border-slate-700/30 flex items-center gap-2 select-none">
                            <span class="group-open:rotate-90 transition-transform text-[10px]">▶</span>
                            Lihat Detail Fasilitas (Polimorfisme Output)
                        </summary>
                        <div class="px-5 pb-4">
                            <!-- 
                                POLIMORFISME: Memanggil tampilkanInformasiFasilitas()
                                Output berbeda tergantung class mana yang memanggilnya
                            -->
                            <div class="bg-slate-950 border border-slate-700/30 rounded-lg p-3">
                                <pre class="fasilitas-box text-slate-400"><?= htmlspecialchars($tiket->tampilkanInformasiFasilitas()) ?></pre>
                            </div>
                        </div>
                    </details>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ============================================================
             TAB CONTENT: STUDIO IMAX
             ============================================================ -->
        <div id="content-imax" class="tab-content">
            <!-- Section Header -->
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-white">🌌 Jadwal Studio IMAX</h2>
                <p class="text-slate-400 text-sm mt-1">Teknologi proyeksi layar lebar — biaya tambahan flat Rp35.000</p>
                <div class="mt-2 inline-block bg-sky-500/10 border border-sky-500/30 rounded-lg px-4 py-1.5">
                    <code class="text-sky-300 text-xs font-mono">hitungTotalHarga() = (jumlah_kursi × hargaDasarTiket) + 35.000</code>
                </div>
            </div>

            <!-- Grid Card Tiket IMAX -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
                $index = 0;
                foreach ($tiketImax as $tiket): 
                    $index++;
                    $delayClass = 'card-delay-' . min($index, 5);
                ?>
                <div class="card-hover animate-fade-in-up <?= $delayClass ?> opacity-0 
                            bg-gradient-to-br from-slate-800/80 to-slate-900/80 
                            backdrop-blur border border-sky-500/20 rounded-2xl overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-sky-600/20 to-cyan-600/20 px-5 py-4 border-b border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <span class="bg-sky-500/20 text-sky-300 text-xs font-bold px-3 py-1 rounded-full border border-sky-500/30 badge-pulse">
                                IMAX
                            </span>
                            <span class="text-slate-500 text-xs font-mono">#TKT-<?= str_pad($tiket->getId(), 3, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <h3 class="text-lg font-bold text-white mt-3"><?= htmlspecialchars($tiket->getNamaFilm()) ?></h3>
                    </div>

                    <!-- Card Body -->
                    <div class="px-5 py-4 space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">📅 Jadwal</span>
                            <span class="text-slate-300"><?= date('d M Y, H:i', strtotime($tiket->getJadwalTayang())) ?> WIB</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">💺 Kursi</span>
                            <span class="text-slate-300"><?= $tiket->getJumlahKursi() ?> kursi</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">🥽 Kacamata 3D</span>
                            <span class="text-sky-300 font-medium"><?= htmlspecialchars($tiket->getKacamata3DId()) ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">🎢 Efek Gerak</span>
                            <span class="text-sky-300 font-medium"><?= htmlspecialchars($tiket->getEfekGerakFitur()) ?></span>
                        </div>
                    </div>

                    <!-- Card Footer: Total Harga (Polimorfisme) -->
                    <div class="px-5 py-4 bg-slate-900/50 border-t border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 text-xs uppercase tracking-wider">Total Harga</span>
                            <!-- 
                                POLIMORFISME: Memanggil hitungTotalHarga()
                                Implementasi dari class TiketImax: (jumlah_kursi * hargaDasarTiket) + 35000
                            -->
                            <span class="text-xl font-extrabold text-emerald-400">
                                Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.') ?>
                            </span>
                        </div>
                        <p class="text-slate-600 text-xs mt-1 text-right">
                            Harga dasar: Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.') ?>/kursi + Rp 35.000
                        </p>
                    </div>

                    <!-- Informasi Fasilitas (Polimorfisme) -->
                    <details class="group">
                        <summary class="px-5 py-3 text-xs text-sky-400 cursor-pointer hover:text-sky-300 
                                       border-t border-slate-700/30 flex items-center gap-2 select-none">
                            <span class="group-open:rotate-90 transition-transform text-[10px]">▶</span>
                            Lihat Detail Fasilitas (Polimorfisme Output)
                        </summary>
                        <div class="px-5 pb-4">
                            <!-- POLIMORFISME: Output tampilkanInformasiFasilitas() dari TiketImax -->
                            <div class="bg-slate-950 border border-slate-700/30 rounded-lg p-3">
                                <pre class="fasilitas-box text-slate-400"><?= htmlspecialchars($tiket->tampilkanInformasiFasilitas()) ?></pre>
                            </div>
                        </div>
                    </details>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ============================================================
             TAB CONTENT: STUDIO VELVET
             ============================================================ -->
        <div id="content-velvet" class="tab-content">
            <!-- Section Header -->
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-white">✨ Jadwal Studio Velvet</h2>
                <p class="text-slate-400 text-sm mt-1">Pengalaman premium — surcharge 50% dari total harga dasar</p>
                <div class="mt-2 inline-block bg-amber-500/10 border border-amber-500/30 rounded-lg px-4 py-1.5">
                    <code class="text-amber-300 text-xs font-mono">hitungTotalHarga() = (jumlah_kursi × hargaDasarTiket) × 1.50</code>
                </div>
            </div>

            <!-- Grid Card Tiket Velvet -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
                $index = 0;
                foreach ($tiketVelvet as $tiket): 
                    $index++;
                    $delayClass = 'card-delay-' . min($index, 5);
                ?>
                <div class="card-hover animate-fade-in-up <?= $delayClass ?> opacity-0 
                            bg-gradient-to-br from-slate-800/80 to-slate-900/80 
                            backdrop-blur border border-amber-500/20 rounded-2xl overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-amber-600/20 to-orange-600/20 px-5 py-4 border-b border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <span class="bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-500/30 badge-pulse">
                                VELVET ★
                            </span>
                            <span class="text-slate-500 text-xs font-mono">#TKT-<?= str_pad($tiket->getId(), 3, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <h3 class="text-lg font-bold text-white mt-3"><?= htmlspecialchars($tiket->getNamaFilm()) ?></h3>
                    </div>

                    <!-- Card Body -->
                    <div class="px-5 py-4 space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">📅 Jadwal</span>
                            <span class="text-slate-300"><?= date('d M Y, H:i', strtotime($tiket->getJadwalTayang())) ?> WIB</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">💺 Kursi</span>
                            <span class="text-slate-300"><?= $tiket->getJumlahKursi() ?> kursi</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">🛏️ Bantal & Selimut</span>
                            <span class="text-amber-300 font-medium"><?= htmlspecialchars($tiket->getBantalSelimutPack()) ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-500">🤵 Layanan Butler</span>
                            <span class="text-amber-300 font-medium"><?= htmlspecialchars($tiket->getLayananButler()) ?></span>
                        </div>
                    </div>

                    <!-- Card Footer: Total Harga (Polimorfisme) -->
                    <div class="px-5 py-4 bg-slate-900/50 border-t border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 text-xs uppercase tracking-wider">Total Harga</span>
                            <!-- 
                                POLIMORFISME: Memanggil hitungTotalHarga()
                                Implementasi dari class TiketVelvet: (jumlah_kursi * hargaDasarTiket) * 1.50
                            -->
                            <span class="text-xl font-extrabold text-emerald-400">
                                Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.') ?>
                            </span>
                        </div>
                        <p class="text-slate-600 text-xs mt-1 text-right">
                            Harga dasar: Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.') ?>/kursi + surcharge 50%
                        </p>
                    </div>

                    <!-- Informasi Fasilitas (Polimorfisme) -->
                    <details class="group">
                        <summary class="px-5 py-3 text-xs text-amber-400 cursor-pointer hover:text-amber-300 
                                       border-t border-slate-700/30 flex items-center gap-2 select-none">
                            <span class="group-open:rotate-90 transition-transform text-[10px]">▶</span>
                            Lihat Detail Fasilitas (Polimorfisme Output)
                        </summary>
                        <div class="px-5 pb-4">
                            <!-- POLIMORFISME: Output tampilkanInformasiFasilitas() dari TiketVelvet -->
                            <div class="bg-slate-950 border border-slate-700/30 rounded-lg p-3">
                                <pre class="fasilitas-box text-slate-400"><?= htmlspecialchars($tiket->tampilkanInformasiFasilitas()) ?></pre>
                            </div>
                        </div>
                    </details>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>

    <!-- ================================================================
         FOOTER
         ================================================================ -->
    <footer class="border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center">
            <p class="text-slate-500 text-sm">
                &copy; <?= date('Y') ?> — <span class="text-slate-400 font-medium">Rifki Pramudya Pangestu</span> 
                | Latihan PBO — TRPL 1A
            </p>
            <p class="text-slate-600 text-xs mt-2">
                Dibangun dengan PHP OOP &bull; PDO &bull; Tailwind CSS
            </p>
        </div>
    </footer>

    <!-- ================================================================
         JAVASCRIPT: Tab Navigation
         ================================================================ -->
    <script>
        /**
         * Fungsi untuk beralih antar tab (Reguler, IMAX, Velvet).
         * Mengatur state active pada tombol tab dan konten yang ditampilkan.
         */
        function switchTab(tabName) {
            // Sembunyikan semua konten tab
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Reset semua tombol tab ke state default
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-indigo-600', 'bg-sky-600', 'bg-amber-600', 
                                     'text-white', 'shadow-lg', 'shadow-indigo-500/25', 
                                     'shadow-sky-500/25', 'shadow-amber-500/25');
                btn.classList.add('text-slate-400');
            });

            // Tampilkan konten tab yang dipilih
            document.getElementById('content-' + tabName).classList.add('active');

            // Aktifkan tombol tab yang dipilih dengan warna sesuai kategori
            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.add('active', 'text-white', 'shadow-lg');
            activeBtn.classList.remove('text-slate-400');

            // Berikan warna sesuai kategori studio
            switch(tabName) {
                case 'reguler':
                    activeBtn.classList.add('bg-indigo-600', 'shadow-indigo-500/25');
                    break;
                case 'imax':
                    activeBtn.classList.add('bg-sky-600', 'shadow-sky-500/25');
                    break;
                case 'velvet':
                    activeBtn.classList.add('bg-amber-600', 'shadow-amber-500/25');
                    break;
            }

            // Re-trigger animasi fade-in pada card yang baru ditampilkan
            const cards = document.querySelectorAll('#content-' + tabName + ' .animate-fade-in-up');
            cards.forEach(card => {
                card.style.animation = 'none';
                card.offsetHeight; // Trigger reflow
                card.style.animation = '';
            });
        }
    </script>

</body>
</html>
