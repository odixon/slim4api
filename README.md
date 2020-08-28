# SLIM4API - USER CUSTOMER API - POC

RESTful API POC with JWT to manage users and customers.

Based on: `PHP 7, Slim 4, MySQL, PHPUnit, OpenSSL`.

Made with [slim4](https://github.com/slimphp/Slim).

[![Software License][ico-license]](LICENSE.md)


## QUICK INSTALL:

### Pre Requisite:

- PHP 7.2+.
- Composer.
- MySQL/MariaDB.
- OpenSSL


### With Composer:

Create a new project:
```bash
$ composer create-project r3md3v/slim4api [my-api-name]
$ cd [my-api-name]
$ composer test
$ composer start
```


### JWT/JSON Web Token keys

Generate private key and public keys with these commands:
```
openssl genrsa -out private.pem 2048
openssl rsa -in private.pem -outform PEM -pubout -out public.pem
```


### Create database:

Create a new DB and execute `db.sql` to create tables (users and customers) and feed 5 lines, and execute `dbjwt.sql` to create specific tables for JWT with 3 lines


#### Configure app (settings.php):

Configure error reporting for development or production (below is production):
```
error_reporting(0);
ini_set('display_errors', '0');
$display_error_details = false;
```

Configure MySQL connection:
```
$settings['db'] = [
	'driver' => 'mysql',
	'host' => 'yourMySqlHost',
	'database' => 'yourMySqlDatabase',
	'username' => 'yourMySqlUsername',
	'password' => 'yourMySqlPassword',
```

Configure JWT  (change issuer, lifetime, and copy content of private and public keys generated previously):
```
$settings['jwt'] = [
    // The issuer name
    'issuer' => 'www.example.com',
    // Max lifetime in seconds
    'lifetime' => 14400, // 14400 = 4 hours (86400 = 24 hours)
    // The private key
    'private_key' => '-----BEGIN RSA PRIVATE KEY-----
-----END RSA PRIVATE KEY-----',
    // The public key
    'public_key' => '-----BEGIN PUBLIC KEY-----
-----END PUBLIC KEY-----',
];

```
Specify if redirection is other than 8080:
```
$settings['redirection'] = [
    'port' => 8080,
    'servername' => 'localhost',
];
```


#### Populate DB:

- For POC purpose, users and customers tables have 5 lines.
- Run this command as many times a needed, to populate 500 additionnal lines of data in users and customers tables thanks to faker:
```
$ composer faker
```


## DEPENDENCIES:

### LIST OF REQUIRE DEPENDENCIES:

- For basic app: slim/slim slim/psr7 selective/basepath slim/monolog php-di/php-di
- For Swagger: doctrine/annotations slim/twig-view symfony/yaml
- For JWT: lcobucci/jwt symfony/polyfill-uuid cakephp/chronos


### LIST OF DEVELOPMENT DEPENDENCIES:

- phpunit/phpunit fzaninotto/faker


## ENDPOINTS:

### BY DEFAULT:

- Status: `GET /`
- Status: `GET /status`

### Hello:
- Hello World: `GET /hello`
- Hello Name: `GET /hello/{name}`

### Swagger:
- SwaggerUI: `GET /docs/v1`

### Customers:
- Get customer by id: `GET /customers/id/{id}`
- Create user with data `POST /customers` cusname,address,city,phone,email
- List of customers: `GET /customers`
	option page = startpage (default 1)
	option size = page size (default 50)
- Search customer: `GET /customers/search/{keyword}`
	option page+size
	option in = search keyword in field number (default 1 / search in all fields if not set

### Users:
- Get user by id: `GET /users/id/{id}`
- Create user with data `POST /users` username,password,firstname,lastname,email,profile
	option page = startpage (default 1)
	option size = page size (default 50)
- Search user: `GET /users/search/{keyword}?page=1&size=50&in=2`
	option page+size
	option in = search keyword in field number (default 1 / search in all fields if not set

### UsersJWT:
- Delete token: `GET /logout`


## FORMS:

- createUserForm.php = triggers `POST /users` username,password,firstname,lastname,email,profile 
- createCustomerForm.php = triggers `POST /customers` cusname,address,city,phone,email
- login.php = required to trigger `/users` endpoint
- checkJWTForm.php = gives detail about a JSON Web Token
- hashPWDForm.php = returns a BCRYPT hashed version of a string


## THAT'S IT!

Have fun!