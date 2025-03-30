<?php 

$json_files = glob(__DIR__ . "/config/*.json");
$json_data = json_decode(file_get_contents($json_files[0]), true);
$langManager = new LanguageManager('fr');

header('Content-Type: text/plain; charset=UTF-8');

echo "User-agent: * \n
Disallow: /config/ \n";

echo "Sitemap: https://" . $json_data['core']['site']['url'] . "/sitemap.xml\n";

?>