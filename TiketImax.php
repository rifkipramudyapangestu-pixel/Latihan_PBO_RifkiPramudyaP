<?php
/**
 * Meng-include abstract class Tiket sebagai parent class.
 * File ini WAJIB di-include karena TiketImax merupakan turunan (child) dari Tiket.
 */
require_once __DIR__ . '/Tiket.php';

/**
 * Class TiketImax (Child Class / Kelas Turunan)
 * 
 * Mewarisi (extends) abstract class Tiket dan mengimplementasikan
 * semua abstract method yang dideklarasikan oleh parent class.
 * 
 * Merepresentasikan tiket bioskop untuk studio kelas IMAX.
 * Memiliki properti tambahan yang spesifik untuk studio IMAX:
 * - kacamata3DId    : ID kacamata 3D yang dipinjamkan kepada penonton
 * - efekGerakFitur  : fitur efek gerak kursi (motion seat) yang tersedia
 * 
 * Pemetaan ke kolom database tabel_tiket:
 * - kacamata3DId   => kolom `kacamata_3D_id` (varchar 50)
 * - efekGerakFitur => kolom `efek_gerak_fitur` (varchar 100)
 */
class TiketImax extends Tiket {
    /**
     * Properti tambahan bersifat private (Enkapsulasi).
     * Hanya bisa diakses dari dalam class TiketImax ini saja,
     * karena properti ini spesifik untuk kelas studio IMAX
     * dan tidak perlu diwariskan ke class lain.
     */
    private $kacamata3DId;
    private $efekGerakFitur;

    /**
     * Constructor untuk TiketImax.
     * 
     * Memanggil parent::__construct() untuk menginisialisasi properti dasar
     * yang diwarisi dari abstract class Tiket, kemudian menginisialisasi
     * properti tambahan milik TiketImax sendiri.
     *
     * @param int    $id_tiket        ID unik tiket
     * @param string $nama_film       Nama film yang ditonton
     * @param string $jadwal_tayang   Jadwal penayangan film
     * @param int    $jumlah_kursi    Jumlah kursi yang dipesan
     * @param float  $hargaDasarTiket Harga dasar tiket
     * @param string $kacamata3DId    ID kacamata 3D yang dipinjamkan
     * @param string $efekGerakFitur  Fitur efek gerak kursi (motion seat)
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $kacamata3DId, $efekGerakFitur) {
        // Memanggil constructor parent untuk inisialisasi properti dasar (inherited)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);

        // Inisialisasi properti tambahan milik TiketImax
        $this->kacamata3DId = $kacamata3DId;
        $this->efekGerakFitur = $efekGerakFitur;
    }

    /**
     * Implementasi abstract method hitungTotalHarga() dari parent class.
     * 
     * Studio IMAX memiliki biaya tambahan (surcharge) sebesar 50% dari harga dasar
     * karena fasilitas premium seperti kacamata 3D dan efek gerak kursi.
     * Total harga = (harga dasar tiket * 1.5) * jumlah kursi.
     *
     * @return float Total harga tiket IMAX
     */
    public function hitungTotalHarga() {
        $surchargeImax = 1.5; // Biaya tambahan 50% untuk fasilitas IMAX
        return ($this->hargaDasarTiket * $surchargeImax) * $this->jumlah_kursi;
    }

    /**
     * Implementasi abstract method tampilkanInformasiFasilitas() dari parent class.
     * 
     * Menampilkan detail informasi tiket beserta fasilitas spesifik
     * yang didapatkan penonton di studio kelas IMAX.
     *
     * @return string Informasi lengkap tiket dan fasilitas
     */
    public function tampilkanInformasiFasilitas() {
        return "============================================\n"
             . "        TIKET BIOSKOP - STUDIO IMAX         \n"
             . "============================================\n"
             . "ID Tiket       : " . $this->id_tiket . "\n"
             . "Nama Film      : " . $this->nama_film . "\n"
             . "Jadwal Tayang  : " . $this->jadwal_tayang . "\n"
             . "Jumlah Kursi   : " . $this->jumlah_kursi . "\n"
             . "Harga Dasar    : Rp " . number_format($this->hargaDasarTiket, 2, ',', '.') . "\n"
             . "--------------------------------------------\n"
             . "FASILITAS STUDIO IMAX:\n"
             . "  Kacamata 3D ID   : " . $this->kacamata3DId . "\n"
             . "  Efek Gerak Fitur : " . $this->efekGerakFitur . "\n"
             . "--------------------------------------------\n"
             . "Surcharge IMAX : +50%\n"
             . "TOTAL HARGA    : Rp " . number_format($this->hitungTotalHarga(), 2, ',', '.') . "\n"
             . "============================================\n";
    }
}
?>
