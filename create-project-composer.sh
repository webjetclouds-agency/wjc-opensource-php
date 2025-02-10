#!/bin/bash


#gh clone user/source

php composer.phar init \
--name="WJC OpenSource PHP" \
--description="Créer votre site vitrine simplement PHP si besoin avec la basse de donné" \
--author="webjetclouds-agency" \
--homepage="https://opensource-php.webjet.cloud" \
--repository="{"type": "composer", "url": "https://packagist.exemple.com"}" \
-a \
--no-interaction