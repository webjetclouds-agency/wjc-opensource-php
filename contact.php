<?php

use PHPMailer\PHPMailer\PHPMailer;

$msg = '';

if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');
    require 'vendor/autoload.php';

    $recaptcha_secret = 'YOUR_SECRET_KEY';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
    
    $response = file_get_contents($verify_url);
    $response_data = json_decode($response);
    
    if ($response_data->success) {
        $mail = new PHPMailer();
        $mail->setFrom('from@example.com', 'First Last');

        if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
            $mail->Subject = 'PHPMailer contact form';
            $mail->isHTML(false);
            $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Message: {$_POST['message']}
Department: {$_POST['dept']}
EOT;
            
            if (!$mail->send()) {
                $msg = 'Désolé, une erreur est survenue. Veuillez réessayer plus tard.';
            } else {
                $msg = 'Message envoyé ! Merci de nous avoir contactés.';
            }
        } else {
            $msg = 'Adresse e-mail invalide, message ignoré.';
        }
    } else {
        $msg = 'Vérification reCAPTCHA échouée. Veuillez réessayer.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de contact</title>
    <script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY"></script>
    <script>
        function onSubmit(event) {
            event.preventDefault();
            grecaptcha.execute('YOUR_SITE_KEY', { action: 'submit' }).then(function(token) {
                document.getElementById('recaptchaResponse').value = token;
                document.getElementById('contactForm').submit();
            });
        }
    </script>
</head>
<body>
<h1>Contactez-nous</h1>
<form id="contactForm" method="POST" onsubmit="onSubmit(event)">
    <label for="name">Nom : <input type="text" name="name" id="name" required></label><br>
    <label for="email">Adresse e-mail : <input type="email" name="email" id="email" required></label><br>
    <label for="message">Message : <textarea name="message" id="message" rows="8" cols="20" required></textarea></label><br>

    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
    <input type="submit" value="Envoyer">
</form>
<?php if (!empty($msg)) { echo "<h2>$msg</h2>"; } ?>
</body>
</html>
