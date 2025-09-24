<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'db.php';

if(isset($_POST['name']) && isset($_POST['email'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ryankagua@gmail.com';
        $mail->Password   = 'fouwgcdfbeyhyfnk';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('ryankagua@gmail.com', 'Ryan Kagua');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to ICS 2.2!';
        $mail->Body = "
<html>
<body>
<h2>Welcome to ICS 2.2!</h2>
<p>Hello " . htmlspecialchars($name) . ",</p>
<p>You requested an account on ICS 2.2</p>
<p><a href='http://localhost/TaskApp/index.php'>Click Here to complete registration.</a></p>
<p>Regards,<br>Systems Admin ICS 2.2</p>
</body>
</html>
";

        $mail->send();

        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$name, $email]);

        echo json_encode(['success' => true, 'message' => 'Welcome email sent!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Name and email are required.']);
}
?>
