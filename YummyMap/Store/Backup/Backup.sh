#!/bin/bash

myHost="localhost"
myUser="database-user"
myPass="databaes-password"
myDB="MY_DB"

backup_path="/var/www/"
date=$(date +"%Y%m%d")
sql_file=$backup_path"myDB."$date".sql"

echo "mysqldump..."
mysqldump -uManager -pMapManager0556 $myDB > /home/$sql_file
echo $sql_file

echo "gzip..."
gzip -f $sql_file
