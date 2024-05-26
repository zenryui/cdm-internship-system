<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2;                      // Enable verbose debug output
        $mail->isSMTP();                           // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';      // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                  // Enable SMTP authentication
        $mail->Username   = 'cdm.ics.internship@gmail.com'; // Replace with your email address
        $mail->Password   = 'bhvgbxexullmszdk';    // Replace with your email password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;                   // TCP port to connect to

        // Recipients
        $mail->setFrom('cdm.ics.internship@gmail.com', 'CDM Internship');
        $mail->addAddress($to);                    // Add a recipient

        // Content
        $mail->isHTML(true);                       // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mail error: ' . $mail->ErrorInfo); // Log error message
        return false;
    }
}
?>
