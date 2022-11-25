#!/bin/bash

# install php-7.4
sudo apt update -y
sudo apt install -y php7.4 php7.4-curl php7.4-bcmath php7.4-json php7.4-mbstring php-xml php7.4-tokenizer php7.4-zip

# set php-7.4 as default
sudo update-alternatives --set php /usr/bin/php7.4

# install xdebug 3 for php-7.4
sudo pecl channel-update pecl.php.net
sudo pecl install xdebug

cd /vagrant
composer update -n
composer install -n

# configure apache
sudo rm -Rf /var/www/html/* # removes the default website
sudo ln -s /etc/apache2/sites-available/laravel.conf /etc/apache2/sites-enabled/laravel.conf
sudo systemctl start apache2
sudo systemctl enable apache2

# configure php
sudo systemctl start php7.4-fpm.service
sudo systemctl enable php7.4-fpm.service

if [[ ! -f /vagrant/.env ]] ; then
    # creates the .env file and alter some properties
    cp /vagrant/.env.example /vagrant/.env
    sed -i s/DB_PASSWORD=/DB_PASSWORD=secret/ .env
    sed -i s/DB_DATABASE=laravel/DB_DATABASE=homestead/ .env
fi

mysql -uroot -psecret -e "UPDATE mysql.user SET host='%' WHERE user='root';"
systemctl restart mysql

# generates the apikey
php /vagrant/artisan key:generate
# runs the migration scripts
php artisan migrate:fresh --seed &&
  php artisan admin:install &&
  php artisan db:seed --class=AdminMenuSeeder
