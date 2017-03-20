#!/bin/bash
# In order to run the server you will need to install a Lamp stack. As long as you
# picked the Php workstation form the c9 dashboard, you'll be fine.

#Once you do that make this script executable and run it.

sudo service mysql start
sudo mysql -u root < /home/ubuntu/workspace/CPSCDatabase/setup/createUsers.sql
sudo mysql -u root < /home/ubuntu/workspace/CPSCDatabase/db.sql
sudo rm -r /var/www/html
sudo ln -s /home/ubuntu/workspace/CPSCDatabase/html /var/www/html
sudo cp /home/ubuntu/workspace/CPSCDatabase/.htaccess /var/www
sudo cp /home/ubuntu/workspace/CPSCDatabase/setup/001-cloud9.conf /etc/apache2/sites-enabled/001-cloud9.conf
sudo cp /home/ubuntu/workspace/CPSCDatabase/setup/apache2.conf /etc/apache2