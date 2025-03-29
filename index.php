<?php

require __DIR__ . '/vendor/autoload.php';

use App\LanguageManager;

$language = 'en'; // Set language (you can dynamically set this)
$langManager = new LanguageManager($language);

echo $langManager->getTranslation('hello.1'); // Output: Hello
echo "<br>";
echo $langManager->getTranslation('hello.2'); // Output: Hi
echo "<br>";
echo $langManager->getTranslation('goodbye'); // Output: Goodbye
