# eCars - Car Marketplace Platform

eCars is a modern web application built with Laravel that serves as a comprehensive car marketplace platform. It allows users to buy and sell cars, with additional features for car servicing and administration.

## Features

### For Regular Users
- Browse and search for cars with sortings and filters
- View detailed car listings with images and specifications
- Chat with sellers
- Book car inspections
- Add cars to watchlist
- Post cars for sale
- Manage personal car listings
- View car details

### For Servicers
- View and manage inspection requests
- Update bussiness information
- Access servicer dashboard
- Manage service appointments

### For Administrators
- Manage user accounts
- Monitor car listings
- Verify servicer accounts
- Access comprehensive admin dashboard
- Manage system-wide settings
- View and manage all car listings

## Technical Stack

- **Backend Framework:** Laravel
- **Frontend:** Blade templates with Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **File Storage:** Laravel Storage

  ## Prerequisites

- PHP >= 8.1
- Composer
- Node.js and NPM
- MySQL (can be run via XAMPP)

> **Important:** Make sure you have [XAMPP](https://www.apachefriends.org/index.html) installed and running.
> Start **Apache** and **MySQL** using the XAMPP Control Panel before continuing.

## Installation

1. Clone the repository:
```bash
git clone [(https://github.com/UvejsMr/ecars.git)]
cd ecars
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in the `.env` file:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecarsmk
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Run database seeders (recommended):
```bash
php artisan db:seed --class=DatabaseSeeder
```
This will run the DatabaseSeeder, which includes:

- RoleSeeder – to create roles (Admin, User, Servicer)

- UserSeeder – to create a default admin user:

        Email: admin@ecars.com

        Password: admin123

9. Create storage link:
```bash
php artisan storage:link
```

10. Start the development server:
```bash
php artisan serve
```

11. In a separate terminal, start Vite:
```bash
npm run dev
```

## Usage

1. Register a new account or log in 
2. Browse available cars
3. Use the search and filter functions to find specific cars
4. View car details and contact sellers
5. Post your own cars for sale
6. Book inspections for cars you're interested in

## User Roles

### Regular User
- Can browse and search cars
- Can post cars for sale
- Can chat with sellers
- Can book inspections
- Can add cars to watchlist

### Servicer
- Can view inspection requests
- Can accept, mark as completed an appointment
- Has access to servicer dashboard

### Administrator
- Can manage all user accounts
- Can monitor all car listings
- Can verify servicer accounts
- Has access to admin dashboard
- Can manage system settings

## Acknowledgments

- The eCars project was developed by [Uvejs Murtezi](https://github.com/UvejsMr) as a Capstone Project required for Bachelor Degree of Computer Science at Southeast European University.
- Expressing deepest gratitude and special thanks to my mentor prof. Besnik Selimi for providing unwavering support, valuable feedback and guidance throughout developing the project.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email [um30025@seeu.edu.mk](mailto:um30025@seeu.edu.mk) or open an issue in the repository.
