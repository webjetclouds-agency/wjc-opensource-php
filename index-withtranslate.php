<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use ReCaptcha\ReCaptcha;
use App\LanguageManager;

$json_files = glob(__DIR__ . "/config/*.json");
$json_data = json_decode(file_get_contents($json_files[0]), true);

// Detect language from URL or default to 'fr'
$langPrefix = isset($_GET['lang']) ? $_GET['lang'] : 'fr'; // Default to 'fr'
$langManager = new LanguageManager($langPrefix); // Use the detected language

require __DIR__ . '/vendor/autoload.php';

// Extract the slug and language from the URL (e.g., /fr/contact)
$slug = '';
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
} elseif (isset($_GET['lang']) && isset($_GET['slug'])) {
    $slug = $_GET['slug'];
}

$templates = [
    'contact' => 'template/contact.php', 
    'about'   => 'template/about.php',
    'home'    => 'template/home.php' 
];

if ($slug) {
    // Check if the requested page exists in the templates array
    if (array_key_exists($slug, $templates)) {
        // Load the corresponding template
        include_once __DIR__ . '/' . $templates[$slug];
        
        // Display links to other templates with language prefix
        echo "<h2>Autres modèles</h2>";
        foreach ($templates as $slug_key => $template) {
            echo "<a href='/$langPrefix/$slug_key'>$slug_key - $template</a><br>";
        }
    } else {
        header("Location: https://".$json_data['core']['site']['url']."/".$langPrefix."/".$langManager->getTranslation('error.seo.url'));
    }
} else {
    // Default page view (when no slug is provided)
    include_once __DIR__ . '/template/header.php';
    include_once __DIR__ . '/template/home.php'; 
    include_once __DIR__ . '/template/footer.php';
}
?>
