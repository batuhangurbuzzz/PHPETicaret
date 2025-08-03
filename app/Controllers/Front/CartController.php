<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\CartModel;

class CartController extends BaseController
{
    /**
     * @var CartModel $cartModel Sepet modeli örneği
     */
    private $cartModel;

    /**
     * CartController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve CartModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
    }

    /**
     * Sepet sayfasını görüntüler.
     */
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        } else {
            $cartItems = [];
        }

        // Verileri view'a gönder
        $this->render('front/cart/index', [
            'cartItems' => $cartItems
        ]);
    }

    /**
     * Sepete ürün ekler.
     */
    public function addToCart()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1; // Varsayılan olarak 1

            if ($userId && $productId) {
                $this->cartModel->addToCart($userId, $productId, $quantity);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }

    /**
     * Sepetten ürün çıkarır.
     */
    public function removeFromCart()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if ($userId && $productId) {
                $this->cartModel->removeFromCart($userId, $productId);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }

    /**
     * Sepetteki ürün miktarını artırır.
     */
    public function increaseQuantity()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if ($userId && $productId) {
                $this->cartModel->increaseQuantity($userId, $productId);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }

    /**
     * Sepetteki ürün miktarını azaltır.
     */
    public function decreaseQuantity()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if ($userId && $productId) {
                $this->cartModel->decreaseQuantity($userId, $productId);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }
}