# rest
REST (Representational State Transfer) adalah sebuah arsitektur desain yang digunakan dalam pengembangan layanan web. REST diusulkan oleh Roy Fielding, salah satu penulis spesifikasi HTTP, dalam disertasinya pada tahun 2000. REST bukanlah sebuah standar atau protokol, tetapi lebih kepada sebuah set prinsip desain yang memanfaatkan standar web yang sudah ada seperti HTTP, URL, XML, dan JSON.
![ArsitekturRestWebService](https://github.com/sangkarsana/rest/blob/main/rest-arch.jpg?raw=true)
### Prinsip-Prinsip Dasar REST

1. **Stateless**: Setiap permintaan dari klien ke server harus mengandung semua informasi yang diperlukan untuk memproses permintaan tersebut. Server tidak menyimpan informasi tentang status klien.

2. **Client-Server**: Arsitektur REST adalah arsitektur client-server, di mana server menyediakan API dan klien mengaksesnya.

3. **Cacheable**: Respons dari server bisa disimpan di cache untuk meningkatkan performa.

4. **Uniform Interface**: REST menggunakan antarmuka yang seragam (uniform interface) yang menyederhanakan interaksi antara komponen. Ini biasanya diimplementasikan sebagai sekumpulan URL yang dapat diakses oleh metode HTTP tertentu (GET, POST, PUT, DELETE).

5. **Layered System**: REST memungkinkan penggunaan arsitektur berlapis-lapis di mana setiap lapisan memiliki fungsinya sendiri.

6. **Code on Demand (Opsional)**: Server dapat memberikan kode eksekutabel ke klien untuk eksekusi, meskipun ini jarang digunakan.

### Metode HTTP dalam REST

1. **GET**: Mengambil data dari server.
2. **POST**: Membuat sebuah sumber baru di server.
3. **PUT**: Memperbarui sumber yang sudah ada di server.
4. **DELETE**: Menghapus sumber dari server.

### Contoh Sederhana (Python dengan Flask)

Misalkan kita ingin membuat RESTful web service untuk mengelola data buku.

1. Install Flask jika belum terinstall.
    ```bash
    pip install Flask
    ```

2. Buat file `app.py`.

    ```python
    from flask import Flask, jsonify, request

    app = Flask(__name__)

    # Simulasi database sederhana menggunakan list Python
    books = [
        {'id': 1, 'title': 'Harry Potter', 'author': 'J.K. Rowling'},
        {'id': 2, 'title': 'Lord of the Rings', 'author': 'J.R.R. Tolkien'}
    ]

    # GET: Mendapatkan semua buku
    @app.route('/books', methods=['GET'])
    def get_books():
        return jsonify({'books': books})

    # GET: Mendapatkan buku berdasarkan ID
    @app.route('/books/<int:book_id>', methods=['GET'])
    def get_book(book_id):
        book = next((item for item in books if item['id'] == book_id), None)
        if book is None:
            return jsonify({'error': 'Book not found'}), 404
        return jsonify({'book': book})

    # POST: Menambahkan buku baru
    @app.route('/books', methods=['POST'])
    def add_book():
        new_book = request.json
        books.append(new_book)
        return jsonify({'book': new_book}), 201

    # PUT: Memperbarui buku berdasarkan ID
    @app.route('/books/<int:book_id>', methods=['PUT'])
    def update_book(book_id):
        book = next((item for item in books if item['id'] == book_id), None)
        if book is None:
            return jsonify({'error': 'Book not found'}), 404
        updated_book = request.json
        book.update(updated_book)
        return jsonify({'book': book})

    # DELETE: Menghapus buku berdasarkan ID
    @app.route('/books/<int:book_id>', methods=['DELETE'])
    def delete_book(book_id):
        global books
        books = [item for item in books if item['id'] != book_id]
        return jsonify({'result': 'Book deleted'})

    if __name__ == '__main__':
        app.run(debug=True)
    ```

3. Jalankan server dengan perintah `python app.py`.

4. Gunakan Postman atau curl untuk menguji API.

JSON (JavaScript Object Notation) adalah sebuah format data yang digunakan untuk pertukaran data antara sebuah server dan klien atau antar aplikasi. Format ini mudah dibaca oleh manusia dan mudah diolah oleh mesin. JSON berasal dari sintaks objek dalam bahasa pemrograman JavaScript, tetapi sekarang telah menjadi format data yang stand-alone dan digunakan oleh banyak bahasa pemrograman, termasuk Python, Ruby, PHP, dan banyak lagi.

### Struktur Dasar JSON

JSON terdiri dari dua struktur dasar:

1. **Objek**: Kumpulan pasangan nama/nilai. Dalam bahasa lain, ini dikenal sebagai *record*, *struct*, atau *dictionary*. Objek dalam JSON didefinisikan dengan tanda kurung kurawal `{}`.

    ```json
    {
      "nama": "John",
      "umur": 30,
      "kota": "New York"
    }
    ```

2. **Array**: Kumpulan nilai yang terurut. Dalam bahasa lain, ini dikenal sebagai *list*, *vector*, *sequence*, atau *array*. Array dalam JSON didefinisikan dengan tanda kurung siku `[]`.

    ```json
    ["apel", "pisang", "ceri"]
    ```

### Tipe Data di JSON

JSON mendukung beberapa tipe data, yaitu:

1. **String**: Diapit oleh tanda petik ganda.
2. **Number**: Tanpa tanda petik, bisa berupa integer atau floating-point.
3. **Boolean**: `true` atau `false`, tanpa tanda petik.
4. **Null**: `null`, tanpa tanda petik.
5. **Objek**: Tanda kurung kurawal `{}`.
6. **Array**: Tanda kurung siku `[]`.

### Contoh JSON

Berikut adalah contoh JSON yang merepresentasikan informasi tentang seorang mahasiswa:

```json
{
  "nama": "John",
  "umur": 20,
  "isStudent": true,
  "alamat": {
    "jalan": "Jl. ABC",
    "kota": "Jakarta"
  },
  "mataKuliah": ["Matematika", "Fisika", "Kimia"]
}
```

### Membaca dan Menulis JSON di Python

Python memiliki modul bawaan untuk bekerja dengan JSON, yaitu modul `json`.

#### Membaca JSON

```python
import json

data_json = '{"nama": "John", "umur": 20, "kota": "New York"}'
data_python = json.loads(data_json)

print(data_python["nama"])  # Output: John
```

#### Menulis JSON

```python
import json

data_python = {
  "nama": "John",
  "umur": 20,
  "kota": "New York"
}

data_json = json.dumps(data_python)
print(data_json)  # Output: {"nama": "John", "umur": 20, "kota": "New York"}
```

Penting untuk diingat bahwa JSON hanya berisi data. Tidak ada fungsi, callback, komentar, atau semacamnya.

Dalam PHP, kita bisa menggunakan fungsi bawaan untuk membaca dan menulis data dalam format JSON. Fungsi-fungsi ini adalah `json_encode()` untuk mengonversi array atau objek ke JSON, dan `json_decode()` untuk mengonversi string JSON ke variabel PHP.

### Membaca JSON dengan PHP

Untuk membaca JSON dalam PHP, Anda bisa menggunakan fungsi `json_decode()`.

```php
<?php
// contoh string JSON
$json_string = '{"nama": "John", "umur": 30, "kota": "New York"}';

// mengubah string JSON menjadi objek PHP
$obj = json_decode($json_string);

// mengakses properti dari objek
echo $obj->nama;  // Output: John
echo $obj->umur;  // Output: 30
echo $obj->kota;  // Output: New York
?>
```

Jika Anda ingin mengubah string JSON menjadi array asosiatif bukan objek, Anda bisa memberikan argumen kedua `true` ke fungsi `json_decode()`.

```php
<?php
// mengubah string JSON menjadi array asosiatif
$array = json_decode($json_string, true);

// mengakses elemen dari array
echo $array['nama'];  // Output: John
echo $array['umur'];  // Output: 30
echo $array['kota'];  // Output: New York
?>
```

### Menulis JSON dengan PHP

Untuk menulis JSON dalam PHP, Anda bisa menggunakan fungsi `json_encode()`.

```php
<?php
// contoh array asosiatif
$data = array("nama" => "John", "umur" => 30, "kota" => "New York");

// mengubah array menjadi string JSON
$json_string = json_encode($data);

// menampilkan string JSON
echo $json_string;  // Output: {"nama":"John","umur":30,"kota":"New York"}
?>
```

Anda juga bisa menggunakan fungsi ini untuk mengonversi objek ke string JSON.

```php
<?php
// contoh objek
$obj = new stdClass();
$obj->nama = "John";
$obj->umur = 30;
$obj->kota = "New York";

// mengubah objek menjadi string JSON
$json_string = json_encode($obj);

// menampilkan string JSON
echo $json_string;  // Output: {"nama":"John","umur":30,"kota":"New York"}
?>
```

### Kesimpulan

Dengan `json_decode()` dan `json_encode()`, Anda bisa dengan mudah membaca dan menulis data JSON di PHP. Ini sangat berguna saat Anda bekerja dengan RESTful web services, di mana JSON adalah salah satu format data yang paling umum digunakan.

Berikut adalah langkah-langkah untuk membuat RESTful web service menggunakan PHP yang akan melayani data jadwal perkuliahan untuk Program Studi Informasi.

### Persiapan

1. Pastikan Anda sudah menginstal XAMPP atau software server Apache lainnya.
2. Buka XAMPP Control Panel dan jalankan Apache.
3. Buat sebuah folder bernama `rest` di dalam folder `C:\xampp\htdocs`.

### Membuat RESTful Web Service

#### Membuat File `jadwal.php`

1. Buka editor teks Anda, kemudian buat file baru dengan nama `jadwal.php`.
2. Simpan file tersebut di dalam folder `C:\xampp\htdocs\rest`.

Isi `jadwal.php` dengan kode berikut:

```php
<?php
header('Content-Type: application/json');

// Contoh data jadwal perkuliahan untuk Program Studi Informasi
$jadwal = [
    [
        'hari' => 'Senin',
        'mata_kuliah' => 'Algoritma dan Pemrograman',
        'jam' => '08:00 - 10:00',
        'ruangan' => 'IF-101'
    ],
    [
        'hari' => 'Selasa',
        'mata_kuliah' => 'Struktur Data',
        'jam' => '10:00 - 12:00',
        'ruangan' => 'IF-102'
    ],
    [
        'hari' => 'Rabu',
        'mata_kuliah' => 'Basis Data',
        'jam' => '13:00 - 15:00',
        'ruangan' => 'IF-103'
    ],
    // Tambahkan lebih banyak jadwal di sini
];

// Cek apakah ada query parameter 'hari'
if (isset($_GET['hari'])) {
    $hari = $_GET['hari'];
    $jadwal_hari = array_filter($jadwal, function ($item) use ($hari) {
        return $item['hari'] === $hari;
    });
    echo json_encode(['jadwal' => array_values($jadwal_hari)]);
} else {
    echo json_encode(['jadwal' => $jadwal]);
}
?>
```

#### Menguji Layanan

Setelah Anda menyimpan file, Anda bisa menguji layanan RESTful ini dengan beberapa cara:

1. **Melalui Browser**: Buka browser dan akses URL `http://localhost/rest/jadwal.php`. Anda seharusnya akan melihat data JSON jadwal perkuliahan.
2. **Menggunakan `curl`**: Buka terminal atau command prompt, kemudian jalankan perintah berikut:
    ```bash
    curl http://localhost/rest/jadwal.php
    ```
3. **Melalui Postman**: Buka aplikasi Postman, buat sebuah GET request ke `http://localhost/rest/jadwal.php`.

#### Menggunakan Query Parameter

Anda juga bisa menguji layanan dengan menambahkan query parameter `hari` untuk mendapatkan jadwal pada hari tertentu, misalnya:

- Browser: `http://localhost/rest/jadwal.php?hari=Senin`
- curl: `curl http://localhost/rest/jadwal.php?hari=Senin`

### Kesimpulan

Dengan ini, Anda telah berhasil membuat sebuah RESTful web service sederhana dengan PHP untuk melayani data jadwal perkuliahan. 

Untuk mengimplementasikan operasi CRUD (Create, Read, Update, Delete) pada layanan RESTful yang sudah kita buat, kita akan memodifikasi file `jadwal.php` yang ada. Kali ini, kita akan menggunakan metode HTTP (`GET`, `POST`, `PUT`, `DELETE`) untuk menangani operasi CRUD tersebut.

### Modifikasi File `jadwal.php`

Buka file `jadwal.php` yang sudah ada, dan modifikasi seperti di bawah ini:

```php
<?php
header('Content-Type: application/json');

// Simulasi database sederhana menggunakan array
$jadwal = [
    [
        'id' => 1,
        'hari' => 'Senin',
        'mata_kuliah' => 'Algoritma dan Pemrograman',
        'jam' => '08:00 - 10:00',
        'ruangan' => 'IF-101'
    ],
    [
        'id' => 2,
        'hari' => 'Selasa',
        'mata_kuliah' => 'Struktur Data',
        'jam' => '10:00 - 12:00',
        'ruangan' => 'IF-102'
    ],
    // Tambahkan lebih banyak jadwal di sini
];

// Baca metode HTTP yang digunakan
$method = $_SERVER['REQUEST_METHOD'];

// Tangani permintaan berdasarkan metode HTTP
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $item = array_filter($jadwal, function ($e) use ($id) {
                return $e['id'] == $id;
            });
            echo json_encode(['jadwal' => array_values($item)]);
        } else {
            echo json_encode(['jadwal' => $jadwal]);
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $input['id'] = end($jadwal)['id'] + 1;  // Simulasi ID otomatis
        $jadwal[] = $input;
        echo json_encode(['jadwal' => $input]);
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $input = json_decode(file_get_contents('php://input'), true);
            foreach ($jadwal as $key => $value) {
                if ($value['id'] == $id) {
                    $jadwal[$key] = array_merge($value, $input);
                    echo json_encode(['jadwal' => $jadwal[$key]]);
                    break;
                }
            }
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            foreach ($jadwal as $key => $value) {
                if ($value['id'] == $id) {
                    unset($jadwal[$key]);
                    echo json_encode(['message' => 'Deleted successfully']);
                    break;
                }
            }
        }
        break;

    default:
        echo json_encode(['message' => 'Method not supported']);
        break;
}
?>
```

### Menguji Layanan CRUD dengan Postman

Setelah menyimpan perubahan, Anda bisa menguji layanan RESTful ini dengan Postman.

1. **READ**: Untuk membaca semua jadwal, buat sebuah GET request ke `http://localhost/rest/jadwal.php`.

2. **READ by ID**: Untuk membaca jadwal berdasarkan ID, buat GET request ke `http://localhost/rest/jadwal.php?id=1`.

3. **CREATE**: Untuk menambahkan jadwal baru, buat POST request ke `http://localhost/rest/jadwal.php` dengan body berisi data jadwal dalam format JSON.

4. **UPDATE**: Untuk memperbarui jadwal, buat PUT request ke `http://localhost/rest/jadwal.php?id=1` dengan body berisi data yang akan diperbarui dalam format JSON.

5. **DELETE**: Untuk menghapus jadwal, buat DELETE request ke `http://localhost/rest/jadwal.php?id=1`.

### Catatan

- Kode di atas hanya simulasi dan tidak memanipulasi database. Untuk aplikasi nyata, Anda akan perlu mengintegrasikan kode ini dengan database seperti MySQL.
- Kode ini tidak memiliki fitur autentikasi atau validasi, yang sebaiknya ada di aplikasi produksi.

Anda bisa membuat sebuah file HTML yang disertai dengan jQuery untuk mengkomunikasikan permintaan ke RESTful web service yang sudah Anda buat. Bootstrap dapat digunakan untuk mempercantik tampilan.

### Membuat File `index.html`

1. Buat file baru dengan nama `index.html`.
2. Simpan file ini di dalam folder `C:\xampp\htdocs\rest`.

Berikut adalah kode untuk `index.html`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Perkuliahan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Jadwal Perkuliahan</h1>
    <button id="loadAll" class="btn btn-primary">Tampilkan Semua</button>
    <div class="form-inline">
        <input type="text" id="idInput" class="form-control" placeholder="Masukkan ID">
        <button id="loadById" class="btn btn-success">Tampilkan Berdasarkan ID</button>
    </div>
    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Hari</th>
            <th>Mata Kuliah</th>
            <th>Jam</th>
            <th>Ruangan</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <!-- Data akan ditampilkan di sini -->
        </tbody>
    </table>
</div>

<!-- jQuery dan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan data ke tabel
    function showData(data) {
        let rows = '';
        $.each(data.jadwal, function(key, value) {
            rows += `<tr>
                        <td>${value.id}</td>
                        <td>${value.hari}</td>
                        <td>${value.mata_kuliah}</td>
                        <td>${value.jam}</td>
                        <td>${value.ruangan}</td>
                    </tr>`;
        });
        $("#tableBody").html(rows);
    }

    // Tampilkan semua data ketika tombol "Tampilkan Semua" diklik
    $("#loadAll").click(function() {
        $.get("http://localhost/rest/jadwal.php", function(data) {
            showData(data);
        });
    });

    // Tampilkan data berdasarkan ID ketika tombol "Tampilkan Berdasarkan ID" diklik
    $("#loadById").click(function() {
        const id = $("#idInput").val();
        $.get(`http://localhost/rest/jadwal.php?id=${id}`, function(data) {
            showData(data);
        });
    });
});
</script>

</body>
</html>
```

### Penjelasan Kode

1. **HTML dan Bootstrap**: Kode HTML menggunakan Bootstrap untuk styling. Ada sebuah tabel untuk menampilkan jadwal perkuliahan dan dua tombol untuk memuat data.
   
2. **jQuery**: Kode JavaScript menggunakan jQuery untuk melakukan AJAX request ke web service Anda. Ada dua jenis request:
   - **Tampilkan Semua**: Mengambil semua data dari endpoint `http://localhost/rest/jadwal.php`.
   - **Tampilkan Berdasarkan ID**: Mengambil data berdasarkan ID dari endpoint `http://localhost/rest/jadwal.php?id=ID_YANG_DIISI`.

### Cara Menjalankan

1. Buka browser dan akses `http://localhost/rest/index.html`.
2. Klik tombol "Tampilkan Semua" untuk melihat semua jadwal.
3. Masukkan ID di kotak input, kemudian klik "Tampilkan Berdasarkan ID" untuk melihat jadwal berdasarkan ID.

Dengan ini, Anda sudah berhasil membuat sebuah front-end sederhana yang berkomunikasi dengan RESTful web service Anda. 



