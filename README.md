# REST API

This is a simple REST API using GWT based token authentication. The API has endpoints for signup, login, user update and listing users. It uses events to log user actions in the system. In order to install and run this run below commands:

`composer install`

After this create an empty database on MySQL. You can name it whatever you want. After creating the database run below commands.

`php artisan migrate`
`php artisan db:seed`

These commands will generate database tables and insert some dummy users. You can register a new user by using `/api/register` post call by providing user JSON object. 

`{
"name": "Jane Doe",
"email": "jane.doe@example.com",
"password": "yourSec!ret"
}`

### Get Token
To get token you can use POST `/api/login`

`{"email": "jane.doe@example.com", "password": "yourSec!ret"}`

This will produce token which should be passed in as Authorization header to access protected API endpoints.

`Authorization: tokenCopiedFromLoginResponse`

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
