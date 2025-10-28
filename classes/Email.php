<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        $email = new PHPMailer(true);
        try {
            $email->isSMTP();
            $email->Host = $_ENV['EMAIL_HOST'];
            $email->SMTPAuth = true;
            $email->Username = $_ENV['EMAIL_USER'];
            $email->Password = $_ENV['EMAIL_PASS'];
            $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $email->Port = $_ENV['EMAIL_PORT'];
            
            // Opciones adicionales para mejorar la compatibilidad
            $email->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //$email->SMTPDebug = 2; // Cambiar a 2 para debug detallado

            $email->setFrom('admin@solarix-sass.com', 'Admin');
            $email->addAddress($this->email, $this->nombre);
            $email->Subject = 'Confirma Tu Cuenta';
            $email->isHTML(true);
            $contenido = '<Html><p><strong>Hola ' . $this->nombre . '</strong></p>';
            $contenido .= '<p>Para confirmar tu cuenta, haz clic en el siguiente enlace:</p>';
            $contenido .= "<a href='".$_ENV['APP_URLD']."/confirmar-cuenta?token= ". $this->token ."'>Confirmar Cuenta</a> ";
            $contenido .= '<p>Si no solicitaste este cambio, ignora este mensaje</p>';
            $contenido .= '<p>Si tienes alguna pregunta, responde a este mensaje</p>';
            $contenido .= '</Html>';
            $email->Body = $contenido;
            $email->send();
            echo 'Mensaje enviado correctamente';

        }
        catch (Exception $e) {  
        echo " Error: {$email->ErrorInfo}";
    }

}

public function enviarInstrucciones() {
    $email = new PHPMailer(true);
    try {
        $email->isSMTP();
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASS'];
        $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $email->Port = $_ENV['EMAIL_PORT'];
         // Opciones adicionales para mejorar la compatibilidad
         $email->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $email->setFrom('admin@solarix-sass.com', 'Admin');
        $email->addAddress($this->email, $this->nombre);
        $email->Subject = 'Reestablecer Tu Password';
        $email->isHTML(true);
        $contenido = '<Html><p><strong>Hola ' . $this->nombre . '</strong></p>';
        $contenido .= '<p>Para restablecer tu password, haz clic en el siguiente enlace:</p>';
        $contenido .= "<a href='".$_ENV['APP_URLD']."/recuperar-password?token=". $this->token ."'>Reestablecer Password</a> ";
        $contenido .= '<p>Si no solicitaste este cambio, ignora este mensaje</p>';
        $contenido .= '<p>Si tienes alguna pregunta, responde a este mensaje</p>';
        $contenido .= '</Html>';
        $email->Body = $contenido;
        $email->send();
        echo 'Mensaje enviado correctamente';
        }
        catch (Exception $e) {
        echo " Error: {$email->ErrorInfo}";
        }
    }
}