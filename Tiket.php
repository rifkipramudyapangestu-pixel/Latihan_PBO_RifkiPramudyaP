<?php
/**
 * Abstract Class Tiket
 * 
 * Mengimplementasikan konsep Abstraksi. Class ini tidak dapat diinstansiasi 
 * (tidak bisa dibuat object-nya secara langsung dengan 'new Tiket()').
 * Class ini berfungsi sebagai kerangka dasar (blueprint) atau kontrak 
 * bagi class turunannya (misal: TiketVIP, TiketReguler).
 */
abstract class Tiket {
    // Properti dilindungi (protected) - konsep Enkapsulasi.
    // Hanya bisa diakses oleh class ini sendiri dan turunannya (child class).
    // Melindungi data agar tidak dimanipulasi secara langsung/sembarangan dari luar.
    protected $id_tiket;
    protected $nama_film;
    protected $jadwal_tayang;
    protected $jumlah_kursi;
    protected $hargaDasarTiket;

    /**
     * Constructor (Magic Method)
     * 
     * Digunakan untuk memetakan (menginisialisasi) nilai awal ke dalam properti
     * saat object dari class turunan nantinya dibuat.
     *
     * @param string $id_tiket ID unik tiket
     * @param string $nama_film Nama film yang akan ditonton
     * @param string $jadwal_tayang Jadwal penayangan film
     * @param int $jumlah_kursi Jumlah kursi yang dipesan
     * @param float $hargaDasarTiket Harga dasar tiket sebelum penyesuaian kelas
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket) {
        $this->id_tiket = $id_tiket;
        $this->nama_film = $nama_film;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->hargaDasarTiket = $hargaDasarTiket;
    }

    /**
     * Abstract Method: hitungTotalHarga()
     * 
     * Konsep Abstraksi: Memaksa semua class turunan (child class) untuk 
     * mendefinisikan/mengimplementasikan method ini secara spesifik. 
     * Karena cara menghitung total harga bisa berbeda (misal tiket VIP ada pajak 
     * tambahan, Reguler tidak), maka implementasi detailnya diserahkan ke class turunan.
     */
    abstract public function hitungTotalHarga();

    /**
     * Abstract Method: tampilkanInformasiFasilitas()
     * 
     * Memaksa class turunan untuk mendefinisikan cara menampilkan informasi fasilitas,
     * karena fasilitas yang didapat dari tiket VIP dan Reguler pasti berbeda.
     */
    abstract public function tampilkanInformasiFasilitas();
}
?>
