drush sset system.maintenance_mode 1
echo Maintenance mode enabled.
drush cr
git pull origin master
composer install --no-dev
drush cr
drush updb
drush cr
drush csex prod -y
drush cim -y
drush cr
drush sset system.maintenance_mode 0
drush cr
echo Site is online.