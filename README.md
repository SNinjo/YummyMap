# YummyMap
developed a map application to participate in [industry-university cooperation program](https://www.facebook.com/nknu2015/posts/965668330436223/) and research all of the process of building website such as DNS, Ajax, HTTP server, database, etc.
<br><br>
## Operating Example
### Account List
&emsp;&emsp;Account- manager, Password- 012345  
&emsp;&emsp;Account- store, Password- 123  
&emsp;&emsp;Account- store02, Password- 123  
&emsp;&emsp;Account- store03, Password- 123  
<br>
  
click the Home button
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts01.png)
  
  
click the Version button
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts02.png)
  
  
click the Map button
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts03.png)
  
  
click on the store logo
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts04.png)
  
  
show the information of store
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts05.png)
  
  
click the Info button and the login button
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts06.png)
  
  
login account- store, password- 123
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts07.png)
  
  
enter the page of editing store information  
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts08.png)
  
  
edit any information you want to change  
by the way, you can directly click on map to change your store location
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts09.png)
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts10.png)
  
  
login account- manager, password- 012345
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts11.png)
  
  
manage all of the store information and the store account
![image](https://github.com/SNinjo/YummyMap/blob/main/img/flowcharts12.png)
  
<br><br>
## Installation
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
GRANT SELECT ON 'yummymap'.'storeinfo' TO 'Client'@'localhost';  
GRANT SELECT, INSERT, UPDATE ON 'yummymap'.'storeaccount' TO 'Store'@'localhost';  
GRANT SELECT, INSERT, UPDATE, DELETE ON 'yummymap'.'storeinfo' TO 'Store'@'localhost';  
GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON 'yummymap'.* TO 'Manager'@'localhost';  

### step 4
&emsp;&emsp;you can use YummyMap now!
