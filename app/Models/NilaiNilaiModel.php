<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiNilaiModel extends Model
{
    protected $table            = 'nilai_nilai';
    protected $primaryKey       = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_dosen', 'id_matkul', 'NPM'];
    
    protected $useTimestamps = false;
    
    protected $db;
    
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    
    public function vw_dosen($id_matkul)
    {
        // Gunakan query binding agar aman dari SQL Injection
        $sql = "SELECT
                    n.NPM,
                    m.nama_mahasiswa,
                    m.kelas,
                    dn.nilai_tugas,
                    dn.nilai_uts,
                    dn.nilai_uas,
                    n.nilai_akhir
                FROM
                    nilai_nilai n
                JOIN mahasiswa m ON m.NPM = n.NPM
                JOIN mata_kuliah mk ON mk.id_matkul = n.id_matkul
                JOIN detail_nilai dn ON dn.id_nilai = n.id_nilai
                WHERE n.id_matkul = ?
                ORDER BY m.nama_mahasiswa ASC";
        
        return $this->db->query($sql, [$id_matkul])->getResultArray();
    }
    
    public function getAllNilai()
    {
        return $this->db->table('nilai_nilai n')
        ->select('n.id_nilai, d.id_dosen, m.NPM, m.nama_mahasiswa, p.nama_prodi, mk.nama_matkul, d.nama_dosen, n.nilai_akhir')
        ->join('mahasiswa m', 'n.NPM = m.NPM')
        ->join('prodi p', 'm.id_prodi = p.id_prodi')
        ->join('mata_kuliah mk', 'n.id_matkul = mk.id_matkul')
        ->join('dosen d', 'n.id_dosen = d.id_dosen')
        ->get()
        ->getResultArray();
    }
    
    public function getDetailByNPM($npm)
    {
        return $this->db->table('nilai_nilai n')
        ->select('
            n.id_nilai,
            d.id_dosen,
            dn.id_detail,
            mk.id_matkul,
            n.NPM,
            m.nama_mahasiswa,
            p.nama_prodi,
            mk.nama_matkul,
            d.nama_dosen,
            dn.nilai_tugas,
            dn.nilai_uts,
            dn.nilai_uas,
            n.nilai_akhir
        ')
        ->join('mahasiswa m', 'n.NPM = m.NPM')
        ->join('prodi p', 'm.id_prodi = p.id_prodi', 'left')
        ->join('mata_kuliah mk', 'n.id_matkul = mk.id_matkul', 'left')
        ->join('dosen d', 'n.id_dosen = d.id_dosen', 'left')
        ->join('detail_nilai dn', 'n.id_nilai = dn.id_nilai', 'left')
        ->where('n.NPM', $npm)
        ->get()
        ->getResultArray();
    }

    public function getDetailById($id)
    {
        return $this->db->table('nilai_nilai n')
        ->select('
            n.id_nilai,
            n.NPM,
            m.nama_mahasiswa,
            dn.id_detail,
            p.nama_prodi,
            mk.nama_matkul,
            d.nama_dosen,
            dn.nilai_tugas,
            dn.nilai_uts,
            dn.nilai_uas,
            n.nilai_akhir,
            d.id_dosen,
            mk.id_matkul
        ')
        ->join('mahasiswa m', 'n.NPM = m.NPM')
        ->join('prodi p', 'm.id_prodi = p.id_prodi', 'left')
        ->join('mata_kuliah mk', 'n.id_matkul = mk.id_matkul', 'left')
        ->join('dosen d', 'n.id_dosen = d.id_dosen', 'left')
        ->join('detail_nilai dn', 'n.id_nilai = dn.id_nilai', 'left')
        ->where('n.id_nilai', $id)
        ->get()
        ->getResultArray();
    }
    
}
