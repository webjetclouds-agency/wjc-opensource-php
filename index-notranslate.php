<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use ReCaptcha\ReCaptcha;
use App\LanguageManager;

$json_files = glob(__DIR__ . "/config/*.json");
$json_data = json_decode(file_get_contents($json_files[0]), true);
$langManager = new LanguageManager('fr');

require __DIR__ . '/vendor/autoload.php';

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    // Liens vers différents fichiers .tpl
    $templates = [
        'contact' => 'template/contact.php', 
        'about'   => 'template/about.php',
        'home'    => 'template/home.php' 
    ];

    if (array_key_exists($slug, $templates)) {

        // Ajout des liens vers les fichiers tpl
        echo "<h2>Autres modèles</h2>";
        foreach ($templates as $slug_key => $templates) {
            echo "<a href='/$slug_key'>$slug_key - $templates</a><br>";
        }

    } else {
        echo "<h1>404 - Page non trouvée</h1>";
    }
} else {
    include_once __DIR__ . '/header.php';
    /**
     * echo "<h1>Bienvenue sur mon site</h1>";
    *
    * // Affichage des liens vers les différents fichiers tpl
    * echo "<h2>Liens vers d'autres modèles</h2>";
    * foreach ($templates as $slug_key => $templates) {
    *    echo "<a href='/$slug_key'>$slug_key - $templates</a><br>";
    * }
    **/
    include_once __DIR__ . '/home.php';
    include_once __DIR__ . '/footer.php';
}
?>
