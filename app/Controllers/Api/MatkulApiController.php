<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;
use CodeIgniter\API\ResponseTrait;

class MatkulApiController extends BaseController 
{
    use ResponseTrait;
    protected $m_matkul;

    public function __construct()
    {
        // Inisialisasi model MataKuliah
        $this->m_matkul = new MataKuliahModel();
    }

    // Ambil semua data mata kuliah
    public function index() {
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_matkul->findAll()
        ];
        return $this->respond($res);
    }

    // Ambil data mata kuliah berdasarkan ID matkul
    public function showById($id_matkul = null)
    {
        // Mengambil detail berdasarkan ID dengan method custom getDetailById()
        $data = $this->m_matkul->getDetailById($id_matkul);

        if ($data) {
            return $this->respond([
                "status" => 200,
                "message" => "success",
                "data" => $data
            ]);
        } else {
            return $this->failNotFound("Tidak ada data nilai dengan ID $id_matkul.");
        }
    }

    // Ambil semua mata kuliah berdasarkan ID dosen
    public function getByIdDosen($id_dosen = null)
    {
        // Validasi: jika ID dosen tidak diisi
        if (!$id_dosen) {
            return $this->respond([
                "status" => 400,
                "message" => "ID Dosen tidak valid",
                "data" => []
            ]);
        }

        // Ambil data berdasarkan dosen
        $data = $this->m_matkul->getByDosen($id_dosen);

        if ($data) {
            return $this->respond([
                "status" => 200,
                "message" => "success",
                "data" => $data
            ]);
        } else {
            return $this->respond([
                "status" => 404,
                "message" => "Tidak ada mata kuliah untuk dosen ini",
                "data" => []
            ]);
        }
    }

    // Tambah data mata kuliah baru
    public function create()
    {
        // Ambil input dari form POST
        $data = [
            "id_dosen"    => $this->request->getPost("id_dosen"),
            "id_matkul"   => $this->request->getPost("id_matkul"),
            "nama_matkul" => $this->request->getPost("nama_matkul"),
            "sks"         => $this->request->getPost("sks"),
            "semester"    => $this->request->getPost("semester")
        ];

        // Simpan ke database
        $this->m_matkul->insert($data);

        // Kembalikan response sukses
        return $this->respondCreated([
            "status" => 201,
            "message" => "Nilai berhasil dibuat!",
            'data' => $data
        ]);
    }

    // Hapus mata kuliah berdasarkan ID
    public function delete($id_matkul = null)
    {
        // Cari data terlebih dahulu
        $data = $this->m_matkul->find($id_matkul);

        // Jika tidak ditemukan, kembalikan pesan error
        if (!$data) {
            return $this->failNotFound("Nilai dengan ID $id_matkul tidak ditemukan.");
        }

        // Jika ditemukan, hapus data
        if ($this->m_matkul->delete($id_matkul)) {
            return $this->respondDeleted([
                "status" => 200,
                "message" => "ID nilai berhasil dihapus."
            ]);
        } else {
            return $this->failServerError("Gagal menghapus data.");
        }
    }

    // Update data mata kuliah berdasarkan ID
    public function update($id_matkul)
    {
        // Ambil data dari request (biasa digunakan untuk PUT)
        $data = $this->request->getRawInput();

        // Update data di database
        if ($this->m_matkul->update($id_matkul, $data)) {
            return $this->respond(['message' => 'Mata kuliah berhasil diupdate.']);
        } else {
            return $this->failValidationErrors($this->m_matkul->errors());
        }
    }
}

?>
