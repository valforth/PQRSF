<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
require 'phpmailer/PHPMailerAutoload.php';
require 'DBManager.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'ssl';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "test-dev@itfip.edu.co";

//Password to use for SMTP authentication
$mail->Password = "test2015";

//Set who the message is to be sent from
$mail->setFrom('test-dev@itfip.edu.co', 'First Last');

//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
$correo = $_GET['correo'];
$id = $_GET['id'];
$queryP = $miConexion->verificationPassword('persona','correo',$correo);
$queryM = $miConexion->verificationPassword('mensaje','id',$id);
$mail->addAddress("{$queryP}", 'John Doe');
//Encriptacion del id para ser enviado por url
$queryMc = $t_hasher->HashPassword($queryM);
//Set the subject line'
$mail->Subject = 'PHPMailer GMail SMTP test';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$comentario = $_POST['cajaRespuesta'];
$correo1 = "http://desarrollo1.itfip.edu.co/PQRSDF/pruebaValidacion.php?correo={$queryMc}";
echo $correo1;
echo $comentario;

$mail->msgHTML("{$comentario},$correo1");



//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
