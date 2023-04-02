<?php

namespace Models;
use Controllers\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

class Mail
{
    private $mail;
    private $recipients;
    public function __construct(Array $mail_info)
    {
        $config = new Config();
        $mail_config = $config->get()[0]["mail"];
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $mail_config["smtp_host"];
        if($mail_config["secure_connection"]["use"])
        {
            if($mail_config["secure_connection"]["type"] == "tls")
            {
                $mail->SMTPSecure = 'tls';
            }else if($mail_config["secure_connection"]["type"] == "tls")
            {
                $mail->SMTPSecure = 'ssl';
            }
        }
        $mail->SMTPAuth = true;
        $mail->Username = $mail_config["smtp_username"];
        $mail->Password = $mail_config["smtp_password"];
        $mail->Port = $mail_config["smtp_port"];
        $mail->setFrom($mail_config["smtp_email_sender"]);
        //EMAIL RECIPIENTS
        foreach($mail_info["recipients"] as $key => $value)
        {
            $mail->addAddress($value);
        }
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = $mail_info["subject"];
        $mail->Body    = $mail_info["body"];
        if(isset($mail_info["alt_body"]))
        {
            $mail->AltBody = $mail_info["alt_body"];
        }
        $this->mail = $mail;
    }
    public function send()
    {
        $mail = $this->mail;
        try
        {
            if(!$mail->send())
            {
                //echo 'Não foi possível enviar a mensagem.<br>';
                //echo 'Erro: ' . $mail->ErrorInfo;
            } else
            {
                //echo 'Mensagem enviada.';
            }
        }catch(\Exception)
        {
            return;
        }
    }
    /*
      |======================|
      |  TEMPLATE DE EMAIL  |
     |======================|

        $mail = new \Models\Mail([
            "recipients"=>[
                "rodrigonascimentoquintanilha@hotmail.com"
            ],
            "subject"=>"Assunto do email",
            "body"=>"Este é o conteúdo da não mensagem sem <b>HTML!</b>",
            "alt_body"=>"Mensagem alternativa para clients que não suportem HTML"
        ]);

        $mail->send();

    */
}
