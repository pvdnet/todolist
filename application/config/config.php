<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/**
 * Configuration for: URL
 * Here we auto-detect your applications URL and the potential sub-folder. Works perfectly on most servers and in local
 * development environments (like WAMP, MAMP, etc.). Don't touch this unless you know what you do.
 *
 * URL_PUBLIC_FOLDER:
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/application" or other folder inside your application or call any other .php file than index.php inside "/public".
 *
 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do. This defines the protocol part of the URL, in older
 * versions of MINI it was 'http://' for normal HTTP and 'https://' if you have a HTTPS site for sure. Now the
 * protocol-independent '//' is used, which auto-recognized the protocol.
 *
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
 * If your project runs with http and https, change to '//'
 *
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 *
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mini');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

/**
 * Configuration for: Cookies
 */
// 1209600 seconds = 2 weeks
define('COOKIE_RUNTIME', 1209600);	
//IMPORTANT: always put a dot in front of the domain, like ".mydomain.com"!
define('COOKIE_DOMAIN', 'false');


//Hashing
define('HASH_COST_FACTOR', '10');


//Custom set feedback messages

define('FEEDBACK_UNKNOWN_ERROR', 'There was an error. Please try again.');

//LOGIN FEEDBACK
define('FEEDBACK_EMPTY_USERNAME', 'Please enter a valid username.');
define('FEEDBACK_EMPTY_PASSWORD', 'Please enter a password.');
define('FEEDBACK_LOGIN_FAILED', 'Your username or password was wrong.');
define('FEEDBACK_WRONG_PASSWORD', 'Password was wrong');
define('FEEDBACK_WRONG_PASSWORD_3', 'You have typed in a wrong password 3 or more times already. Please wait 30 seconds to try again.');
define('FEEDBACK_ACCOUNT_NOT_ACTIVATED', 'Your account is not yet activated. Please check your email to activate your account.');

//REGISTER FEEDBACK
define('FEEDBACK_REG_EMPTY_USERNAME', 'Please enter a username.');
define('FEEDBACK_REG_EMPTY_EMAIL', 'Please enter an email address.');
define('FEEDBACK_REG_EMPTY_PASSWORD', 'Please enter a password.');
define('FEEDBACK_REG_USERNAME_LONG_SHORT', 'Your username is too short or too long.');
define('FEEDBACK_REG_USERNAME_PATTERN', 'Your username doesn\'t follow the pattern.');
define('FEEDBACK_REG_EMAIL_LONG', 'Your email address is too long.');
define('FEEDBACK_REG_EMAIL_PATTERN', 'Your email address doesn\'t follow the pattern.');
define('FEEDBACK_REG_PASSWORD_SHORT', 'Your password is too short');
define('FEEDBACK_REG_REPEAT_WRONG', 'The passwords don\'t match.');

define('FEEDBACK_REG_TAKEN_USERNAME', 'This username already exists.');
define('FEEDBACK_REG_TAKEN_EMAIL', 'Thie email address already exists.');

define('FEEDBACK_REG_CREATION_FAILED', 'Account creation failed. Please try again.');
define('FEEDBACK_REG_CREATION_SUCCESS', 'Account creation success! Welcome!');

define('FEEDBACK_REG_VERIFY_EMAIL_SEND_FAILED', 'We could not send the verification email. Please try te register again.');