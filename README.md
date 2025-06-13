# PBF BACKEND

## 1. Tools Yang Digunakan
### CodeIgniter Versi 4
Link download CodeIgniter :
```php
https://codeigniter.com/download
```
### Composer
Link download Composer :
```php
https://getcomposer.org/download/
```
### Postman
Link donwload Postman :
```php
https://www.postman.com/downloads/
```
### PhpMyAdmin
Link PhpMyAdmin :
```php
http://localhost/phpmyadmin
```

## 2. Clone Repository
Clone repository ini ke dalam direktori lokal :
```php
git clone https://github.com/IlhamBudimansyah/PBF-Backend.git
cd PBF-Backend
```

## 3. Install Composer
Pastikan kamu sudah memiliki Composer yang terinstal. Lalu jalankan command berikut melalui terminal VS Code untuk menambahkan composer ke dalam code :
```php
composer install
```

## 4. Konfigurasi Environment
Edit file .env dan sesuaikan dengan koneksi database lokal kamu:
```php
database.default.hostname = localhost
database.default.database = "nama_database_anda"
database.default.username = root
database.default.password = 
```
Jangan lupa mengganti CI_Environment nya dari :
```php
CI_ENVIRONMENT = production
```
Menjadi :
```php
CI_ENVIRONMENT = development
```
Agar bisa menampilkan error ketika kita salah/typo saat mengerjakan projectnya

## 5. Membuat Database dan Import Database
Download Databasenya melalui link dibawah ini :
```php
https://drive.google.com/file/d/1EjKNxOrKj8vFCkhieK7waPv574I3Szem/view?usp=sharing
```

## 6. Menjalankan Server Development
Jalankan server CodeIgniter dengan command:
```php
php spark serve
```
Server akan berjalan di http://localhost:8080

## 7. Cek Endpoint API Menggunakan Postman
Gunakan Postman untuk mengetes endpoint berikut:

Dosen \
GET → http://localhost:8080/api/dosen (Untuk menampilkan seluruh data dosen yang ada) \
POST → http://localhost:8080/api/dosen (Untuk menambahkan data dosen) \
PUT → http://localhost:8080/api/dosen/$1 (Untuk megedit data dosen dengan ID DOSEN yang ingin kita edit) \
DELETE → http://localhost:8080/api/dosen/$1 (Untuk menghapus data dosen dengan ID DOSEN yang ingin kita hapus)

Mahasiswa \
GET → http://localhost:8080/api/mahasiswa (Untuk menampilkan seluruh data mahasiswa yang ada) \
POST → http://localhost:8080/api/mahasiswa (Untuk menambahkan data mahasiswa) \
PUT → http://localhost:8080/api/mahasiswa/$1 (Untuk megedit data mahasiswa dengan NPM yang ingin kita edit) \
DELETE → http://localhost:8080/api/mahasiswa/$1 (Untuk menghapus data mahasiswa dengan NPM yang ingin kita hapus)

Detail Nilai \
GET → http://localhost:8080/api/nilai (Untuk menampilkan seluruh data detail nilai mahasiswa yang ada) \
POST → http://localhost:8080/api/nilai (Untuk menambahkan data detail nilai mahasiswa) \
PUT → http://localhost:8080/api/nilai/$1 (Untuk megedit data detail nilai mahasiswa dengan ID DETAIL yang ingin kita edit) \
DELETE → http://localhost:8080/api/nilai/$1 (Untuk menghapus data detail nilai mahasiswa dengan ID DETAIL yang ingin kita hapus)

Nilai-Nilai \
GET → http://localhost:8080/api/nilainilai (Untuk menampilkan seluruh data nilai akhir mahasiswa yang ada) \
POST → http://localhost:8080/api/nilainilai (Untuk menambahkan data nilai akhir mahasiswa) \
PUT → http://localhost:8080/api/nilainilai/$1 (Untuk megedit data nilai akhir mahasiswa dengan ID NILAI yang ingin kita edit) \
DELETE → http://localhost:8080/api/nilainilai/$1 (Untuk menghapus data nilai akhir mahasiswa dengan ID NILAI yang ingin kita hapus)

Matkul \
GET → http://localhost:8080/api/matkul (Untuk menampilkan seluruh mata kuliah yang ada) \
POST → http://localhost:8080/api/matkul (Untuk menambahkan mata kuliah) \
PUT → http://localhost:8080/api/matkul/$1 (Untuk megedit mata kuliah dengan ID MATKUL yang ingin kita edit) \
DELETE → http://localhost:8080/api/matkul/$1 (Untuk menghapus mata kuliah dengan ID MATKUL yang ingin kita hapus)
