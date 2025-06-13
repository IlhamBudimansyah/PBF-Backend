<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NilaiNilaiModel;
use CodeIgniter\API\ResponseTrait;

class NilaiNilaiApiController extends BaseController
{
    use ResponseTrait;
    protected $m_nilainilai;

    public function __construct()
    {
        // Inisialisasi model NilaiNilai
        $this->m_nilainilai = new NilaiNilaiModel();
    }

    // Endpoint: GET /api/nilai
    // Menampilkan semua data nilai
    public function index()
    {
        $data = $this->m_nilainilai->orderBy('id_nilai', 'DESC')->getAllNilai();

        return $this->respond([
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $data
        ]);
    }

    // Endpoint: GET /api/nilai/{npm}
    // Menampilkan data nilai berdasarkan NPM mahasiswa
    public function show($npm = null)
    {
        $data = $this->m_nilainilai->getDetailByNPM($npm);

        if ($data) {
            return $this->respond([
                "status" => 200,
                "message" => "success",
                "data" => $data
            ]);
        } else {
            return $this->failNotFound("Tidak ada data nilai untuk NPM $npm.");
        }
    }

    // Endpoint: GET /api/nilai/showById/{id_nilai}
    // Menampilkan detail data nilai berdasarkan ID nilai
    public function showById($id_nilai = null)
    {
        $data = $this->m_nilainilai->getDetailById($id_nilai);

        if ($data) {
            return $this->respond([
                "status" => 200,
                "message" => "success",
                "data" => $data
            ]);
        } else {
            return $this->failNotFound("Tidak ada data nilai dengan ID $id_nilai.");
        }
    }

    // Endpoint: POST /api/nilai
    // Membuat data nilai baru
    public function create()
    {
        $data = [
            "id_dosen"  => $this->request->getPost("id_dosen"),
            "id_matkul" => $this->request->getPost("id_matkul"),
            "NPM"       => $this->request->getPost("NPM")
        ];

        // Simpan data dan ambil ID-nya
        $id = $this->m_nilainilai->insert($data);

        if ($id) {
            return $this->respondCreated([
                "status" => 201,
                "message" => "Nilai berhasil dibuat!",
                'data' => array_merge(['id_nilai' => $id], $data)
            ]);
        } else {
            return $this->failValidationErrors($this->m_nilainilai->errors());
        }
    }

    // Endpoint: PUT /api/nilai/{id}
    // Mengupdate data nilai berdasarkan ID
    public function update($id_nilai = null)
    {
        // Cek apakah data dengan ID tersebut ada
        $existing = $this->m_nilainilai->find($id_nilai);
        if (!$existing) {
            return $this->failNotFound("ID nilai tidak ditemukan!");
        }

        // Ambil data dari request body (PUT/RAW input)
        $data = $this->request->getRawInput();

        // Update data
        if ($this->m_nilainilai->update($id_nilai, $data)) {
            return $this->respond([
                "status" => 200,
                "message" => "Data berhasil diperbarui!",
                "data" => $data
            ]);
        } else {
            return $this->failValidationErrors($this->m_nilainilai->errors());
        }
    }

    // Endpoint: DELETE /api/nilai/{id}
    // Menghapus data nilai berdasarkan ID
    public function delete($id_nilai = null)
    {
        // Cek apakah data ada
        $data = $this->m_nilainilai->find($id_nilai);

        if (!$data) {
            return $this->failNotFound("Nilai dengan ID $id_nilai tidak ditemukan.");
        }

        // Hapus data
        if ($this->m_nilainilai->delete($id_nilai)) {
            return $this->respondDeleted([
                "status" => 200,
                "message" => "ID nilai berhasil dihapus."
            ]);
        } else {
            return $this->failServerError("Gagal menghapus data.");
        }
    }

    // Endpoint: GET /api/nilai/matkul/{id_matkul}
    // Menampilkan data nilai berdasarkan ID matkul untuk dosen (dari view atau join)
    public function gets($id_matkul = null)
    {
        $data = $this->m_nilainilai->vw_dosen($id_matkul);

        return $this->respond([
            "status" => 200,
            "message" => "Data berhasil diambil!",
            "data" => $data
        ]);
    }
}
