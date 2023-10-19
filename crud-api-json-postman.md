# contoh sederhana untuk membuat API CRUD dengan PHP
Baik, mari kita mulai langkah demi langkah. Saya akan mencoba menjelaskannya dengan se-sederhana mungkin agar mudah dipahami.

## Tahap 1: Membuat Database

Sebelum memulai, pastikan kamu sudah memasang XAMPP Control Panel dan sudah menjalankan Apache dan MySQL.

### Langkah 1.1: Buka phpMyAdmin
1. Buka XAMPP Control Panel.
2. Klik tombol "Admin" di sebelah MySQL. Ini akan membuka `phpMyAdmin`, sebuah alat untuk mengatur database.

### Langkah 1.2: Buat Database Baru
1. Di halaman awal `phpMyAdmin`, klik "New" di sebelah kiri untuk membuat database baru.
2. Masukkan nama database: "penggajian" dan klik "Create".

### Langkah 1.3: Buat Tabel Baru
1. Setelah database "penggajian" dibuat, masukkan nama tabel: "karyawan".
2. Tentukan jumlah kolom menjadi 4, lalu klik "Go".
3. Berikan nama kolom dan jenis data seperti berikut:
   - `id`: INT, A_I (centang kotak A_I, ini adalah Auto Increment agar setiap data memiliki ID unik)
   - `nama`: VARCHAR, panjang 255.
   - `alamat`: VARCHAR, panjang 255.
   - `jenis_kelamin`: VARCHAR, panjang 50.
4. Klik "Save".

## Tahap 2: Menyiapkan File Koneksi dan API

Buat dua file di folder `C:\xampp\htdocs\karyawan\`: `koneksi.php` dan `master.php`.

### Langkah 2.1: File `koneksi.php`
1. Buka aplikasi notepad atau editor teks favoritmu.
2. Salin kode berikut:

```php
<?php

$host = 'localhost';
$db   = 'penggajian';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit("Error: " . $e->getMessage());
}

