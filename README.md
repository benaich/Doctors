Doctors Web Application
========================

This is a web application for managing medical pre-operation and post-operation for patients and cases. Doctors login, create patient and case profiles. The application allows managing medical cases and the different users of the aplication (admin, simple user, manager). This application uses Symfony version 2.5 and AJAX for an enhanced user experience. 

This software is perfectly suited for cosmetic surgons,dermatologists, and hospitals who need to share or train doctors or students.


1) Demo
-------

https://www.youtube.com/watch?v=_x2wfyudZqI


2) Installation
----------------------------------

### Download the application

clone this repository into your working directory

	git clone https://github.com/benaich/Doctors.git

Before starting, make sure that your local system is properly configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path-to-project/web/config.php

If you get any warnings or recommendations, fix them before moving on.

### Install Composer

If you don't have Composer yet, download it following the instructions on http://getcomposer.org/  or just run the following command:

    curl -s http://getcomposer.org/installer | php

### Install the dependencies

After you download composer, run the following command:

    php composer.phar install

### Import the database
	
You'd need to import this sql source file to your DBMS 

	https://github.com/benaich/Doctors/blob/master/app/Resources/database.sql

## Run the server
	
	php app/console server:run

Enjoy!