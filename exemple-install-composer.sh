#!/bin/sh

# experimental expert sysadmin VPS/didicated server copyright Webjetclouds
# By Alexon Balangue

apt install git -y # serveur privé, serveur dédié ou un serveur cloud.
wget https://getcomposer.org/download/2.4.3/composer.phar
chmod +x composer.phar
chown $USER:$USER composer.phar
nano ~/.bash_profile

alias composer="php /$USER/composer.phar" # PlanetHoster 
alias composer="php /$HOME/composer.phar" # OVH 

# Mac: Command+X & Y | Windows/Linux: Ctrl+X & Y
source ~/.bash_profile

# Ajouter dans la tâche de planification
@reboot source ~/.bash_profile
@monthly composer self-update # dernière version automatique de composer PHP

# Hébergement mutualisé créer un fichier shell
echo "source ~/.bash_profile && composer self-update" > update-composer.sh
40 6 * * 0 update-composer.sh # every weeks
