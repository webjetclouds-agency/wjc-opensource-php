<?php
# exemple for translation and language management use php8.4
require __DIR__ . '/vendor/autoload.php';

use App\LanguageManager;

$language = 'fr'; // Set language (you can dynamically set this)
$langManager = new LanguageManager('fr');

echo $langManager->getTranslation('hello.1'); // Output: Hello
echo "<br>";
echo $langManager->getTranslation('hello.2'); // Output: Hi
echo "<br>";
echo $langManager->getTranslation('goodbye'); // Output: Goodbye
