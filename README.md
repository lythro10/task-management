# Task Management Defi

Foobar is a Python library for dealing with word pluralization.

## Installation
```bash
git clone https://github.com/lythro10/task-management.git
cd task-management
```


```bash
docker compose up -d --build
```
## Install packages
```bash
docker compose exec -u root app composer install
```

## Fix Permissions on Storage/Cache
```bash
docker compose exec -u root app chmod -R 777 storage bootstrap/cache
```

## Generage DB Keys
```bash
docker compose exec app php artisan key:generate
```


## Generate Sample Data
```bash
docker compose exec app php artisan migrate:fresh --seed
```

## Login with sample data

Username: owner@example.com
Password: password


## Projects Dashboard
![Dashboard showing project ](assets/projects-dashboard.png)

## Tasks of Project
![Tasks within a Project ](assets/tasks-project.png)

## Add Task
![Add a task to a project ](assets/add_tasks.png)

## Details of Task
![Deatails of Task ](assets/add_tasks_1.png)

## Task added in array
![Task added in array ](assets/task_added.png)

## Create new Project
![Create new Project from Dashboard](assets/create-new-project.png)

## New Project added in List
![Added Project in List](assets/new-project added.png)