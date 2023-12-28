# Backend Source Code Structure
## Introduction
The backend of the project is written in Python PHP. 
The backend is responsible for the following tasks:
- Create, delete and update students
- Create, delete and update courses
- Create, delete and update teachers (instructors)
- Create, delete and update admins
- Login users

The api documentation can be found [here](https://documenter.getpostman.com/view/23775608/2s9Ykn8gvq).

## Architecture
![image](https://github.com/NeoLearn-Web-Dev-UoM/NeoLearn-BackEnd/assets/77233507/068e255b-bee6-4536-929d-bb80b65bd484)
![image](https://github.com/NeoLearn-Web-Dev-UoM/NeoLearn-BackEnd/assets/77233507/3bc78d23-ed8c-4c10-b0a6-d2f1c82489ad)


## Structure
The backend is divided into different folders, each folder has a specific task.

### `config` folder
This folder contains the configuration classes for the backend such as the database connection configuration.

### `controllers` folder
This folder contains the controllers for the backend. 
The controllers are responsible for handling the requests and sending the responses.
Every time a user makes a request to a specific endpoint, the controller for that endpoint is called and it handles the request.

### `models` folder
This folder contains the models for the backend.

### `db` folder
This folder contains the database interaction classes for the backend.
We use these classes to interact with the database.
For example, we use the `StudentDatabase` class to interact with the `students` table in the database.

### The `index.php` file
This file is the entry point for the backend.
It handles all the requests and sends the responses.

On this file we will write the endpoints for the backend and their corresponding controllers and methods.
