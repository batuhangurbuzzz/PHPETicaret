<?php

namespace App\Models;

use App\Core\Database;

/**
 * AboutModel sınıfı, 'about' tablosu ile ilgili veritabanı işlemlerini yönetir.
 */
class AboutModel
{
    /**
     * @var \PDO Veritabanı bağlantısını tutar.
     */
    private $db;

    /**
     * AboutModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 'about' tablosundan tek bir kayıt getirir.
     *
     * @return array Veritabanından getirilen kayıt.
     */
    public function getAbout()
    {
        $stmt = $this->db->query("SELECT * FROM about LIMIT 1");
        return $stmt->fetch();
    }

    /**
     * 'about' tablosundaki kaydı günceller.
     *
     * @param array $data Güncellenecek veriler.
     * @return bool Güncelleme işleminin ba��arılı olup olmadığını belirtir.
     */
    public function updateAbout($data)
    {
        $stmt = $this->db->prepare("UPDATE about SET vision = ?, mission = ?, biography = ?, image1 = ?, image2 = ?, updated_at = CURRENT_TIMESTAMP WHERE id = 1");
        return $stmt->execute([$data['vision'], $data['mission'], $data['biography'], $data['image1'], $data['image2']]);
    }
}