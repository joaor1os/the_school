<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        // Configurações do servidor SMTP do Titan
        $this->mail->isSMTP();
        $this->mail->Host = 'ssl://smtp.titan.email'; // Servidor SMTP do Titan
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'tcc@theschool.fun'; // Seu e-mail do Titan
        $this->mail->Password = 'Tcc2024@'; // Sua senha do e-mail do Titan
        $this->mail->SMTPSecure = 'ssl'; // ou 'ssl' se preferir
        $this->mail->Port = 465; // Porta para TLS (use 465 para SSL)

        // Endereço do remetente
        $this->mail->setFrom('tcc@theschool.fun', 'TheSchoolTCC
');
    }

    public function send($to, $subject, $body) {
        try {
            // Adicionar destinatário
            $this->mail->addAddress($to);

            // Conteúdo do e-mail
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            // Enviar o e-mail
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Erro ao enviar e-mail: ', $this->mail->ErrorInfo;
            return false;
        }
    }
}
?>
