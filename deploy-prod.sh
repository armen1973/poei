#drush sset system.maintenance_mode 1
#drush config-set readonlymode.settings enabled 1 -y
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
#Ajout des config de prod au master
git add config/prod
git commit -m 'Ajout des configs de prod.'
git push origin master
#drush sset system.maintenance_mode 0
#drush config-set readonlymode.settings enabled 0 -y
drush cr
echo Site is online.