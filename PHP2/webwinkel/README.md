# Webwinkel Project

## Overview
The Webwinkel project is a PHP-based web application designed to manage user registration and authentication for an online store. It utilizes object-oriented programming principles to encapsulate user-related functionality within a dedicated User class.

## Project Structure
```
webwinkel
├── src
│   ├── User.php          # Contains the User class for managing user data and functionality.
│   ├── db.php            # Handles the database connection using PDO.
│   └── types
│       └── index.php     # Exports necessary types or interfaces for type safety.
├── public
│   ├── index.php         # Entry point for the web application.
│   ├── login.php         # Contains the login form and authentication logic.
│   └── register.php      # Includes the registration form and logic for new users.
├── composer.json          # Configuration file for Composer dependencies and autoloading.
└── README.md              # Documentation for the project.
```

## Setup Instructions
1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd webwinkel
   ```

2. **Install Dependencies**
   Ensure you have Composer installed, then run:
   ```bash
   composer install
   ```

3. **Database Configuration**
   Update the `db.php` file with your database connection details:
   ```php
   $host = 'localhost';
   $dbname = 'your_database_name';
   $username = 'your_username';
   $password = 'your_password';
   ```

4. **Create Database Tables**
   Run the SQL script to create the necessary tables for user management.

## Usage
- **Registration**: Navigate to `public/register.php` to create a new user account.
- **Login**: Navigate to `public/login.php` to authenticate an existing user.
- **Home Page**: Access the main application through `public/index.php`.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.