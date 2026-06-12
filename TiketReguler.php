<?php
/**
 * Meng-include abstract class Tiket sebagai parent class.
 * File ini WAJIB di-include karena TiketReguler merupakan turunan (child) dari Tiket.
 */
require_once __DIR__ . '/Tiket.php';

/**
 * Class TiketReguler (Child Class / Kelas Turunan)
 * 
 * Mewarisi (extends) abstract class Tiket dan mengimplementasikan
 * semua abstract method yang dideklarasikan oleh parent class.
 * 
 * Merepresentasikan tiket bioskop untuk studio kelas Reguler.
 * Memiliki properti tambahan yang spesifik untuk studio Reguler:
 * - tipeAudio   : jenis sistem audio yang digunakan di studio (misal: Dolby 7.1)
 * - lokasiBaris : posisi baris kursi penonton (misal: Row G)
 * 
 * Pemetaan ke kolom database tabel_tiket:
 * - tipeAudio   => kolom `tipe_audio` (varchar 50)
 * - lokasiBaris => kolom `lokasi_baris` (varchar 5)
 */
class TiketReguler extends Tiket {
    /**
     * Properti tambahan bersifat private (Enkapsulasi).
     * Hanya bisa diakses dari dalam class TiketReguler ini saja,
     * karena properti ini spesifik untuk kelas studio Reguler
     * dan tidak perlu diwariskan ke class lain.
     */
    private $tipeAudio;
    private $lokasiBaris;

    /**
     * Constructor untuk TiketReguler.
     * 
     * Memanggil parent::__construct() untuk menginisialisasi properti dasar
     * yang diwarisi dari abstract class Tiket, kemudian menginisialisasi
     * properti tambahan milik TiketReguler sendiri.
     *
     * @param int    $id_tiket        ID unik tiket
     * @param string $nama_film       Nama film yang ditonton
     * @param string $jadwal_tayang   Jadwal penayangan film
     * @param int    $jumlah_kursi    Jumlah kursi yang dipesan
     * @param float  $hargaDasarTiket Harga dasar tiket
     * @param string $tipeAudio       Jenis sistem audio studio (misal: Dolby 7.1)
     * @param string $lokasiBaris     Posisi baris kursi (misal: Row G)
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $tipeAudio, $lokasiBaris) {
        // Memanggil constructor parent untuk inisialisasi properti dasar (inherited)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);

        // Inisialisasi properti tambahan milik TiketReguler
        $this->tipeAudio = $tipeAudio;
        $this->lokasiBaris = $lokasiBaris;
    }

    /**
     * Implementasi abstract method hitungTotalHarga() dari parent class.
     * (Polimorfisme - Method Overriding)
     * 
     * Studio Reguler menggunakan tarif standar murni tanpa biaya tambahan fasilitas.
     * Rumus: Total Harga = jumlah_kursi * hargaDasarTiket
     *
     * @return float Total harga tiket Reguler
     */
    public function hitungTotalHarga() {
        return $this->jumlah_kursi * $this->hargaDasarTiket;
    }

    /**
     * Implementasi abstract method tampilkanInformasiFasilitas() dari parent class.
     * 
     * Menampilkan detail informasi tiket beserta fasilitas spesifik
     * yang didapatkan penonton di studio kelas Reguler.
     *
     * @return string Informasi lengkap tiket dan fasilitas
     */
    public function tampilkanInformasiFasilitas() {
        return "============================================\n"
             . "       TIKET BIOSKOP - STUDIO REGULER       \n"
             . "============================================\n"
             . "ID Tiket       : " . $this->id_tiket . "\n"
             . "Nama Film      : " . $this->nama_film . "\n"
             . "Jadwal Tayang  : " . $this->jadwal_tayang . "\n"
             . "Jumlah Kursi   : " . $this->jumlah_kursi . "\n"
             . "Harga Dasar    : Rp " . number_format($this->hargaDasarTiket, 2, ',', '.') . "\n"
             . "--------------------------------------------\n"
             . "FASILITAS STUDIO REGULER:\n"
             . "  Tipe Audio     : " . $this->tipeAudio . "\n"
             . "  Lokasi Baris   : " . $this->lokasiBaris . "\n"
             . "--------------------------------------------\n"
             . "TOTAL HARGA    : Rp " . number_format($this->hitungTotalHarga(), 2, ',', '.') . "\n"
             . "============================================\n";
    }
}
?>
