# backend

## Project setup for your local env
Run below commands after cloning
```
cd remotestar-backend
composer install
```

## Environment Setup
Create .env file in root folder of project
Copy content of .env.example and paste it into .env

Set Following Database Variables as per your machine
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=remotestar
DB_USERNAME=remotestar
DB_PASSWORD=remotestar

Set Following variable to value of 'database'
QUEUE_CONNECTION=database

Set Following Email related variables
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=akash.officials@gmail.com
MAIL_PASSWORD=####
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=akash.officials@gmail.com
MAIL_FROM_NAME=AkashSutariya

Here if you are using Gamil's SMTP you have to create APP password,
You may visit below link for help
https://support.google.com/mail/answer/185833?hl=en


### Initialization Commands

Run Below Artisan commands
```
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### Unit Test Command
To perform Unit test run below command
```
php artisan test
```

### Caching Commands
Run Below Artisan commands for caching and optimization
```
php artisan config:cache
php artisan route:cache
```

### Mail Sending commands
For start sending mail out, can start queue worker by command
```
php artisan queue:work
```

### Start Development Server
```
php artisan serve
```
