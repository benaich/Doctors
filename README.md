Doctors Web Application
========================

This is a web application for managing medical pre-operation and post-operation for patients and cases. Doctors login, create patient and case profiles. The application allows managing medical cases and the different users of the aplication (admin, simple user, manager). This application uses Symfony version 2.5 and AJAX for an enhanced user experience. 

This software is perfectly suited for cosmetic surgons,dermatologists, and hospitals who need to share or train doctors or students.


1) Demo
-------

https://www.youtube.com/watch?v=_x2wfyudZqI


2) Installation
----------------------------------

When it comes to installing the Symfony Standard Edition, you have the
following options.

### Use Composer (*recommended*)


If you don't have Composer yet, download it following the instructions on http://getcomposer.org/  or just run the following command:

    curl -s http://getcomposer.org/installer | php

After you download composer, run the following command:

    php composer.phar install


3) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path-to-project/web/config.php

If you get any warnings or recommendations, fix them before moving on.

Enjoy!