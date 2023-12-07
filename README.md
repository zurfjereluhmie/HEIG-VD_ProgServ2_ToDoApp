# `ToDo App` - Bonus project for ProgServ2 course [@HEIG-VD](https://github.com/HEIG-VD)

The project aims to create a web application for task management (Todo App) with authentication features for users.

The application will allow users to perform CRUD (Create, Read, Update, Delete) operations on tasks. It will also integrate an authentication system to ensure data security. Tasks will be categorized into folders for better organization.

## Table of Contents

- [Technologies](#Technologies)
- [Scripts](#Scripts)
  - [Run the application](#Run-the-application)
  - [Generate the documentation](#Generate-the-documentation)

## Technologies

- [Docker](https://www.docker.com/)
- [Composer](https://getcomposer.org/)
- [Apache](https://httpd.apache.org/)
- [PHP](https://www.php.net/)
- [SQLite](https://www.sqlite.org/index.html)
- [MailHog](https://github.com/mailhog/MailHog)

## Scripts

### Run the application

You can run the application simply by running the following command in the root of the project:

_Note: You need to have [Docker](https://www.docker.com/) installed and running on your machine._

```bash
sh run_app.sh

# or for Windows users
bash run_app.sh
```

### Generate the documentation

You can generate/update the documentation who will be stored in the folder `docs` simply by running the following command in the root of the project:

_Note: You will need to have [PHP](https://www.php.net/) installed on your machine._

```bash
sh generate_doc.sh

# or for Windows users
bash generate_doc.sh
```
