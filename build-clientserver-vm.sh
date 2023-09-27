#!/bin/bash

# Code heavily inspired by the work at: https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Credit to David Eyers and Pradeesh

apt-get update

apt-get install -y apache2 php libapache2-mod-php php-mysql
            
cp /vagrant/website-init.conf /etc/apache2/sites-available/

a2ensite website-init

a2dissite 000-default

service apache2 restart
