# Organization Management System

## Description

The Organization Management System is a RESTful API built with Laravel and MySQL (or SQLite for testing). It allows users to register, authenticate using JWT tokens, and manage organizations they belong to or create. Each user can belong to multiple organizations, and each organization can contain multiple users.

## Features

- User registration and authentication using JWT
- Create and manage organizations
- Users can belong to multiple organizations
- Organizations can have multiple users
- Endpoints for user and organization management
- Comprehensive unit and feature tests

## Technologies Used

- Laravel 11+
- MySQL / SQLite (for testing)
- JWT Authentication
- GitHub Actions for CI/CD

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- MySQL or SQLite
- Git

### Installation

1. **Clone the repository**

```sh
git clone https://github.com/ezeanyimhenry/organization_task.git
cd organization_task
```

2. **Install dependencies**

    ```sh
    composer install
    ```

3. **Copy the example environment file and update the environment variables**

    ```sh
    cp .env.example .env
    ```

4. **Generate the application key**

    ```sh
    php artisan key:generate
    ```

5. **Set up the database**

    Update the `.env` file with your database credentials. For example:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

    Or for SQLite (useful for testing):

    ```env
    DB_CONNECTION=sqlite
    DB_DATABASE=/absolute/path/to/database.sqlite
    ```

6. **Run the database migrations**

    ```sh
    php artisan migrate
    ```

7. **Generate JWT Secret**

    ```sh
    php artisan jwt:secret
    ```

8. **Run the development server**

    ```sh
    php artisan serve
    ```

## API Documentation

### Authentication

#### Register a User

- **URL**: `/api/auth/register`
- **Method**: `POST`
- **Request Body**:

    ```json
    {
        "firstName": "string",
        "lastName": "string",
        "email": "string",
        "password": "string",
        "phone": "string"
    }
    ```

- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "User registered successfully",
        "data": {
            "accessToken": "string",
            "user": {
                "id": "string",
                "firstName": "string",
                "lastName": "string",
                "email": "string",
                "phone": "string"
            }
        }
    }
    ```

- **Error Response**:

    ```json
    {
        "status": "error",
        "message": "Client error",
        "statusCode": 400
    }
    ```

#### Login

- **URL**: `/api/auth/login`
- **Method**: `POST`
- **Request Body**:

    ```json
    {
        "email": "string",
        "password": "string"
    }
    ```

- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "User logged in successfully",
        "data": {
            "accessToken": "string",
            "user": {
                "id": "string",
                "firstName": "string",
                "lastName": "string",
                "email": "string",
                "phone": "string"
            }
        }
    }
    ```

- **Error Response**:

    ```json
    {
        "status": "error",
        "message": "Unauthorized",
        "statusCode": 401
    }
    ```

### User

#### Get User Details

- **URL**: `/api/users/:id`
- **Method**: `GET`
- **Protected**: Yes
- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "<message>",
        "data": {
            "userId": "string",
            "firstName": "string",
            "lastName": "string",
            "email": "string",
            "phone": "string"
        }
    }
    ```

### Organisation

#### Get All Organisations

- **URL**: `/api/organisations`
- **Method**: `GET`
- **Protected**: Yes
- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "<message>",
        "data": {
            "organisations": [
                {
                    "orgId": "string",
                    "name": "string",
                    "description": "string"
                }
            ]
        }
    }
    ```

#### Get Single Organisation

- **URL**: `/api/organisations/:orgId`
- **Method**: `GET`
- **Protected**: Yes
- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "<message>",
        "data": {
            "orgId": "string",
            "name": "string",
            "description": "string"
        }
    }
    ```

#### Create Organisation

- **URL**: `/api/organisations`
- **Method**: `POST`
- **Protected**: Yes
- **Request Body**:

    ```json
    {
        "name": "string",
        "description": "string"
    }
    ```

- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "Organisation created successfully",
        "data": {
            "orgId": "string",
            "name": "string",
            "description": "string"
        }
    }
    ```

- **Error Response**:

    ```json
    {
        "status": "Bad Request",
        "message": "Client error",
        "statusCode": 400
    }
    ```

#### Add User to Organisation

- **URL**: `/api/organisations/:orgId/users`
- **Method**: `POST`
- **Protected**: Yes
- **Request Body**:

    ```json
    {
        "userId": "string"
    }
    ```

- **Success Response**:

    ```json
    {
        "status": "success",
        "message": "User added to organisation successfully"
    }
    ```

## Error Codes

- **400**: Bad Request
- **401**: Unauthorized
- **403**: Forbidden
- **404**: Not Found
- **422**: Unprocessable Entity

## Running Tests

To run tests, use the following command:

```bash
php artisan test
```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.