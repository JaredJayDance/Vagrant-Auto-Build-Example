#!/bin/bash

# Code heavily inspired by the work at: https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Credit to David Eyers and Pradeesh

apt-get update

export MYSQL_PWD='Quack1nce4^'

echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections

apt-get -y install mysql-server

service mysql start

echo "CREATE DATABASE netcafe;" | mysql

echo "CREATE USER 'webuser'@'%' IDENTIFIED BY 'Quack1nce4^';" | mysql

echo "GRANT ALL PRIVILEGES ON netcafe.* TO 'webuser'@'%'" | mysql

export MYSQL_PWD='Quack1nce4^'

cat /vagrant/create-database.sql | mysql -u webuser netcafe

sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

service mysql restart
