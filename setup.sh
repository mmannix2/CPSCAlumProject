#!/bin/bash
# In order to run the server you will need to install a Lamp stack. As long as you
# picked the Php workstation form the c9 dashboard, you'll be fine.

#Once you do that make this script executable and run it.

sudo mysql < setup/createUsers.sql
sudo mysql < db.sql
sudp rm /var/www/html
sudo ln -s ~/workspace/CPSCDatabase /var/www/html
sudo cp setup/.htaccess /var/www
sudo cp setup/apache2.conf /etc/apache2