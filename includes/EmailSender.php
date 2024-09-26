<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP do Google
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP do Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'theschooltcc@gmail.com';
        $mail->Password = 'zqze bvea oqvb vsei'; // Senha de app
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Endereço do remetente
        $mail->setFrom('theschooltcc@gmail.com', 'TheSchoolTCC');

        // Definir a codificação do e-mail para UTF-8
        $mail->CharSet = 'UTF-8';

        // Adicionar destinatário
        $mail->addAddress($to);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Enviar o e-mail
        $mail->send();
        echo "E-mail enviado com sucesso!";
    } catch (Exception $e) {
        echo 'Erro ao enviar e-mail: ', $mail->ErrorInfo;
    }
}
?>
