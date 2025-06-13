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

## 6. Membuat Model & Controller
Buat Model dan Controller sesuai dengan database yang ada. Seperti Dosen, Mahasiswa, Mata Kuliah, Detail Nilai, Nilai-Nilai \
Berikut salah satu contoh Model dan Controller-nya
### Dosen Model
```php
class DosenModel extends Model
{
    // Nama tabel dalam database yang digunakan oleh model ini
    protected $table            = 'dosen';

    // Nama kolom yang menjadi primary key di tabel 'dosen'
    protected $primaryKey       = 'id_dosen';
    
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Daftar kolom yang boleh diisi atau diubah melalui method Create dan Update
    protected $allowedFields    = ['id_dosen', 'nama_dosen', 'email', 'no_telp', 'password'];
```

### Dosen Controller
```php
     // * GET /dosen
     // * Menampilkan semua data dosen

    public function index()
    {
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_dosen->orderBy("id_dosen", "ASC")->findAll()
        ];
        return $this->respond($res);
    }
```
```php
     // * GET /dosen/$1
     // * Menampilkan data dosen berdasarkan ID

    public function show($id_dosen)
    {
        $data = $this->m_dosen->find($id_dosen);
        
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data dosen dengan ID $id_dosen tidak ditemukan.");
        }
    }
```
```php
     // * POST /dosen
     // * Menambahkan data dosen baru

    public function create()
    {
        try {
            // Validasi input
            $rules = [
                'id_dosen' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'id dosen harus di isi!']
                ],
                'nama_dosen' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'nama dosen harus di isi!']
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'email harus di isi!',
                        'valid_email' => 'email tidak valid'
                    ]
                ],
                'no_telp' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'no telp harus di isi!']
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'Password harus diisi!']
                ]
            ];

            // Jika validasi gagal
            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            }

            // Data yang akan disimpan
            $data = [
                "id_dosen" => $this->request->getPost("id_dosen"),
                "nama_dosen" => $this->request->getPost("nama_dosen"),
                "email" => $this->request->getPost("email"),
                "no_telp" => $this->request->getPost("no_telp"),
                "password" => $this->request->getPost("password")
            ];

            // Simpan ke database
            $this->m_dosen->insert($data);

            // Berhasil
            $res = [
                "status" => 201,
                "message" => "Data dosen berhasil dibuat!",
                "data" => $data
            ];
            return $this->respond($res);
        // Untuk mencegah sistem crash akibat error tak terduga.
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
```
```php
     // * PUT /dosen/$1
     // * Mengupdate data dosen berdasarkan ID

    public function update($id_dosen)
    {
        try {
            // Validasi input
            $rules = [
                'nama_dosen' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'Nama dosen harus diisi!']
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email harus diisi!',
                        'valid_email' => 'Email tidak valid'
                    ]
                ],
                'no_telp' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'No telepon harus diisi!']
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'Password harus diisi!']
                ]
            ];

            // Jika validasi gagal
            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            }

            // Ambil data input mentah dari PUT request
            $data = [
                'nama_dosen' => $this->request->getRawInput()['nama_dosen'] ?? null,
                'email' => $this->request->getRawInput()['email'] ?? null,
                'no_telp' => $this->request->getRawInput()['no_telp'] ?? null,
                'password' => $this->request->getRawInput()['password'] ?? null
            ];

            // Update data di database
            if ($this->m_dosen->update($id_dosen, $data)) {
                return $this->respond(['message' => 'Data dosen berhasil diupdate.']);
            } else {
                return $this->failValidationErrors($this->m_dosen->errors());
            }
        // Untuk mencegah sistem crash akibat error tak terduga.
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
```
```php
    // * DELETE /dosen/{id}
    // * Menghapus data dosen berdasarkan ID

    public function delete($id_dosen)
    {
        $data = $this->m_dosen->find($id_dosen);

        if ($data) {
            $this->m_dosen->delete($id_dosen);
            return $this->respondDeleted(['status' => 203, 'message' => 'Data dosen berhasil dihapus.']);
        } else {
            return $this->failNotFound("Data dosen dengan ID $id_dosen tidak ditemukan.");
        }
    }
```
```php
    // * POST /dosen/login
    // * Fitur login dosen menggunakan email & password

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari dosen berdasarkan email dan password
        $dosen = $this->m_dosen->where('email', $email)
                            ->where('password', $password)
                            ->first();
        if ($dosen) {
            return $this->respond([
                'status' => 200,
                'message' => 'Login Berhasil',
                'role' => 'dosen',
                'data' => $dosen
            ]);
        }
        return $this->fail('Email atau password salah', 401);
    }
```

## 7. Menjalankan Server Development
Jalankan server CodeIgniter dengan command:
```php
php spark serve
```
Server akan berjalan di http://localhost:8080

## 8. Cek Endpoint API Menggunakan Postman
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
