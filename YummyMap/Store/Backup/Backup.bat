rem 設定中文
@chcp 65001
@echo off

rem %~dp0 代表批次檔所在位置
SET filePath=%~dp0..\..\image
SET backupPath=%~dp0..\..\..\Backup\
SET sqlPath=C:\My_Program\Website\Xampp\mysql\bin

if "%1"=="SystemStore" (goto SystemStore)
if "%1"=="ManualStore" (goto ManualStore)
if "%1"=="Rename" (goto Rename)
if "%1"=="Change" (goto Change)
if "%1"=="Delete" (goto Delete)

echo Error... Please check your code.
PAUSE
EXIT


rem --- 系統更新 ---
:SystemStore
for /f "tokens=2-4 delims=/- " %%i in ("%date%") do set datetime=%%i.%%j.%%k
SET backupPath=%~dp0..\..\..\Backup\%datetime%\
XCOPY %filePath% %backupPath%image\ /E /Q /Y

CD %sqlPath%
mysqldump -uManager -pMapManager0556 yummymap > %backupPath%yummymap.sql

rem echo Complete. (Copy Website files and Database data)
rem PAUSE
EXIT


rem --- 手動更新 ---
:ManualStore
SET backupPath=%~dp0..\..\..\Backup\%2\
XCOPY %filePath% %backupPath%image\ /E /Q /Y

CD %sqlPath%
mysqldump -uManager -pMapManager0556 yummymap > %backupPath%yummymap.sql

rem echo Complete. (Copy Website files and Database data)
rem PAUSE
EXIT


rem --- Rename ---
:Rename
CD %backupPath%
REN %2 %3

rem echo Complete. (Copy Website files and Database data)
rem PAUSE
EXIT


rem --- ChangeDB ---
:Change
SET targetPath=%backupPath%\%2\
CD %sqlPath%

rem 更改資料庫需要更多權限
mysql -uroot -pKingRoot yummymap < %targetPath%yummymap.sql

rem echo Complete. (Change Database Version)
rem PAUSE
EXIT


rem --- Delete ---
:Delete
SET targetPath=%backupPath%\%2
RD /S /Q %targetPath%

rem echo Complete. (Delete Database Version)
rem PAUSE
EXIT
