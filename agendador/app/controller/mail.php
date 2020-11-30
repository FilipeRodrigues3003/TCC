<?php

    ini_set('display_errors', 1);

    error_reporting(E_ALL);

    $from = $_POST["nome"];

    $to = "filiperodrigues3003@gmail.com";

    $subject = "Mensagem sobre Agendador de " . $from;
    $email = $_POST["email"]; //assunto

    $message = $_POST["mensagem"];
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $headers .= "De:". $from ." <".$email.">";

    mail($to, $subject, $message, $headers);


?>
