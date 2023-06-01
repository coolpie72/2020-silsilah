set mysql_folder=D:\prog\xampp\mysql

set host=localhost
set user=root
set port=3306
set db=db-silsilah-v1
set result=db-silsilah-export.sql

%mysql_folder%\bin\mysqldump --host=%host% --port=%port% --user=%user% --verbose %db% --result-file=%result%