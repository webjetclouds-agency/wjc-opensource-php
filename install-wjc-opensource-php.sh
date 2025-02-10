#!/bin/bash


php composer.phar install \ 
--no-dev \ 
--optimize-autoloader \ 
--prefer-install=dist \ 
--no-dev \ 
--audit-format=summary \ 
-o \ 
-a \ 
--apcu-autoloader

