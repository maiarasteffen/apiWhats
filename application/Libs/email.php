<?php
namespace Mini\Libs;

require ROOT.'\application\Libs\phpmailer\src\Exception.php';
require ROOT.'\application\Libs\phpmailer\src\PHPMailer.php';
require ROOT.'\application\Libs\phpmailer\src\SMTP.php';

use Mini\Model\dbConfiguracao;

class Email
{
	// public function sendEmail($mensagem)
    // {
	// 	$configEmail = (new dbConfiguracao())->getConfiguracaoEmail();	

	// 	// Instantiation and passing `true` enables exceptions
	// 	$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

	// 	try {
	// 	    //Server settings
	// 	    // $mail->SMTPDebug = 3;                      // Enable verbose debug output
	// 	    $mail->isSMTP();                                            // Send using SMTP
	// 	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication		    
	// 	    $mail->Host       = $configEmail['smtp'];                   // Set the SMTP server to send through
	// 	    $mail->Port       = $configEmail['porta'];                  // TCP port to connect to		    
	// 	    $mail->Username   = $configEmail['email'];                  // SMTP username
	// 	    $mail->Password   = $configEmail['senha'];                  // SMTP password

    //         if ($configEmail['autenticacao'] == 1) { //SSL
    //             $mail->SMTPSecure = "ssl";
    //         } else if ($configEmail['autenticacao'] == 2) { //TLS
    //             $mail->SMTPSecure = "tls";
    //             $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
    //         }
	// 	    // $mail->setLanguage('pt_br', 'language/');

	// 	    //Recipients
	// 	    $mail->setFrom($configEmail['email'], 'INTEGRACAO '.$configEmail['nome']);
	// 	    $mail->addAddress('eduardo@queroestaronline.com.br', 'Eduardo WGR');     // Add a recipient
	// 	    // $mail->addCC('leonardo@queroestaronline.com.br' ,'Leonardo WGR');

	// 	    // Content
	// 	    $mail->isHTML(true);                                  // Set email format to HTML
	// 	    // $mail->CharSet = "utf-8";
	// 	    $mail->Subject = '*** ALERTA INTEGRACAO ***';
	// 	    $mail->Body    = $mensagem;
	// 	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	// 	    $mail->send();
	// 	    echo 'Message has been sent';
	// 	} catch (Exception $e) {
	// 		registerLog("Email não pode ser enviado: ".$mail->ErrorInfo);
	// 	}

    // }
}