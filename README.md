# Test for Blarlo

Docker with Apache, PHP 8.0, PHPMyAdmin and MySQL 8.0.19

## Requirements:

- Docker compose.

## Instructions:

Run the following command:

`docker-compose up -d`

## Checking functionability:

When all the services are running, you can access phpMyAdmin on [http://localhost:5000](http://localhost:5000)

Now, create the database following the **DB.sql** file.

Finally, access your web server on [http://localhost:8000](http://localhost:8000)

You should see the products' table with the test csv imported.

## Stopping the LAMP Server:

Run the following command:

`docker-compose down`