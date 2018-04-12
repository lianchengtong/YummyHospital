#!/bin/sh

DEPLOY_PATH=/root/mp.711xd.com
cd $DEPLOY_PATH
rm -rf application  backup  common  composer.json  console  environments  init  init.bat  LICENSE  README.md  requirements.php  test.php  tools  yii

cd /home/projects/handian_wechat
cp -rap application  backup  common  composer.json  console  environments  init  init.bat  LICENSE  README.md  requirements.php  test.php  tools  yii $DEPLOY_PATH

cd $DEPLOY_PATH
php init --env=Production --overwrite=y
sass application/sass/site.scss:application/web/css/site.css


echo DONE