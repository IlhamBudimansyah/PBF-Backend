<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;
use CodeIgniter\API\ResponseTrait;

class MatkulApiController  extends BaseController {
    use ResponseTrait;
    protected $m_matkul;
    
    public function __construct()
    {
        $this->m_matkul = new MataKuliahModel();
    }
    
    public function index(){
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_matkul->findAll()
        ];
        return $this->respond($res);
        
    }
    
    public function showById($id_matkul = null)
    {
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
    
    public function getByIdDosen($id_dosen = null)
    {
        if (!$id_dosen) {
            return $this->respond([
                "status" => 400,
                "message" => "ID Dosen tidak valid",
                "data" => []
            ]);
        }
        
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
    
    
    
    public function create()
    {
        $data = [
            "id_dosen"  => $this->request->getPost("id_dosen"),
            "id_matkul"  => $this->request->getPost("id_matkul"),
            "nama_matkul" => $this->request->getPost("nama_matkul"),
            "sks"       => $this->request->getPost("sks"),
            "semester"       => $this->request->getPost("semester")
        ];
        
        $this->m_matkul->insert($data);
        
        return $this->respondCreated([
            "status" => 201,
            "message" => "Nilai berhasil dibuat!",
            'data' => $data
        ]);
    }
    
    public function delete($id_matkul = null)
    {
        $data = $this->m_matkul->find($id_matkul);
        
        if (!$data) {
            return $this->failNotFound("Nilai dengan ID $id_matkul tidak ditemukan.");
        }
        
        if ($this->m_matkul->delete($id_matkul)) {
            return $this->respondDeleted([
                "status" => 200,
                "message" => "ID nilai berhasil dihapus."
            ]);
        } else {
            return $this->failServerError("Gagal menghapus data.");
        }
    }
    
    public function update($id_matkul)
    {
        $data = $this->request->getRawInput();
        
        if ($this->m_matkul->update($id_matkul, $data)) {
            return $this->respond(['message' => 'Mata kuliah berhasil diupdate.']);
        } else {
            return $this->failValidationErrors($this->m_matkul->errors());
        }
    }
}

?>