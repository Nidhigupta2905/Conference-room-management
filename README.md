# CR Management System

## System Requirements

1. PHP (Version 7.0.0+)
2. Composer
3. Git
4. NPM
5. Mysql (Version 5.6.35)
6. 1 GB Ram(at least)
7. Apache Web Server(Version 2.4)

## Framework Used

1. Laravel 8.0 for PHP
2. Jquery and ajax for front end,

## Packages Used

1. Socialite for Google Login
2. Spatie for Google Calendar access
3. Mailtrap for sending mails

## Project Setup

1. Git clone the repository.
2. Run composer install to load PHP dependencies to root of project folder.

    shell
    composer install

3. Run npm install to load Node dependencies to root of project folder.

    shell
    npm install

4. Create a .env file to the root of the project folder if not created by copying the .env.example file.

5. Setup the configuration of app environment as local, database connection and other settings in .env file.
6. Setup virtual host and point the document location to public folder.
7. Turn on mod_rewrite engine for apache.
8. Setup database by running migration command

    shell
    php artisan migrate 9. Set some default users by running seed command

    shell
    php artisan db:seed

9. Create the symbolic link for storage

shell
php artisan storage:link

## install Socialite

1. To get started with Socialite, use the Composer package manager to add the package to your project's dependencies:
   shell
   composer require laravel/socialite

then add the following to config/app.php

    'providers' => [

        ....

        Laravel\Socialite\SocialiteServiceProvider::class,

    ],

    'aliases' => [

        ....

        'Socialite' => Laravel\Socialite\Facades\Socialite::class,

    ],

2. then set the app id, secret and call back url in config file so open config/services.php and set id and secret this way:
   return [
   ....
   'google' => [
   'client_id' => 'app id',
   'client_secret' => 'add secret',
   'redirect' => 'http://localhost:8000/auth/google/callback',
   ],
   ]

## install Spatie

1.  Install the package via composer
    composer require spatie/laravel-google-calendar

2.  then publish the configuration with this command:
    php artisan vendor:publish --provider="Spatie\GoogleCalendar\GoogleCalendarServiceProvider"

        This command will publish a file called google-calendar.php in your config-directory with these contents:
        return [

        'default_auth_profile' => env('GOOGLE_CALENDAR_AUTH_PROFILE', 'service_account'),

        'auth_profiles' => [

            /*
             * Authenticate using a service account.
             */
            'service_account' => [
                /*
                 * Path to the json file containing the credentials.
                 */
                'credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),
            ],

            /*
             * Authenticate with actual google user account.
             */
            'oauth' => [
                /*
                 * Path to the json file containing the oauth2 credentials.
                 */
                'credentials_json' => storage_path('app/google-calendar/oauth-credentials.json'),

                /*
                 * Path to the json file containing the oauth2 token.
                 */
                'token_json' => storage_path('app/google-calendar/oauth-token.json'),
            ],
        ],

        /*
         *  The id of the Google Calendar that will be used by default.
         */
        'calendar_id' => env('GOOGLE_CALENDAR_ID'),

    ];

##Folder Structure.
+-- app
+-- bootstrap
+-- config
+-- database
+-- public
| +-- admin
| +-- dist
| +-- plugins
| +-- css
| +-- js
+-- resources
| +-- css
| +-- js
| +-- lang
| +-- sass
| +-- views
+-- routes
| +-- routes
+-- storage
+-- tests
+-- vendor
