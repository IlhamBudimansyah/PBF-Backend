<?php

namespace App\Controllers\Api; // Namespace API agar rapi dan terstruktur

use App\Controllers\BaseController; // Menggunakan BaseController bawaan CI
use App\Models\DosenModel; // Memanggil model untuk tabel dosen
use CodeIgniter\API\ResponseTrait; // Trait untuk mempermudah response API

class DosenApiController extends BaseController
{
    use ResponseTrait;
    protected $m_dosen; // Properti untuk menyimpan instance model

    public function __construct()
    {
        // Inisialisasi model saat controller dibuat
        $this->m_dosen = new DosenModel();
    }

    /**
     * GET /dosen
     * Menampilkan semua data dosen
     */
    public function index()
    {
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_dosen->orderBy("id_dosen", "ASC")->findAll()
        ];
        return $this->respond($res);
    }

    /**
     * GET /dosen/{id}
     * Menampilkan data dosen berdasarkan ID
     */
    public function show($id_dosen)
    {
        $data = $this->m_dosen->find($id_dosen);
        
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data dosen dengan ID $id_dosen tidak ditemukan.");
        }
    }

    /**
     * POST /dosen
     * Menambahkan data dosen baru
     */
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
            
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * PUT /dosen/{id}
     * Mengupdate data dosen berdasarkan ID
     */
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
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * DELETE /dosen/{id}
     * Menghapus data dosen berdasarkan ID
     */
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

    /**
     * POST /dosen/login
     * Fitur login dosen menggunakan email & password
     */
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
}
