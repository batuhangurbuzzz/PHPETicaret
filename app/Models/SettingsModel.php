<?php

namespace App\Models;

use App\Core\Database;

/**
 * SettingsModel sınıfı, uygulama ayarlarını yönetmek için kullanılır.
 */
class SettingsModel
{
    /**
     * @var \PDO Veritaban�� bağlantısı
     */
    private $db;

    /**
     * SettingsModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm ayarları alır.
     *
     * @return array Ayarların anahtar-değer çiftleri olarak döner.
     */
    public function getAllSettings(): array
    {
        // Sadece setting_key ve setting_value sütunlarını al
        $stmt = $this->db->query("SELECT setting_key, setting_value FROM settings");

        // PDO::FETCH_KEY_PAIR ile anahtar-değer çiftleri döndür
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    /**
     * Belirli bir ayarı günceller.
     *
     * @param string $key Ayar anahtarı
     * @param string $value Ayar değeri
     * @return bool Güncelleme başarılıysa true, aksi halde false döner
     */
    public function updateSetting(string $key, string $value): bool
    {
        // Ayarı güncelle
        $stmt = $this->db->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");

        return $stmt->execute([':key' => $key, ':value' => $value]);
    }
}