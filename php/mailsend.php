<?php
session_start();

$fmail = $_SESSION['mail'];
$user = $_SESSION['uname'];
$code = $_SESSION['tempcode'];
echo $code;
$send;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// include '../../mailphp/include/PHPMailer.php';
// include '../../mailphp/include/SMTP.php';
require_once("../../mailphp/include/PHPMailer.php");
require_once("../../mailphp/include/SMTP.php");
// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);
try {
    // Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = 'noreply9448@gmail.com'; // YOUR gmail email
    $mail->Password = 'n0r5plym19l'; // YOUR gmail password
    // Sender and recipient settings
    $mail->setFrom('noreply9448@gmail.com', 'REPLY');
    $mail->addAddress("$fmail", "$user");
    $mail->addReplyTo('noreply9448@gmail.com', 'REPLY'); // to set the reply to
    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Reset Password";
    $mail->Body = "<p>Dear User,</p><p>Here are the password reset code as per your request.</p>
                    <label>User ID: </label><b>$user</b><br>
                    <label>Reset Password Code: </label><b>$code</b>";
    $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
    $mail->send();
    $mail->SMTPDebug = 0;
    // header('Location:./forpass.php');
} catch (Exception $e) {
    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!-- <html>
    <head>
        <title>Reset Code</title>
    </head>
    <body>
        <form action="../forgotpass.php" method="post">
            <table>
                <tr>
                    <td>
                        <input type="number" name="passcode" id="" placeholder="Enter Reset Code" maxlength = "6" pattern = "[0-9]{6}" oninput="check(this)" required>
                        <script>
                            function check(num) {
                                let code = <?php echo $code; ?>;
                                if(num.value != code) {
                                    inp.setCustomValidity("Verification Code is not Matching!!");
                                }
                            }
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Reset" name="" id="">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html> -->