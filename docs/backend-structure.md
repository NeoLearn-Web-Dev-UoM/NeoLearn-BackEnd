# Backend Source Code Structure
## Introduction
The backend of the project is written in Python PHP. 
The backend is responsible for the following tasks:
- Create, delete and update students
- Create, delete and update courses
- Create, delete and update teachers (instructors)
- Create, delete and update admins
- Login users

## Structure
The backend is divided into different folders, each folder has a specific task.

### `config` folder
This folder contains the configuration files for the backend such as the database connection configuration.

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