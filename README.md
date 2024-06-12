# MentorMe Server-Side Code

This repository contains the server-side code for the MentorMe Android app with RESTful APIs.

## Setup Instructions

### Clone the Repository

```bash
git clone https://github.com/Vaneeza-7/Server-Side-Code-for-mentorme-android-app-with-restful-api.git
```

### Install Dependencies

Ensure you have the XAMPP server with MySQL installed.

### Set Up the Project

1. **Move Project Folder:**

   Move the `mentorme` folder from the cloned repository to the `htdocs` folder in your XAMPP installation directory. The typical path is:
   ```
   C:\xampp\htdocs
   ```

2. **Start XAMPP:**

   Open the XAMPP Control Panel and start the Apache and MySQL modules.

3. **Set Up the Database:**

   - Open your web browser and go to `http://localhost/phpmyadmin`.
   - Create a new database named `mentorme`.
   - The schema file is not provided here but you can easily figure it out from the php files and set up the tables.
     (sorry for inconvenience)

4. **Configure Database Connection:**

   - Open the `dbconfig.php` file located inside the `mentorme` folder.
   - Update the database connection settings (hostname, username, password, database name) to match your MySQL configuration:
     ```php
     <?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "mentorme";
     ?>
     ```

### Access the Application

Once the setup is complete, you can access the application by navigating to:
```
http://localhost/mentorme
```

For additional information, please refer to the [main app repository.](https://github.com/Vaneeza-7/Mentor-me-android-app-with-RESTful-APIs).
