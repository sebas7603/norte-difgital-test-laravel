# Norte Digital Test

This is a Laravel project created as a test for the job application at "Norte Digital". The project is a Sales Management System. Simulating a company that has branches across LATAM and needs to keep track of its suppliers, sales representatives, customers, products, and sales.

![Database Model](/Modelo-relacional-de-BBDD-Norte-Digital.jpg)

## Getting Started

To run this project locally on your machine, follow these steps:

### Prerequisites

1. Make sure you have PHP (>= 8.1) and Composer installed on your system.
2. Install MySQL and create a new database for this project.

### Installation

1. Clone the repository to your local machine:

```bash
git clone https://github.com/sebas7603/norte-digital-test-laravel.git
cd norte-digital-test-laravel
```

2. Install the required dependencies using Composer:

```bash
composer install
```

3. Create a copy of the `.env.example` file and rename it to `.env`. Update the database configuration in the `.env` file with your MySQL credentials:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Run the database migrations and seeders:

```bash
php artisan migrate --seed
```

### Running the Application

You can now run the development server:

```bash
php artisan serve
```

The application should be accessible at `http://localhost:8000` in your web browser.

## Documentation

For more detailed information on how the project works, you can refer to the [Project Documentation](https://documenter.getpostman.com/view/12519140/2s9XxyQYuS). The documentation contains detailed explanations of the project's architecture, endpoints, and other relevant information.

## Contact

If you have any questions or need further assistance, you can contact me via email at [sebastianutpae@gmail.com](mailto:sebastianutpae@gmail.com).

Thank you for reviewing my test project!
