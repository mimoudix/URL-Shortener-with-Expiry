# PHP URL Shortener

This is a simple URL shortener web application built with PHP and MySQL.
[DEMO](https://shortify.mimoudix.com)

## Features

- Shortens URLs to a six-character alphanumeric code
- Allows users to specify an expiry time for the short URL
- Handles invalid or expired short URLs gracefully

## Requirements

- PHP 7 or later (tested with PHP 8)
- PDO extension for PHP
- MySQL 5.6 or later
- PDO_MYSQL
- Apache 'mod_rewrite' module

## Installation

1. Clone this repository to your local machine
2. Upload all the files to your web server
3. Run the script and fill in your database credentials
4. Done !

### Building with TailwindCSS

This project uses TailwindCSS for styling, and the `package.json` file contains a `start` script to compile the CSS code. To build the project with TailwindCSS, follow these steps:

1. Open a command prompt or terminal in the project's root directory.
2. Run the command `npm install` to install all the project's dependencies.
3. Once the dependencies are installed, run the command `npm start` to start the TailwindCSS build process.
4. The build process will watch the `input.css` file for changes and automatically update the `output.css` file with the compiled CSS code.
5. You can then use the `output.css` file in your HTML pages to apply the TailwindCSS styles to your web application.

Note that the `--watch` flag in the `start` script will keep the build process running in the terminal until you manually stop it by pressing `Ctrl + C`.

## Database Structure

This project uses a MySQL database to store the shortened URLs and their metadata. The database contains a single table named `short_urls`, which has the following structure:

- `id`: The primary key column, which uniquely identifies each record.
- `long_url`: The original URL that the user wants to shorten.
- `short_code`: The generated short code for the shortened URL.
- `expiry_date`: The date and time when the shortened URL will expire.

The `long_url` and `short_code` columns are defined as `NOT NULL`, which means they cannot be empty or null. The `expiry_date` column is also defined as `NOT NULL`, which means each record must have an expiration date.

The `id` column is defined as an `INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY` column, which means it is an auto-incrementing integer value that serves as the primary key of the table. This ensures that each record has a unique identifier.

The `long_url` column is defined as a `TEXT` column, which can hold large text values of up to 65,535 characters. The `short_code` column is defined as a `VARCHAR(6)` column, which can hold up to 6 characters. The `expiry_date` column is defined as a `DATETIME` column, which can hold date and time values from '1000-01-01 00:00:00' to '9999-12-31 23:59:59'.

## Usage

To use the URL shortener, simply enter a URL into the input field on the homepage and click the "Shorten" button. The application will generate a six-character alphanumeric code for the shortened URL. You can optionally specify an expiry time for the short URL.

## Demo

You can see a live demo of the URL shortener in action [here](https://shortify.mimoudix.wtf).

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
