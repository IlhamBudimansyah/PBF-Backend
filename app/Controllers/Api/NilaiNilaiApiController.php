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
        $this->m_nilainilai = new NilaiNilaiModel();
    }
    
    // GET /api/nilai
    public function index()
    {
        $data = $this->m_nilainilai->orderBy('id_nilai', 'DESC')->getAllNilai();
        
        return $this->respond([
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $data
        ]);
    }
    
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
    
    // POST /api/nilai
    public function create()
    {
        $data = [
            "id_dosen"  => $this->request->getPost("id_dosen"),
            "id_matkul" => $this->request->getPost("id_matkul"),
            "NPM"       => $this->request->getPost("NPM")
        ];
        
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
    
    // PUT /api/nilai/{id}
    public function update($id_nilai = null)
    {
        $existing = $this->m_nilainilai->find($id_nilai);
        if (!$existing) {
            return $this->failNotFound("ID nilai tidak ditemukan!");
        }
        
        $data = $this->request->getRawInput();
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
    
    // DELETE /api/nilai/{id}
    public function delete($id_nilai = null)
    {
        $data = $this->m_nilainilai->find($id_nilai);
        
        if (!$data) {
            return $this->failNotFound("Nilai dengan ID $id_nilai tidak ditemukan.");
        }
        
        if ($this->m_nilainilai->delete($id_nilai)) {
            return $this->respondDeleted([
                "status" => 200,
                "message" => "ID nilai berhasil dihapus."
            ]);
        } else {
            return $this->failServerError("Gagal menghapus data.");
        }
    }
    
    // GET /api/nilai/matkul/{id_matkul}
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
