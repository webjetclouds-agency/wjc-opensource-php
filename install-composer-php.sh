#!/bin/sh

EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
php composer-setup.php --filename=compmoser --install-dir=/Users/alexonbstudio --quiet

RESULT=$?
rm -rf composer-setup.php
#mkdir bin
cp composer.phar ~/bin/composer.phar
cp composer.phar ~/bin/composer
cp composer.phar composer
touch .bashrc
#pwd
echo "export PATH=\"\$PATH:$(pwd)/\"" >> ~/.bashrc
echo "export PATH=\"\$PATH:$(pwd)/bin\"" >> ~/.bashrc
chmod +x ~/bin/composer.phar
chmod +x ~/bin/composer
chmod +x composer.phar
chmod +x composer


exit $RESULT


