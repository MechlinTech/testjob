## Laravel APIS Information

### Tools and Technologies used:
1. Laravel 8.x
2. Passport for authentication

### API ENDPOINTS
1. Login(POST) - `/api/login` - (Parameter: email, password)

### Other API which will work after authentication:
2. User Message(POST) - `/api/usermessage` - (Parameter: message)
3. Support Reply(POST) - `/api/supportreply` - (Parameter: message, support_id, support_status)
4. Get All Support with messages of login user(GET) - `/api/allSupport` - (Parameter: No parameter required it will get data by auth.)
5. Get support with message by name(GET) - `/api/searchSupportByName` - (Parameter: name)
6. Get support with message by status((GET) - `/api/searchSupportByStatus` - (Parameter: status)

### Command for updating the status: 

    php artisan update:status

### You can run the scheduler to run command every 1 minute to check the status :

    php artisan schedule:work

## Local Setup Guide

1. Git clone this repository.
2. Go to the folder and then run `composer install`.
3. Copy .env.example to .env
4. Run `php artisan key:generate` to generate laravel key.
5. `php artisan migrate` to create database tables.
6. `php artisan passport:install` to generate passport tokens.
7. Get Personal access client details and add this to .env 
and add the details into .env file 
    ```bash
    PASSPORT_PERSONAL_ACCESS_CLIENT_ID=1
    PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET="{GENERATED_KEY_HERE}"
    ```
8. Then have to create users we can use tinker here run `php artisan tinker` 
9. In tinker run `User::factory()->count(2)->create();` to create 2 dummy users.
10. Run project using `php artisan serve` you will get url.
11. Then run login API that will give Bearer token. then we can use this token for other api access. 