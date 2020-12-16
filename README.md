# Wallet Service Simulator

![headerimage](https://raw.githubusercontent.com/MartinsOnuoha/credpal-transact-simulator/master/public/3.png)

## About the Application

This is a simulation of a digital wallet & referral platform written in Laravel and Vue.js

## Setup Locally

To Run this application locally, you would need to follow this guide step by step.

## Clone this repository

Open up your terminal or command prompt and clone this repository or download it.

```bash
git clone https://github.com/MartinsOnuoha/credpal-transact-simulator.git credpal

```

This should clone the repository into a `credpal` folder.

## Install Dependencies

Next you would need to navigate into the `credpal` directory and install the *composer* & *npm* dependencies:

```bash
cd credpal
```

```bash
composer install
```

```bash
npm install
```

## Database Setup

Next you'd need to setup a MySQL database locally, as this is needed for storing data.
If you don't already have MySQL installed, you can head over [here](https://dev.mysql.com/downloads/installer/) to install it for your device.

Once you're done installing and setting up MySQL, you would need to create a database, give it a name of your choice. (e.g credpal)

Next copy the example `.env` file:

```bash
cp .env.example .env
```

This should copy all the content of `.env.example` into `.env`

Open the project folder (credpal) in a code editor:

```bash
code .
```

And update the database configurations to fit your local credentials.

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=credpal
DB_USERNAME=root
DB_PASSWORD=root_password
```

## Generate Keys

Next you want to be sure you have the application keys generated:

```bash
php artisan key:generate
```
