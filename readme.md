
#SETUP
Composer and Yarn are require for installation
##from a node.js command prompt run:
To install the project:

composer install

To build the database and populate with test data:

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

To compile the css build:

yarn encore dev

##REDIS
Redis needs to be installed locally on the default port 6379
https://redis.io/download or if the os is windows then https://github.com/MicrosoftArchive/redis/releases

##Webserver
The project root is /public. The is a web.config and .htaccess to handle the rewrites

#RUNNING THE PROJECT
##from a node.js command prompt run:
To start the message broker task:

php bin/console app:rabbit-receive

#TODO's
##Testing
Need to set up a specific DB for Unit/Functional tests
Need to investigate why services need to be made public to test??
##Security
Authenticaion middleware needs adding with pubically accessable route in an allow list
At the moment IDOR of the post request is done by checking the user in the controller
