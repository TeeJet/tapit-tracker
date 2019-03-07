#!/bin/bash

echo -e "--------------------------------------------------"
echo -e "--- SSH Key --------------------------------------"
echo -e "--------------------------------------------------"
cp /vagrant/vagrant/id_rsa /home/ubuntu/.ssh/id_rsa
cp /vagrant/vagrant/id_rsa.pub /home/ubuntu/.ssh/id_rsa.pub
chown ubuntu:ubuntu /home/ubuntu/.ssh/id_rsa
chown ubuntu:ubuntu /home/ubuntu/.ssh/id_rsa.pub
chmod 600 /home/ubuntu/.ssh/id_rsa
chmod 666 /home/ubuntu/.ssh/id_rsa.pub

echo -e "--------------------------------------------------"
echo -e "--- Add repo for PostgreSQL setup ----------------"
echo -e "--------------------------------------------------"
cp /vagrant/vagrant/pgdg.list /etc/apt/sources.list.d/pgdg.list
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -

echo -e "--------------------------------------------------"
echo -e "--- Update ---------------------------------------"
echo -e "--------------------------------------------------"
apt-get update

echo -e "--------------------------------------------------"
echo -e "--- Fix Time and Timezone ------------------------"
echo -e "--------------------------------------------------"
apt-get -y install ntp
service ntp start
timedatectl set-ntp true
timedatectl set-timezone Europe/Moscow

echo -e "--------------------------------------------------"
echo -e "--- Tools & Libs ---------------------------------"
echo -e "--------------------------------------------------"
apt-get -y install mc htop curl python2.7 git build-essential putty-tools tcl

echo -e "--------------------------------------------------"
echo -e "--- Install PHP-FPM 7.2 ---------------------------"
echo -e "--------------------------------------------------"
add-apt-repository -y ppa:ondrej/php
apt-get update
apt-get -y install php7.2-fpm php7.2-curl php7.2-gd php7.2-intl php7.2-pgsql php7.2-mbstring php7.2-bcmath php7.2-zip php7.2-xml
cp /vagrant/vagrant/php.7.2.conf /etc/php/7.2/fpm/pool.d/www.conf
service php7.2-fpm restart
update-alternatives --set php /usr/bin/php7.2

echo -e "--------------------------------------------------"
echo -e "--- Install NGINX --------------------------------"
echo -e "--------------------------------------------------"
apt-get -y install nginx
sed -i 's/sendfile on;/sendfile off;/g' /etc/nginx/nginx.conf
cp /vagrant/vagrant/nginx.conf /etc/nginx/sites-available/default
service nginx restart

echo -e "--------------------------------------------------"
echo -e "--- Install PostgreSQL-9.6 -----------------------"
echo -e "--------------------------------------------------"
apt-get -y install postgresql-9.6
echo "CREATE ROLE ubuntu LOGIN ENCRYPTED PASSWORD 'ubuntu';" | sudo -u postgres psql
su postgres -c "createdb tracker --owner ubuntu"
echo 'CREATE EXTENSION IF NOT EXISTS "uuid-ossp";' | sudo -u postgres psql -d tracker
service postgresql reload

echo -e "--------------------------------------------------"
echo -e "--- Clean up -------------------------------------"
echo -e "--------------------------------------------------"
apt-get -y autoremove
apt-get -y autoclean

exit 0