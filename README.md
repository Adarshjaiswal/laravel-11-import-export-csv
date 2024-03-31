
# laravel-11-import-export-csv

This repository contains a Laravel application demonstrating how to import and export CSV files. With this application, you can easily import CSV data into your Laravel application's database and export data from the database to a CSV file.

## Features

- CSV Import: Upload CSV files containing data to import into the application's database.
-CSV Export: Export data from the application's database to a CSV file for external use.
-Laravel Framework: Built using the Laravel framework, a powerful PHP framework for web application development.
-CSV Handling: Utilizes Laravel's built-in file handling capabilities along with the league/csv package for efficient CSV parsing and generation.
-User-friendly Interface: Provides a user-friendly interface for uploading CSV files, managing imported data, and exporting data to CSV format.


## Installation

first clone the repo 

```bash
  git clone https://github.com/Adarshjaiswal/laravel-11-import-export-csv.git
```
Then, switch to the cloned folder.
```bash
  cd laravel-11-import-export-csv
```
Install  the dependencies using composer and npm.
 ```bash
 composer install
``` 
and 
 ```bash
 npm install
```   
If any error during Installation on node modules due to version then please use 
 ```bash
 npm install --force
```  
Copy the .env.example file and make the required configuration changes in the .env file(Like database name, host, username and password)
```bash
cp .env.example .env
```
Generate a new application key
```bash
php artisan key:generate
```
Run the database migrations (Set the database connection in .env before migrating)
```bash
php artisan migrate
```
Start the local development server
```bash
php artisan serve
```
Start Vite for bundling the assets or Hot Module Reload (required)
```bash
npm run dev
```
Woohoo! you are all done with Installation!

## Feedback

If you have any feedback, please reach out to us at krishj067@gmail.com

