Attendance System APIs
This is a backend implementation of an Attendance System, built using the Lumen micro framework. The system provides APIs for employee attendance management, including check-in, check-out, employee login, attendance reports.

## Prerequisites
Before starting, make sure you have the following installed:

PHP >= 8.2.12
Composer
MySQL or any other supported database
Lumen Micro-Framework

(Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.)
## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Installation & Configuration
Clone the repository:
git clone -b master https://github.com/abadeeryouhana/attendance_system.git

Install the dependencies via Composer:
composer install

Set up the environment file:
cp .env.example .env

Set up the database in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_system
DB_USERNAME=root
DB_PASSWORD=root

Add the following X-API-KEY and JWT_SECRET to the .env file for the middleware

JWT_SECRET=ER7qm76xnCiFanXbgi00RS8WYPSdmGh1udK7GsoQecQO6UHkJllkZS35MS3nsfbU
X_API_KEY=ER7qm76xnCiFanXbgi00RS8WYPSdmGh1udK7GsoQecQO6UHkJllkZS35MS3nsfbU

Run migrations to create the required tables:
php artisan migrate

## Usage
php -S localhost:8000 -t public

The server will run at http://localhost:8000.

## API Endpoints

1-User Login
POST auth/login
Request Body:
    {
        "user_id":"user123456",
        "password":"123456"
    }
Response:
    {
        "message": "Logged successfully",
        "auth_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvL2F1dGgvbG9naW4iLCJpYXQiOjE3MjU2NjYzNzQsImV4cCI6MTcyNTg4MjM3NCwibmJmIjoxNzI1NjY2Mzc0LCJqdGkiOiI4VHpleFFmUlNOUEQ3T21SIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.y0pHEaZo_dkCJn4FhJKIhijz7devOexVfrC_K8R5JvY",
        "token_type": "bearer",
        "expires_in": 216000000000,
        "data": {
            "id": 1,
            "user_id": "user123456",
            "active": 1,
            "created_at": "2024-09-06T23:45:49.000000Z",
            "updated_at": "2024-09-06T23:45:49.000000Z"
        }
    }

2-User Check-IN
POST attend/check_in

Request Header:
Bearer token : {auth_token}

Response:
    {
        "status": true,
        "message": "Check IN Successfully",
        "data": {
            "check_in_id": 1
        }
    }

3-User Check-OUT
POST attend/check_out/{check_in_id}

Request Header:
Bearer token : {auth_token}

Response:
{
    "status": true,
    "message": "Check OUT Successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "check_in_datetime": "2024-09-06 21:48:48",
        "check_out_datetime": "2024-09-06 23:50:13",
        "working_hours": 2,
        "created_at": "2024-09-06T23:48:48.000000Z",
        "updated_at": "2024-09-06T23:50:13.000000Z"
    }
}


4-User Get_Working_Hours
GET attend/get_working_hours
Request Body:
    {
        "from_date":"2024-9-5",
        "to_date":"2024-9-6"
    }
Response:
    {
        "status": true,
        "message": "Success",
        "total_number_of_hours": 2
    }

5-Get User Notifications
GET notify/index
Request Body:
    {
        "user_id":1  (optional)
    }
Response:
    {
        "status": true,
        "data": (array of objects),
      
    }

## Error Handling
Errors are returned as JSON with appropriate HTTP status codes. Example:

{
  "status": false,
  "error_code": 422,
  "message": "Employee not found."
}

## Testing
there are 2 units test
1-tests/GetWorkingHours
2-tests/LoginTest

## Configure the Cron on Your Server to notify each user its working hours :

* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

## Postman Collection
To use the API with Postman, download the collection and import it into Postman.

- [Download the Postman Collection](https://github.com/abadeeryouhana/attendance_system/blob/master/postman/Task_Attendance.postman_collection.json)

## Postman Environment
You can also download the environment file to set up variables for the API endpoints.

- [Download the Postman Environment](https://github.com/abadeeryouhana/attendance_system/blob/master/postman/task_attend.postman_environment.json)

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
