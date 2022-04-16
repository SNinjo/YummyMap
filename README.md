## Installation Steps
Before installing, you must have already set environment variable (mysql) and downloaded the http server and database (recommend mysql)

### step 1
&emsp;&emsp;put "YummyMap" whole folder to the root path of http server (For example, the root path of apache server is htdocs)

### step 2 (restore database)
&emsp;&emsp;enter the database and input> create database YummyMap;  
&emsp;&emsp;exit the database
&emsp;&emsp;open command line and enter correct file path
&emsp;&emsp;then, input> mysql -uroot YummyMap < YummyMap.sql

### step 3 (give user privilege)
&emsp;&emsp;enter the database and input all of instructions below  
CREATE USER 'Client'@'localhost' IDENTIFIED BY '';  
CREATE USER 'Store'@'localhost' IDENTIFIED BY 'StoreSelf';  
CREATE USER 'Manager'@'localhost' IDENTIFIED BY 'MapManager0556';  
GRANT SELECT ON `yummymap`.`storeinfo` TO `Client`@`localhost`;  
GRANT SELECT, INSERT, UPDATE ON `yummymap`.`storeaccount` TO `Store`@`localhost`;  
GRANT SELECT, INSERT, UPDATE, DELETE ON `yummymap`.`storeinfo` TO `Store`@`localhost`;  
GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON `yummymap`.* TO `Manager`@`localhost`;  

### step 4
&emsp;&emsp;you can use YummyMap now!
