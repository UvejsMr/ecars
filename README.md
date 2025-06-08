# eCars - Car Marketplace Platform

eCars is a modern web application built with Laravel that serves as a comprehensive car marketplace platform. It allows users to buy and sell cars, with additional features for car servicing and administration.

## Features

### For Regular Users
- Browse and search for cars
- View detailed car listings with images and specifications
- Chat with sellers
- Book car inspections
- Add cars to watchlist
- Post cars for sale
- Manage personal car listings
- View car history and details

### For Servicers
- View and manage inspection requests
- Verify car conditions
- Provide inspection reports
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
- **Real-time Features:** Laravel Echo

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
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
DB_DATABASE=ecars
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Create storage link:
```bash
php artisan storage:link
```

9. Start the development server:
```bash
php artisan serve
```

10. In a separate terminal, start Vite:
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
- Can verify car conditions
- Has access to servicer dashboard

### Administrator
- Can manage all user accounts
- Can monitor all car listings
- Can verify servicer accounts
- Has access to admin dashboard
- Can manage system settings

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email [um30025@seeu.edu.mk](mailto:um30025@seeu.edu.mk) or open an issue in the repository.
