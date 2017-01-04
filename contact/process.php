<?php
require 'mailer/PHPMailerAutoload.php';

$name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
$to = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
$message = trim(filter_input(INPUT_POST,"message",FILTER_SANITIZE_SPECIAL_CHARS));

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'edevesweb@gmail.com';                 // SMTP username. Also Show as From
$mail->Password = 'subroto99';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('subroto.iu@gmail.com', 'Subroto Biswas'); // Show Header after opening mail
$mail->addAddress($to, $name);     // Add a recipient
// $mail->addReplyTo('subroto.iu@gmail.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Message form ' . $name;
$mail->Body    = $message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if( $mail->send() ) {
  // echo 'Message has been sent';
  echo json_encode(array('status' => 'success','message'=> 'Message sent succefully'));
  // JSON Result: {"status":"success","message":"Message sent succefully"}
} else {
  // echo 'Message could not be sent.';
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
  echo json_encode(array('status' => 'error','message'=> 'Message not sent'));
}
