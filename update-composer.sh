#!/bin/bash

# Liste des dossiers à mettre à jour
dossiers=("/Users/alexonbstudio/Documents/git-projet/GitHub/wjc-opensource-php/") 

# Parcourir chaque dossier
for dossier in "${dossiers[@]}"
do
    # Se déplacer dans le dossier
    cd "$dossier"

    php composer.phar selfupdate --no-dev --apcu-autoloader -n --quiet
    # Mettre à jour Composer
    php composer.phar update -o -a -W --prefer-stable --prefer-install=dist --no-dev --apcu-autoloader -n --quiet

    php composer.phar dump-autoload -o -a --apcu --no-dev -n --quiet
    # Revenir au dossier parent
    php composer.phar archive --dir=/Users/alexonbstudio/Documents/git-projet/GitHub/wjc-opensource-php/archives -f=zip -n --quiet
#    php composer.phar fund -f=json -n --quiet
#    php composer.phar suggests --all --no-dev -n --quiet
    php composer.phar home -s=https://webjet.cloud/documentation/ -H=https://github.com/webjetclouds-agency -n --quiet
    
    php comoposer.phar cc -n --quiet

done


# Copyright (c) 2023-2024 WebJetClouds update composer PHP 
# with Project WebJetClouds OpenSource PHP 
# By Alexon Balangue