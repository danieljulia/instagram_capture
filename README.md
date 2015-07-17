# instagram_retriever



How to install
----

- Create database and tables using install/dump.sql
- Copy application/config/database.sample.php to database.php and configure database connection
- Copy application/config/instagram.sample.php and set
	- instagram api key and secret
	- max hours back parsing


How to use
----

- Open the browser and create a set
You can add several tags for each set

- Then you can begin to parse a set using the button or the command line (better)

index.php cron parse id   

where id is the set id


- When parsing a set, the previously running set will stop (not inmediatly but after a few minutes), this is to prevent overload in the calls

- You can export data using the export section or directly from database

Agreements
----

Special agreements to the UAB, the Digital Marketing Master, Oscar Coromina and the students who have participated in the design of this tool

