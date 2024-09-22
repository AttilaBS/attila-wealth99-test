### Test Attila Barcellos Sipos Wealth99
    Laravel version 5.6
    PHP version 7.3
    MySql version 5.7.33

    This project is an API that consumes and external API (Gecko API) that has info about cryptocurrency,
     saves the information at database and retrives various information like unique id, price and so on.

    The objective of creating this project is as a test for a senior developer role at Wealth99.

### To execute the project
    After cloning the repository, rename env.example to .env;
    At command line, type:
      docker compose up --build -d
    
    After all the containers are up, type, in sequence:
      docker compose exec -it php-app bash
      composer install
      php artisan migrate
    
    If everything is ok, type inside php-app container:
      php artisan store:all-coins

    This should populate the database with "real data", that is going to be used for other endpoints.

### Project flux
    This project is meant to follow a specific flux to work as expected.
    First, it is necessary to run the artisan command above.
    In the production scenario, it should be scheduled to run every some minutes, to keep the
     database data up to date. In local environment, it can be simulated running the command
     manually.
    An alternative is to hit the endpoint api/coins/store . The effect is the same.

### Requisitions and responses
    All HTTP requisitions are of type GET and all responses are in Json.

### External Libs
    I avoided to use unecessary external libs at development. As far as I analysed, there is no external libs worth noticing.

### Architecture / design pattern decisions
    Rest API architecture and repository design pattern are being used for decoupling between classes and separation of data and business logic.

### Running automated tests
    Type:
     docker compose exec -it php-app bash
    And:
      vendor/bin/phpunit --verbose

### Important information
    I added some user routes (creation, login and logout) as a demonstration of code style, but for
     personal time limitations, they are not fully funtional (the routes work but I'm not using the api auth middleware).
   
    Automated tests were implemented and I created a separated database for tests for avoiding messing with the main
     database. It's working as expected.

    Even though I created more routes than requested at test description, the prices history endpoint was not implemented, for personal time limitations.
