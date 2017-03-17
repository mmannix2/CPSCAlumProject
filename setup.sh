#!/bin/bash
# In order to run the server you will need to install a Lamp stack. As long as you
# picked the Php workstation form the c9 dashboard, you'll be fine.

#Once you do that make this script executable and run it.

sudo mysql < setup/createUsers.sql
sudo mysql < db.sql
sudo rm -r /var/www/html
sudo ln -s ~/workspace/CPSCDatabase /var/www/html
sudo cp .htaccess /var/www
sudo cp setup/001-cloud9.conf /etc/apache2/sites-enabled/001-cloud9.conf
sudo cp setup/apache2.conf /etc/apache2