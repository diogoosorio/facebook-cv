About the Project
-------------------------

The Facebook CV project was a personal attempt of creating a different Curriculum Vitae for myself. In order to do so I've decided to "clone" the new Facebook timeline interface and customizing it so that it would accommodate only relevant information to any potential employer.


Installation
----------------------------

The project is currently lacking a back-end where you can edit your CV information. For the time being all modifications need to be done directly in the database.

In order to get it working, here's what you need to do:

* Clone the project <pre>git clone https://github.com/diogoosorio/facebook-cv</pre>

* Edit the app/config/config.php <pre>$config['base_url'] = 'The base URL to your website w/ an ending slash (/)';
$config['default_email'] = 'youremail@yourdomain.com';</pre>

* Create a MySQL database to accommodate the website. Create an user with read/write privileges to all tables.

* Edit the app/config/database.php file

* Create a Facebook App (https://developers.facebook.com/) and edit the app/config/facebook.php file

* Point your browser to http://address/index.php/install, or simply import the db schema (sql folder) and chmod 777 the folders app/facebookcv/views/cache and app/facebookcv/views/compiled
