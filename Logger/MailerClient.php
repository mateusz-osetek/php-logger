<?php

declare(strict_types=1);

namespace mosetek\Logger;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * @author Mateusz Osetek <osetek.mateusz@gmail.com>
 */

class MailerClient
{
    private const HOST = 'smtp.gmail.com';
    private const USERNAME = 'example@gmail.com';
    private const PASSWORD = 'secret_pass';
    private const SMTP_SECURE = 'tls';
    private const PORT = 587;

    public function send(string $to, string $attachment, string $message): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = self::HOST;
            $mail->SMTPAuth = true;
            $mail->Username = self::USERNAME;
            $mail->Password = self::PASSWORD;
            $mail->SMTPSecure = self::SMTP_SECURE;
            $mail->Port = self::PORT;
            $mail->setFrom(self::USERNAME);
            $mail->addAddress($to);
            $mail->addAttachment($attachment);
            $mail->Subject = 'Log file from ' . date('Y-m-d H:i:s');
            $mail->Body = $message ?: 'Find your file on the attachments section';
            $mail->send();
            echo "Message has been sent\n";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
        }
    }
}
