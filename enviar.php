<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitização básica dos dados recebidos
    $nome     = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $assunto  = filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_SPECIAL_CHARS);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$email) {
        echo "erro_email_invalido";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configurações do Servidor SMTP do Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'propgamer2803@gmail.com';
        $mail->Password   = 'jnrm rbmi diko ueed'; // Sua senha de app de 16 dígitos
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Definições de Remetente e Destinatário
        $mail->setFrom('propgamer2803@gmail.com', 'Site Portfólio');
        $mail->addAddress('propgamer2803@gmail.com'); // Seu e-mail que receberá as mensagens
        $mail->addReplyTo($email, $nome);             // Quando responder, irá para o e-mail de quem preencheu

        // Conteúdo do E-mail
        $mail->isHTML(true);
        $mail->Subject = 'Contato do Site: ' . $assunto;
        $mail->Body    = "
            <h3>Nova mensagem recebida pelo formulário de contato</h3>
            <b>Nome:</b> $nome <br>
            <b>Email:</b> $email <br>
            <b>Assunto:</b> $assunto <br><br>
            <b>Mensagem:</b><br>" . nl2br($mensagem); // nl2br mantem as quebras de linha enviadas

        $mail->send();
        echo "ok";

    } catch (Exception $e) {
        // Se quiser debugar o erro real do PHPMailer em ambiente local, mude para: echo $mail->ErrorInfo;
        echo "erro";
    }
} else {
    echo "Metodo nao permitido";
}