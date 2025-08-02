<?php

namespace App\Models;

use App\Core\Database;

/**
 * SliderModel sınıfı, slider veritabanı işlemlerini yönetir.
 */
class SliderModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * SliderModel constructor.
     * Veritabanı bağlantısını başlatır.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Aktif sliderları getirir.
     *
     * @return array Aktif sliderlar
     */
    public function getActiveSliders()
    {
        $stmt = $this->db->query("SELECT * FROM sliders WHERE status = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }

    /**
     * Belirli bir ID'ye sahip sliderı getirir.
     *
     * @param int $id Slider ID
     * @return array Slider verisi
     */
    public function getSliderById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM sliders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Yeni bir slider oluşturur.
     *
     * @param array $data Slider verisi
     * @return bool İşlem sonucu
     */
    public function createSlider($data)
    {
        $stmt = $this->db->prepare("INSERT INTO sliders (image_url, title, description, link_url, status, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['image_url'], $data['title'], $data['description'], $data['link_url'], $data['status'], $data['sort_order']]);
    }

    /**
     * Belirli bir ID'ye sahip sliderı günceller.
     *
     * @param int $id Slider ID
     * @param array $data Güncellenmiş slider verisi
     * @return bool İşlem sonucu
     */
    public function updateSlider($id, $data)
    {
        $query = "UPDATE sliders SET title = ?, description = ?, link_url = ?, status = ?, sort_order = ?";
        $params = [$data['title'], $data['description'], $data['link_url'], $data['status'], $data['sort_order']];

        if (isset($data['image_url'])) {
            $query .= ", image_url = ?";
            $params[] = $data['image_url'];
        }

        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Belirli bir ID'ye sahip sliderı siler.
     *
     * @param int $id Slider ID
     * @return bool İşlem sonucu
     */
    public function deleteSlider($id)
    {
        $stmt = $this->db->prepare("DELETE FROM sliders WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Tüm sliderları getirir.
     *
     * @return array Tüm sliderlar
     */
    public function getAllSliders()
    {
        $stmt = $this->db->query("SELECT * FROM sliders ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}