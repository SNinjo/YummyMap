## Installation Steps
before

### 

### restore database
create database YummyMap;
mysql -uroot YummyMap < YummyMap.sql

### give user privilege
CREATE USER 'Client'@'localhost' IDENTIFIED BY '';
CREATE USER 'Store'@'localhost' IDENTIFIED BY 'StoreSelf';
CREATE USER 'Manager'@'localhost' IDENTIFIED BY 'MapManager0556';
GRANT SELECT ON `yummymap`.`storeinfo` TO `Client`@`localhost`;
GRANT SELECT, INSERT, UPDATE ON `yummymap`.`storeaccount` TO `Store`@`localhost`;
GRANT SELECT, INSERT, UPDATE, DELETE ON `yummymap`.`storeinfo` TO `Store`@`localhost`;
GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON `yummymap`.* TO `Manager`@`localhost`;