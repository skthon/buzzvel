# Changes related to implentation of RESTful APIs
- PR: https://github.com/skthon/buzzvel/pull/1
- Live site: https://skthon.online
- Demos
   - https://drive.google.com/file/d/1Nc7LqFG7ZOahmNlKYQsGXie6sOVFCZXl/view
   - https://drive.google.com/file/d/1dAi7jfvI7jm14iKbEcjLH5hQ8zZDIeZY/view

# Table of Contents
- [Requirements and Installation](#requirements-and-installation)
- [Tests](#tests)
- [Challenge](#challenge)
- [Known Issues](#known-issues)
- [endpoints.md](endpoints.md)

# Requirements and Installation
- Docker & Docker compose
    - PHP 8.1
    - Apache web server
    - Mysql 8.0
    - Composer
- Clone the code repository
```
gh repo clone skthon/buzzvel
```
- After cloning, Run the below commands to setup the project
```
# Creates the app, db images and launches the containers
docker-compose up -d

# Above command will create two containers: buzzvel-app-1 and buzzvel-db-1 
# Now navigate to mysql container and create databases
docker exec buzzvel-db-1 bash
mysql -u root -p
> CREATE DATABASE buzzvel;
> CREATE DATABASE buzzvel_test;

# Navigate to container app bash terminal
docker exec buzzvel-app-1 bash

# Go to project directory and run the composer, generate app key
cd /var/www/html
composer install
php artisan key:generate
php artisan storage:link

# Edit the .env file
DB_HOST=buzzvel-mysql-1
DB_PORT=3306
DB_DATABASE=buzzvel
DB_USERNAME=root
DB_PASSWORD=root

# Create a .env.testing file and set the key DB_DATABASE=buzzvel_test
cp .env .env.testing

# clear the cache and run the migrations
php artisan config:clear
php artisan migrate

# Run the tests
php artisan test
```

# Tests
$ php artisan test
```
   PASS  Tests\Feature\Api\V1\TaskControllerTest
  ✓ api returns invalid credentials error
  ✓ api returns invalid route error
  ✓ api returns method not allowed error
  ✓ api shows details of all tasks
  ✓ api viewing a non existing task returns record not found
  ✓ api viewing details of specific task is successful
  ✓ api creating a new task returns validation errors
  ✓ api creating a new task is successful
  ✓ api updating an existing task returns validation errors
  ✓ api updating an existing task is successful
  ✓ api deleting a non existing task returns record not found
  ✓ api deleting an existing task is successful

  Tests:  12 passed
  Time:   0.95s
```

# Challenge

Implement a RESTful API for a task management application (to-do list).

Added a postman collection
 * [BuzzvelPostmanCollection.json](BuzzvelPostmanCollection.json)
 * [BuzzvelPostmanEnvironment.json](BuzzvelPostmanEnvironment.json)

### Endpoints
Detailed information on sample requests and response are added here: [endpoints.md](endpoints.md) 

For Authentication, we have two endpoints
- register endpoint for creating a user which returns an access token on successful creation
- login endpoint for authentication a user with credentials which returns an access token on successful authentication
```
curl --location "https://skthon.online/api/register" \
--form "name=\"Saikiran\"" \
--form "email=\"saikiranchavan@gmaill.com\"" \
--form "password=\"testbuzzvel\""

curl --location "https://skthon.online/api/login" \
--form "email=\"saikiranchavan@gmaill.com\"" \
--form "password=\"testbuzzvel\""

Response:
{
    "status": 200,
    "access_token": "2|F4SUEcc5V5iyvBQuxHLqtvBhvN4llKJ9ZVgBHiBS"
}
```

Endpoints
```
- List all tasks: GET https://skthon.online/api/tasks/
- Show details of specific task: GET https://skthon.online/api/tasks/{task_uuid}
- Creates a new task: POST https://skthon.online/api/tasks/
- Update an existing task: POST https://skthon.online/api/tasks/{task_uuid}
- Deletes an existing task: DELETE https://skthon.online/api/tasks/{task_uuid}
```

# Known Issues
* Private attachments link
  * Currently, the api returns the attachment url with storage link from public disk, move to this separate url by having a route authentication or by moving to minio(for local s3).
* Things to resolve in docker
  * Currently, the local app container installed incorrect gd version, which is resulting in errors when uploading images.
  * Creating custom domain for the app instead of using localhost
* Auth Tests
  * Added unit tests for only the task apis but not for register and login routes
