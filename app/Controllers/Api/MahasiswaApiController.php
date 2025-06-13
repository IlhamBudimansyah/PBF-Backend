<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use CodeIgniter\API\ResponseTrait;

class MahasiswaApiController extends BaseController
{
    use ResponseTrait;
    protected $m_mahasiswa;

    public function __construct()
    {
        // Inisialisasi model Mahasiswa
        $this->m_mahasiswa = new MahasiswaModel();
    }

    /**
     * GET /mahasiswa
     * Menampilkan seluruh data mahasiswa
     */
    public function index()
    {
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_mahasiswa->orderBy("NPM", "ASC")->findAll()
        ];
        return $this->respond($res);
    }

    /**
     * GET /mahasiswa/{NPM}
     * Menampilkan data mahasiswa berdasarkan NPM
     */
    public function show($NPM)
    {
        $data = $this->m_mahasiswa->find($NPM);

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("Mahasiswa dengan NPM $NPM tidak ditemukan.");
        }
    }

    /**
     * POST /mahasiswa
     * Menambahkan data mahasiswa baru
     */
    public function create()
    {
        $data = [
            'NPM' => $this->request->getPost('NPM'),
            'nama_mahasiswa' => $this->request->getPost('nama_mahasiswa'),
            'alamat' => $this->request->getPost('alamat'),
            'kelas' => $this->request->getPost('kelas'),
            'tahun_akademik' => $this->request->getPost('tahun_akademik'),
            'id_prodi' => $this->request->getPost('id_prodi')
        ];

        // Simpan data ke database
        $this->m_mahasiswa->insert($data);

        $res = [
            "status" => 200,
            "message" => "Berhasil membuat data!",
            "data" => $data
        ];
        return $this->respond($res);
    }

    /**
     * PUT /mahasiswa/{NPM}
     * Mengupdate data mahasiswa berdasarkan NPM
     */
    public function update($NPM)
    {
        $data = $this->request->getRawInput(); // Ambil data dari PUT/RAW JSON

        if ($this->m_mahasiswa->update($NPM, $data)) {
            return $this->respond(['message' => 'Mahasiswa berhasil diupdate.']);
        } else {
            return $this->failValidationErrors($this->m_mahasiswa->errors());
        }
    }

    /**
     * DELETE /mahasiswa/{NPM}
     * Menghapus data mahasiswa berdasarkan NPM
     */
    public function delete($NPM)
    {
        $data = $this->m_mahasiswa->find($NPM);

        if ($data) {
            $this->m_mahasiswa->delete($NPM);
            return $this->respondDeleted([
                'status' => 203,
                'message' => 'Mahasiswa berhasil dihapus.'
            ]);
        } else {
            return $this->failNotFound("Data mahasiswa dengan NPM $NPM tidak ditemukan.");
        }
    }
}
