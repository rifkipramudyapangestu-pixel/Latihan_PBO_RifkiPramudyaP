<?php
/**
 * Class Database
 * 
 * Mengimplementasikan konsep Enkapsulasi dengan menyembunyikan detail koneksi
 * (host, username, password, db_name) menggunakan visibility 'private'.
 * Hal ini mencegah akses dan modifikasi langsung dari luar class, 
 * sehingga meningkatkan keamanan konfigurasi database.
 */
class Database {
    // Properti private hanya bisa diakses dari dalam class ini sendiri (Enkapsulasi)
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "db_latihan_pbo_trpl1a_rifki pramudya pangestu"; // Menggunakan nama DB yang baru
    
    private $conn;

    /**
     * Constructor untuk inisialisasi koneksi saat object dibuat.
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * Method untuk membuat koneksi ke database menggunakan PDO.
     */
    private function connect() {
        $this->conn = null;

        try {
            // Data Source Name (DSN) untuk PDO MySQL
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            
            // Membuat instance PDO baru
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Mengatur error mode ke Exception agar error mudah ditangkap (di-catch) dan di-debug
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            // Menangkap dan menampilkan pesan error jika koneksi gagal
            echo "Koneksi database gagal: " . $e->getMessage();
        }
    }

    /**
     * Method public untuk mendapatkan instance koneksi PDO dari luar class.
     * 
     * @return PDO|null
     */
    public function getConnection() {
        return $this->conn;
    }
}
?>
