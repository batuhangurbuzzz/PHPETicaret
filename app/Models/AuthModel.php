<?php

namespace App\Models;

use App\Core\Database;

/**
 * AuthModel sınıfı, kullanıcı kimlik doğrulama işlemleri için gerekli olan
 * veritabanı işlemlerini gerçekleştiren sınıftır.
 */
class AuthModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * AuthModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir kullanıcı kaydı oluşturur.
     *
     * @param string $name Kullanıcı adı
     * @param string $email Kullanıcı e-posta adresi
     * @param string $password Kullanıcı şifresi
     * @param string $phone Kullanıcı telefon numarası
     * @return bool Kayıt işleminin başarılı olup olmadığını belirtir
     */
    public function registerUser($name, $email, $password, $phone)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password_hash, phone_number, role) VALUES (:name, :email, :password_hash, :phone_number, :role)");
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $passwordHash,
            ':phone_number' => $phone,
            ':role' => 'customer' // Varsayılan rol
        ]);
    }

    /**
     * E-posta adresine göre kullanıcı bilgilerini getirir.
     *
     * @param string $email Kullanıcı e-posta adresi
     * @return array|false Kullanıcı bilgileri veya başarısızlık durumunda false
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Kullanıcı giriş işlemini gerçekleştirir.
     *
     * @param string $email Kullanıcı e-posta adresi
     * @param string $password Kullanıcı şifresi
     * @return array|false Kullanıcı bilgileri veya başarısızlık durumunda false
     */
    public function loginUser($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }

    /**
     * Kullanıcı şifresini günceller.
     *
     * @param int $userId Kullanıcı ID'si
     * @param string $newPassword Yeni şifre
     * @return bool Güncelleme işleminin başarılı olup olmadığını belirtir
     */
    public function updatePassword($userId, $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :id");
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        return $stmt->execute([
            ':password_hash' => $passwordHash,
            ':id' => $userId
        ]);
    }

    /**
     * Kullanıcı ID'sine göre kullanıcı bilgilerini getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array|false Kullanıcı bilgileri veya başarısızlık durumunda false
     */
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}