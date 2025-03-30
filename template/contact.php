<?php
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    date_default_timezone_set($json_data['core']['site']['timezone']);
    require __DIR__ . '/vendor/autoload.php'; // Correction du chemin

    $recaptcha_secret = $json_data['security']['google']['recaptcha']['v3']['site-private'];
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

    if (!empty($recaptcha_response)) {
        $recaptcha = new ReCaptcha($recaptcha_secret);
        $resp = $recaptcha->verify($recaptcha_response, $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP(); // Ajoutez votre configuration SMTP si nécessaire
                $mail->Host = 'smtp.example.com'; // Remplacez par votre serveur SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'votre_email@example.com'; // Remplacez par votre identifiant SMTP
                $mail->Password = 'votre_mot_de_passe'; // Remplacez par votre mot de passe SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port = 587;

                $mail->setFrom($json_data['core']['site']['name'], $json_data['core']['site']['name']);
                $mail->addReplyTo(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), htmlspecialchars($_POST['name']));

                $mail->Subject = $_POST['subject'];
                $mail->isHTML(true);
                $mail->Body = nl2br($langManager->getTranslation('email.email').": " . htmlspecialchars($_POST['email']) . "\n".$langManager->getTranslation('email.name').": " . htmlspecialchars($_POST['name']) . "\n".$langManager->getTranslation('email.message').": " . htmlspecialchars($_POST['message']));

                if ($mail->send()) {
                    $msg = $langManager->getTranslation('email.error.success');
                } else {
                    $msg = $langManager->getTranslation('email.error.failure');
                }
            } catch (Exception $e) {
                $msg = 'Erreur PHPMailer : ' . $mail->ErrorInfo;
            }
        } else {
            $msg = $langManager->getTranslation('email.error.captcha.fail');
        }
    } else {
        $msg = $langManager->getTranslation('email.error.captcha.try');
    }
}

include_once __DIR__ . '/header.php';
?>

<body>
<h1>Contactez-nous</h1>
<form id="contactForm" method="POST" onsubmit="onSubmit(event)">
    <label for="name"><?php echo $langManager->getTranslation('email.subject'); ?> : <input type="text" name="subject" id="subject" required></label><br>
    <label for="name"><?php echo $langManager->getTranslation('email.name'); ?> : <input type="text" name="name" id="name" required></label><br>
    <label for="email"><?php echo $langManager->getTranslation('email.email'); ?> : <input type="email" name="email" id="email" required></label><br>
    <label for="message"><?php echo $langManager->getTranslation('email.message'); ?> : <textarea name="message" id="message" rows="8" cols="20" required></textarea></label><br>

    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
    <input type="submit" value="<?php echo $langManager->getTranslation('email.send'); ?>">
</form>
<?php if (!empty($msg)) { echo "<h2>$msg</h2>"; } ?>

<?php include_once __DIR__ . '/footer.php'; ?>