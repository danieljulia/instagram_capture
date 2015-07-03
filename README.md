# instagram_capture



How to install
----

- Create database and tables using install/dump.sql
- Copy application/config/database.sample.php to database.php and configure database connection
- Copy application/config/instagram.sample.php and set
	- instagram api key and secret
	- max hours back parsing
	- max recursive calls (optional)


Open the browser and create a set

Then to begin parse in the command line

index.php cron parse <id>   

where id is the set id
