<?php
ignore_user_abort(true);
set_time_limit(0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    
    // Send instant response to the user
    ob_start();
    echo json_encode(["status" => "success", "message" => "Your request is being processed."]);
    header("Connection: close");
    header("Content-Length: " . ob_get_length());
    ob_end_flush();
    flush();

    // Process email in the background
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aditya.lohar@brightLinkinfotechnologies.com';
        $mail->Password   = 'Aditya@0000';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('aditya.lohar@brightLinkinfotechnologies.com', 'WOOF & MEOW');
        $mail->addAddress('tejaspatil0582@gmail.com', 'Recipient Name');

        $mail->Timeout = 10;
        $mail->SMTPKeepAlive = false;
        $mail->SMTPDebug = 0;
        $mail->isHTML(true);
        $mail->Subject = "New Service Inquiry from $firstName $lastName";

        // Email Content
        $mail->Body = "
        <div style='max-width: 600px; margin: auto; font-family: Arial, sans-serif;'>
            <div style='background-color: #6A3DA4; padding: 15px; color: white; text-align: center; border-radius: 8px 8px 0 0;'>
                <h1 style='margin: 0; font-size: 24px;'>🐶 WOOF & MEOW 🐱</h1>
            </div>

            <div style='padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;'>
                <p><strong>Dear Team,</strong></p>
                <p>A new service inquiry has been received. Below are the details:</p>

                <table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>
                    <tr>
                        <td style='padding: 8px; border: 1px solid #ddd;'><strong>Name:</strong></td>
                        <td style='padding: 8px; border: 1px solid #ddd;'>$firstName $lastName</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border: 1px solid #ddd;'><strong>Email:</strong></td>
                        <td style='padding: 8px; border: 1px solid #ddd;'>$email</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border: 1px solid #ddd;'><strong>Phone:</strong></td>
                        <td style='padding: 8px; border: 1px solid #ddd;'>$phone</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border: 1px solid #ddd;'><strong>Selected Service:</strong></td>
                        <td style='padding: 8px; border: 1px solid #ddd;'>$service</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border: 1px solid #ddd;'><strong>Message:</strong></td>
                        <td style='padding: 8px; border: 1px solid #ddd;'>$message</td>
                    </tr>
                </table>

                <p style='margin-top: 20px;'>Best regards,<br><strong>WOOF & MEOW</strong></p>
            </div>
        </div>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo); // Log errors without blocking response
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}
?>
