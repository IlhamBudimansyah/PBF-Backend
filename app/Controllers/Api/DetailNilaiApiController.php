<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DetailNilaiModel;
use CodeIgniter\API\ResponseTrait;

class DetailNilaiApiController extends BaseController
{
    use ResponseTrait;
    protected $m_nilai;

    public function __construct()
    {
        // Inisialisasi model DetailNilaiModel saat controller dibuat
        $this->m_nilai = new DetailNilaiModel();
    }

    /**
     * Endpoint GET /detailnilai
     * Mengambil semua data detail nilai dari database
     */
    public function index()
    {
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_nilai->orderBy("id_detail", "ASC")->findAll() // Ambil semua data urut berdasarkan id_detail
        ];
        return $this->respond($res); // Mengirimkan response dalam format JSON
    }

    /**
     * Endpoint GET /detailnilai/{id}
     * Mengambil data nilai berdasarkan id_detail
     */
    public function show($id_detail)
    {
        $model = new DetailNilaiModel();
        $data = $model->find($id_detail); // Cari data berdasarkan id_detail

        if ($data) {
            return $this->respond($data); // Jika data ditemukan, kirim datanya
        } else {
            return $this->failNotFound("Nilai dengan ID $id_detail tidak ditemukan."); // Jika tidak, kirim not found
        }
    }

    /**
     * Endpoint POST /detailnilai
     * Menambahkan data nilai baru ke database
     */
    public function create()
    {
        // Ambil data dari POST request
        $data = [
            "id_nilai" => $this->request->getPost("id_nilai"),
            "nilai_tugas" => $this->request->getPost("nilai_tugas"),
            "nilai_uts" => $this->request->getPost("nilai_uts"),
            "nilai_uas" => $this->request->getPost("nilai_uas"),
        ];

        // Simpan ke database
        $this->m_nilai->insert($data);

        // Response sukses
        $res = [
            "status" => 201,
            "message" => "Nilai berhasil dibuat!",
            "data" => $data
        ];
        return $this->respond($res);
    }

    /**
     * Endpoint PUT /detailnilai/{id}
     * Mengupdate data nilai berdasarkan id_nilai
     */
    public function update($id_nilai)
    {
        $model = new DetailNilaiModel();
        $data = $this->request->getRawInput(); // Ambil data mentah dari PUT/PATCH

        if ($model->update($id_nilai, $data)) {
            return $this->respond(['message' => 'Nilai berhasil diupdate.']);
        } else {
            return $this->failValidationErrors($model->errors()); // Jika gagal validasi
        }
    }

    /**
     * Endpoint DELETE /detailnilai/{id}
     * Menghapus data nilai berdasarkan id_nilai
     */
    public function delete($id_nilai)
    {
        $model = new DetailNilaiModel();
        $data = $model->find($id_nilai); // Cari data sebelum menghapus

        if ($data) {
            $model->delete($id_nilai);
            return $this->respondDeleted(['message' => 'Nilai berhasil dihapus.']);
        } else {
            return $this->failNotFound("Nilai dengan ID $id_nilai tidak ditemukan.");
        }
    }
}
