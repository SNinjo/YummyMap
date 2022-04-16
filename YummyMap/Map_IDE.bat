@echo off

START "C:\Program Files (x86)\Google\Chrome\Application\chrome.exe" http://127.0.0.1/MyWebsite/YummyMap/Home.html
start "" "C:\Users\USER\Desktop\MyWebsite"

CD C:\My_Program\Website\Xampp\mysql\bin
mysql -uroot -pKingRoot