# rest
REST (Representational State Transfer) adalah sebuah arsitektur desain yang digunakan dalam pengembangan layanan web. REST diusulkan oleh Roy Fielding, salah satu penulis spesifikasi HTTP, dalam disertasinya pada tahun 2000. REST bukanlah sebuah standar atau protokol, tetapi lebih kepada sebuah set prinsip desain yang memanfaatkan standar web yang sudah ada seperti HTTP, URL, XML, dan JSON.

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

