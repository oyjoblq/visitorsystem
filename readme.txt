This is a visitor registration system I wrote in PHP. MySQL, BootStrap, CSS, HTML, Ajax, Javascript. 

A web form for entering visitor's information, it can accept two kinds of ID (Driver's License and Passport). It has some basic validation. Upon successful submission, visitor report will be shown. You can edit and delete records. If you click on the report column header, the records can be sorted based on that column. You can also enter keyword in the search input box to narrow down records. You can set how many records to show per page. See it alive at: http://onlinestore.pgocrockerfarm.com/visitorsystem/

In the source codes, the index.php is a registration form, it will submit to itself. It has basic form validation and form processing with php/mysql. It will be forwarded to the report.php after a successful submission. The report.php displays all existing records. You may edit or delete the records. report.php includes reportprocess.js, reportprocess.js gets reportdata.php through ajax calls.
 
If you want to deploy this in your own web server, please create the database,tables,database user/password according to the instruction in the database.txt file. Then replace the database connection information in the base.php. Afterwards, upload all source files to the web server, it should work.
