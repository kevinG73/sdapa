<?php

require_once('PHPMailer/PHPMailerAutoload.php');


function send_mail ($destinataire,$sujet,$message)
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail -> SMTPAuth = true;
    $mail -> SMTPSecure = 'ssl';
    $mail ->Host = 'mail.syge.ufhb.ci';
    $mail ->Port = '465';
    $mail->isHTML();
    $mail->Username= 'sdap@syge.ufhb.ci';
    $mail->Password='9o@qZJgojJuJ';
    $mail->SetFrom($destinataire);
    $mail->Subject = $sujet;
    $mail->Body = $message;
    $mail->AddAddress($destinataire);

    $mail->Send();

}

?>
