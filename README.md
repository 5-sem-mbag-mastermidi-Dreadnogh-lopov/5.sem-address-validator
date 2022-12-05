# 5.sem-address-validator
## GET STARTED:
### Prerequisites
First, install [WSL2](https://learn.microsoft.com/en-us/windows/wsl/install) on your machine and install your [linux distro](https://aka.ms/wslstore) of choice

Then, ensure your WSL is up-to-date
```bash
$ sudo apt update 
$ sudo apt upgrade
```
Next, install the following packages to your WSL environment
```bash
$ sudo apt install composer php-pgsql
```
And setup composer dependencies
```bash
$ composer update
$ composer install
```

### Run Migration
To run your migration, first ensure that `DB_HOST` is set to the ip of your database. <br>
Next, run the following command to execute the migration:
```bash
$ php artisan migrate
```

### Using Sail
First, remember to update the .env file:
```dotenv
APP_KEY=<your-app-key>
GOOGLE_API_KEY=<your-api-key>
DB_USERNAME=<username>
DB_PASSWORD=<password>
DB_HOST=<localhost/pgsql>
```
Then, run below command from project root to start the program:
```bash
$ ./vendor/bin/sail up
```
optionally you can add an alias and simplify the command
```bash
$ alias sail="./vendor/bin/sail"
$ sail up
```

## Run Tests:
Install the following:
```bash
$ sudo apt install php-sqlite3
```

Run below command from project root to run test-suite:
```bash
$ php artisan test
```
For code coverage report, use: 
```bash
$ php artisan test --coverage-html reports
```


