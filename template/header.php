<!DOCTYPE html>
<html lang="<?php echo $langPrefix; ?>">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de contact</title>

    
    <script src="https://www.google.com/recaptcha/api.js?render='<?php echo $json_data['security']['google']['recaptcha']['v3']['site-public']; ?>'"></script>
    <script>
        function onSubmit(event) {
            event.preventDefault();
            grecaptcha.execute('<?php echo $json_data['security']['google']['recaptcha']['v3']['site-public']; ?>', { action: 'contact' }).then(function(token) {
                document.getElementById('recaptchaResponse').value = token;
                document.getElementById('contactForm').submit();
            });
        }
    </script>
</head>