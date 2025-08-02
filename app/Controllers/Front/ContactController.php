<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use App\Helpers\Mailer;

class ContactController extends BaseController
{
    /**
     * ContactController constructor.
     * Üst sınıfın constructor'ını çağırır.
     */
    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
    }

    /**
     * İletişim formu sayfasını render eder.
     *
     * @return void
     */
    public function index()
    {
        $this->render('front/contact');
    }

    /**
     * İletişim formu gönderimini işler.
     *
     * @return void
     */
    public function sendContactForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $message = trim($_POST['message']);

            $errors = [];

            // Temel doğrulamalar
            if (empty($name)) {
                $errors[] = "İsim alanı boş olamaz.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Geçerli bir e-posta adresi giriniz.";
            }

            if (empty($message)) {
                $errors[] = "Mesaj alanı boş olamaz.";
            }

            if (!empty($errors)) {
                $this->render('front/contact', ['error' => implode('<br>', $errors)]);
                return;
            }

            $mailer = new Mailer(new PHPMailer(true));
            $subject = "Yeni İletişim Formu Mesajı";
            $body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                        .header { background-color: #f7f7f7; padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
                        .content { padding: 20px; }
                        .footer { background-color: #f7f7f7; padding: 10px; text-align: center; border-top: 1px solid #ddd; }
                        .footer p { margin: 0; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Yeni İletişim Formu Mesajı</h2>
                        </div>
                        <div class='content'>
                            <p><strong>Ad:</strong> $name</p>
                            <p><strong>Email:</strong> $email</p>
                            <p><strong>Mesaj:</strong></p>
                            <p>$message</p>
                        </div>
                        <div class='footer'>
                            <p>Bu mesaj EticaretV5 sistemi tarafından gönderilmiştir.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $result = $mailer->sendMail('info@emrahyuksel.com.tr', $subject, $body);

            if ($result === true) {
                $this->render('front/contact', ['success' => "Mesajınız başarıyla gönderildi."]);
            } else {
                $this->render('front/contact', ['error' => $result]);
            }
        } else {
            header('Location: /contact');
            exit();
        }
    }
}