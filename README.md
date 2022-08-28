## API Instuctions
Clone the project
Copy paste example.env, rename it to be .env, change db credentials. 

Run below command to install requisite dependencies 
composer install

Make database named "sociuu" (or whatever you prefer, just change in .env file) in the server

Run below command to generate tables in database 
php artisan migrate

Run below command to run the project
php artisan serve

## API routes for Groups
GET http://127.0.0.1:8000/api/groups/ --get all groups
GET http://127.0.0.1:8000/api/groups/{id} --get single group
POST http://127.0.0.1:8000/api/groups/ --store a group in the database
e.g json data for Postman body
{
    "name": "Group A"
}
PUT http://127.0.0.1:8000/api/groups/{id} --update a group in the database 
DELETE http://127.0.0.1:8000/api/groups/{id} --delete a group from database
POST http://127.0.0.1:8000/api/groups/attach_user --attach a group to the user the database
POST http://127.0.0.1:8000/api/groups/detach_user --detach a group from the user in the database
e.g json data for Postman body for attach and detach routes
{
    "userId": 1,
    "groupId":1
}


## API routes for Users
GET http://127.0.0.1:8000/api/users/ --get all users with groups with total number of active users
GET http://127.0.0.1:8000/api/users/{id} --get single user with it's groups
POST http://127.0.0.1:8000/api/users/ --store a user in the database
e.g json data for Postman body
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@gmail.com",
    "groups": [1,2]
}
PUT http://127.0.0.1:8000/api/users/{id} --update a user in the database 
DELETE http://127.0.0.1:8000/api/users/{id} --soft delete a user from database
PUT http://127.0.0.1:8000/api/users/groups/{id} --assign / mass assign or remove groups to a user

e.g api to assign or remove groups from user (we can use multiselect to add or remove groups on the frontend)
localhost:8000/api/users/groups/1
*json body for Postman
{
    "groups" : [1,2,3]
}

Route::post('users/filters', [UserController::class, 'userFilters']);
POST http://127.0.0.1:8000/api/users/filters --filter users by multiple conditions and sorting
{
    "filters": [{"first_name" : "abc", "last_name": "egf"}]
}