?>
```

3. Simpan file tersebut sebagai `koneksi.php` di folder `C:\xampp\htdocs\karyawan\`.

### Langkah 2.2: File `master.php`
1. Buka aplikasi notepad atau editor teks favoritmu.

```php
<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM karyawan";
        $stmt = $pdo->query($sql);
        $karyawan = $stmt->fetchAll();
        echo json_encode($karyawan);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama) && isset($data->alamat) && isset($data->jenis_kelamin)) {
            $sql = "INSERT INTO karyawan (nama, alamat, jenis_kelamin) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama, $data->alamat, $data->jenis_kelamin]);
            echo json_encode(['message' => 'Karyawan berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id) && isset($data->nama) && isset($data->alamat) && isset($data->jenis_kelamin)) {
            $sql = "UPDATE karyawan SET nama=?, alamat=?, jenis_kelamin=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama, $data->alamat, $data->jenis_kelamin, $data->id]);
            echo json_encode(['message' => 'Karyawan berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id)) {
            $sql = "DELETE FROM karyawan WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id]);
            echo json_encode(['message' => 'Karyawan berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>

```

3. Salin kode dari file `master.php` yang saya berikan sebelumnya.
4. Simpan file tersebut sebagai `master.php` di folder yang sama.

## Tahap 3: Menguji API

1. Buka browser.
2. Akses `http://localhost/karyawan/master.php`.
3. Kamu seharusnya melihat data JSON (meskipun mungkin kosong karena belum ada data).

Untuk menguji fitur tambah, edit, dan hapus, kamu bisa menggunakan aplikasi seperti `Postman` atau ekstensi browser untuk mengirim request POST, PUT, dan DELETE.

**Catatan:** Pastikan kamu selalu berhati-hati saat mengolah data, terutama saat menghapus atau mengedit. Dan selalu buat backup dari database.

Semoga langkah-langkah ini mudah dipahami! Selamat mencoba!

# POSTMAN
Postman adalah sebuah aplikasi yang sangat populer dan banyak digunakan oleh para pengembang untuk menguji, mendokumentasikan, dan berinteraksi dengan Web API (Application Programming Interface). Dengan kata lain, Postman memudahkan kamu untuk mengirim permintaan ke server dan melihat respons yang diterima, tanpa harus membuat aplikasi khusus untuk itu.

### Mengapa Postman digunakan?

1. **Banyak Fungsi:** Postman dapat digunakan untuk berbagai jenis permintaan HTTP, seperti GET, POST, PUT, DELETE, dan lainnya. Ini memudahkan untuk menguji API dalam berbagai skenario.

2. **Mudah Digunakan:** Kamu hanya perlu memasukkan URL API yang ingin diuji, memilih jenis permintaan, dan jika diperlukan, menambahkan parameter, header, atau body ke permintaan.

3. **Dokumentasi Otomatis:** Postman memiliki fitur untuk otomatis membuat dokumentasi API dari permintaan yang kamu buat.

4. **Simpan Permintaan:** Kamu bisa menyimpan permintaan tertentu untuk digunakan lagi di kemudian hari. Ini sangat berguna untuk pengujian berulang.

5. **Kerja Tim:** Postman memungkinkan kamu untuk berbagi koleksi permintaan dengan tim kamu, sehingga memudahkan kerja sama dalam pengembangan.

### Bagaimana Cara Menggunakan Postman?

1. **Instalasi:** Unduh dan instal Postman dari situs resminya.

2. **Membuat Permintaan Baru:** Setelah membuka Postman, kamu bisa memulai dengan membuat permintaan baru. Masukkan URL API yang ingin kamu uji.

3. **Pilih Jenis Permintaan:** Misalnya, jika kamu ingin mengambil data, pilih "GET". Jika ingin mengirim data baru ke server, pilih "POST".

4. **Tambahkan Detail (jika diperlukan):** Misalnya, untuk permintaan POST, kamu mungkin perlu menambahkan data di bagian "body" permintaan.

5. **Kirim Permintaan:** Klik tombol "Send", dan Postman akan mengirim permintaan ke server. Kemudian, kamu bisa melihat respons yang diterima di bagian bawah layar.

6. **Analisis Respons:** Lihat respons yang diterima dari server. Ini akan memberi kamu informasi tentang apakah API berfungsi dengan benar atau ada kesalahan.

# cara melakukan operasi CRUD (Create, Read, Update, Delete) pada API karyawan yang telah kita buat menggunakan Postman.

### 1. Membaca Data (READ)
1. Buka Postman.
2. Pilih metode `GET`.
3. Masukkan URL `http://localhost/karyawan/master.php`.
4. Klik `Send`. Jika ada data di database, responsnya akan menampilkan data karyawan dalam format JSON.

### 2. Menambah Data (CREATE)
1. Pilih metode `POST`.
2. Masukkan URL yang sama `http://localhost/karyawan/master.php`.
3. Pilih tab `Body`.
4. Pilih tipe `raw` dan format `JSON (application/json)`.
5. Masukkan data karyawan yang ingin ditambahkan, contohnya:
```json
{
    "nama": "Budi",
    "alamat": "Jl. Raya No. 5, Yogyakarta",
    "jenis_kelamin": "Laki-laki"
}
```
6. Klik `Send`. Jika berhasil, responsnya akan mengatakan bahwa karyawan berhasil ditambahkan.

### 3. Memperbarui Data (UPDATE)
1. Pilih metode `PUT`.
2. Masukkan URL yang sama.
3. Pilih tab `Body`.
4. Pilih tipe `raw` dan format `JSON (application/json)`.
5. Masukkan data karyawan yang ingin diperbarui beserta `id`-nya, contohnya:
```json
{
    "id": 1,
    "nama": "Budi Setiawan",
    "alamat": "Jl. Raya Baru No. 6, Yogyakarta",
    "jenis_kelamin": "Laki-laki"
}
```
6. Klik `Send`. Jika berhasil, responsnya akan mengatakan bahwa karyawan berhasil diperbarui.

### 4. Menghapus Data (DELETE)
1. Pilih metode `DELETE`.
2. Masukkan URL yang sama.
3. Pilih tab `Body`.
4. Pilih tipe `raw` dan format `JSON (application/json)`.
5. Masukkan `id` karyawan yang ingin dihapus, contohnya:
```json
{
    "id": 1
}
```
6. Klik `Send`. Jika berhasil, responsnya akan mengatakan bahwa karyawan berhasil dihapus.

Itulah langkah-langkah dasar untuk melakukan operasi CRUD pada API karyawan menggunakan Postman. Pastikan setiap kali kamu mengirim permintaan, perhatikan respons yang diberikan oleh server untuk memastikan operasi berhasil dilakukan atau jika ada kesalahan yang terjadi.
