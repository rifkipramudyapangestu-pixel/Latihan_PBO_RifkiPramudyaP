<?php
/**
 * Meng-include abstract class Tiket sebagai parent class.
 * File ini WAJIB di-include karena TiketVelvet merupakan turunan (child) dari Tiket.
 */
require_once __DIR__ . '/Tiket.php';

/**
 * Class TiketVelvet (Child Class / Kelas Turunan)
 * 
 * Mewarisi (extends) abstract class Tiket dan mengimplementasikan
 * semua abstract method yang dideklarasikan oleh parent class.
 * 
 * Merepresentasikan tiket bioskop untuk studio kelas Velvet (Premium/VIP).
 * Memiliki properti tambahan yang spesifik untuk studio Velvet:
 * - bantalSelimutPack : paket bantal dan selimut premium untuk kenyamanan
 * - layananButler     : layanan butler pribadi selama menonton
 * 
 * Pemetaan ke kolom database tabel_tiket:
 * - bantalSelimutPack => kolom `bantal_selimut_pack` (varchar 50)
 * - layananButler     => kolom `layanan_butler` (varchar 100)
 */
class TiketVelvet extends Tiket {
    /**
     * Properti tambahan bersifat private (Enkapsulasi).
     * Hanya bisa diakses dari dalam class TiketVelvet ini saja,
     * karena properti ini spesifik untuk kelas studio Velvet
     * dan tidak perlu diwariskan ke class lain.
     */
    private $bantalSelimutPack;
    private $layananButler;

    /**
     * Constructor untuk TiketVelvet.
     * 
     * Memanggil parent::__construct() untuk menginisialisasi properti dasar
     * yang diwarisi dari abstract class Tiket, kemudian menginisialisasi
     * properti tambahan milik TiketVelvet sendiri.
     *
     * @param int    $id_tiket          ID unik tiket
     * @param string $nama_film         Nama film yang ditonton
     * @param string $jadwal_tayang     Jadwal penayangan film
     * @param int    $jumlah_kursi      Jumlah kursi yang dipesan
     * @param float  $hargaDasarTiket   Harga dasar tiket
     * @param string $bantalSelimutPack Paket bantal dan selimut premium
     * @param string $layananButler     Layanan butler pribadi
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $bantalSelimutPack, $layananButler) {
        // Memanggil constructor parent untuk inisialisasi properti dasar (inherited)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);

        // Inisialisasi properti tambahan milik TiketVelvet
        $this->bantalSelimutPack = $bantalSelimutPack;
        $this->layananButler = $layananButler;
    }

    /**
     * Implementasi abstract method hitungTotalHarga() dari parent class.
     * (Polimorfisme - Method Overriding)
     * 
     * Studio Velvet dikenakan surcharge/biaya tambahan kelas premium
     * sebesar 50% dari total harga dasar.
     * Rumus: Total Harga = (jumlah_kursi * hargaDasarTiket) * 1.50
     *
     * @return float Total harga tiket Velvet
     */
    public function hitungTotalHarga() {
        // Surcharge 50% untuk fasilitas premium Velvet
        $surchargeVelvet = 1.50;
        return ($this->jumlah_kursi * $this->hargaDasarTiket) * $surchargeVelvet;
    }

    /**
     * Implementasi abstract method tampilkanInformasiFasilitas() dari parent class.
     * 
     * Menampilkan detail informasi tiket beserta fasilitas spesifik
     * yang didapatkan penonton di studio kelas Velvet (Premium/VIP).
     *
     * @return string Informasi lengkap tiket dan fasilitas
     */
    public function tampilkanInformasiFasilitas() {
        return "============================================\n"
             . "      TIKET BIOSKOP - STUDIO VELVET         \n"
             . "============================================\n"
             . "ID Tiket       : " . $this->id_tiket . "\n"
             . "Nama Film      : " . $this->nama_film . "\n"
             . "Jadwal Tayang  : " . $this->jadwal_tayang . "\n"
             . "Jumlah Kursi   : " . $this->jumlah_kursi . "\n"
             . "Harga Dasar    : Rp " . number_format($this->hargaDasarTiket, 2, ',', '.') . "\n"
             . "--------------------------------------------\n"
             . "FASILITAS STUDIO VELVET (PREMIUM):\n"
             . "  Bantal & Selimut : " . $this->bantalSelimutPack . "\n"
             . "  Layanan Butler   : " . $this->layananButler . "\n"
             . "--------------------------------------------\n"
             . "Surcharge Premium : +50%\n"
             . "TOTAL HARGA       : Rp " . number_format($this->hitungTotalHarga(), 2, ',', '.') . "\n"
             . "============================================\n";
    }
}
?>
