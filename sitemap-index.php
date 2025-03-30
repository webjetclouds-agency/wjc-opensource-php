<?php
include __DIR__."vendor/autoload.php";

$json_files = glob(__DIR__ . "/config/*.json");
$json_data = json_decode(file_get_contents($json_files[0]), true);
$langManager = new LanguageManager('fr');

$config = new \Icamys\SitemapGenerator\Config();

// Your site URL.
$config->setBaseURL('https://example.com');

// OPTIONAL. Setting the current working directory to be output directory
// for generated sitemaps (and, if needed, robots.txt)
// The output directory setting is optional and provided for demonstration purposes.
// The generator writes output to the current directory by default. 
$config->setSaveDirectory(sys_get_temp_dir());

// OPTIONAL. Setting a custom sitemap URL base in case if the sitemap files location
// is different from the website root. Most of the time this is unnecessary and can be skipped. 
$config->setSitemapIndexURL('https://example.com/sitemaps/');

$generator = new \Icamys\SitemapGenerator\SitemapGenerator($config);

// Create a compressed sitemap
$generator->enableCompression();

// Determine how many urls should be put into one file;
// this feature is useful in case if you have too large urls
// and your sitemap is out of allowed size (50Mb)
// according to the standard protocol 50000 urls per sitemap
// is the maximum allowed value (see http://www.sitemaps.org/protocol.html)
$generator->setMaxURLsPerSitemap(50000);

// Set the sitemap file name
$generator->setSitemapFileName("sitemap.xml");

// Set the sitemap index file name
$generator->setSitemapIndexFileName("sitemap-index.xml");

// Add alternate languages if needed
$alternates = [
    ['hreflang' => 'de', 'href' => "http://www.example.com/de"],
    ['hreflang' => 'fr', 'href' => "http://www.example.com/fr"],
];

// Add url components: `path`, `lastmodified`, `changefreq`, `priority`, `alternates`
// Instead of storing all urls in the memory, the generator will flush sets of added urls
// to the temporary files created on your disk.
// The file format is 'sm-{index}-{timestamp}.xml'
$generator->addURL('/path/to/page/', new DateTime(), 'always', 0.5, $alternates);

// Optional: add sitemap stylesheet. Note that you need to create
// the file 'sitemap.xsl' beforehand on your own.
$generator->setSitemapStylesheet('sitemap.xsl');

// Flush all stored urls from memory to the disk and close all necessary tags.
$generator->flush();

// Move flushed files to their final location. Compress if the option is enabled.
$generator->finalize();

// Update robots.txt file in output directory or create a new one
//$generator->updateRobots();

// Submit your sitemaps to Yandex.
$generator->submitSitemap();