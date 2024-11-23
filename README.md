# Job Listing API - Backend Case Study

This project is a backend case study for building a Job Listing API. It includes authentication, CRUD operations for job listings, advanced search, filtering, pagination, and testing. The API is designed to help manage job listings and applicants.

## Prerequisites

Before setting up the project, make sure you have the following installed on your machine:

- PHP (preferably the latest stable version)
- Composer (dependency management)
- MySQL
- Laravel (latest version)
- Git (for version control)

## Setup Instructions

Start by cloning the repository to your local machine:

```bash
git clone https://github.com/your-username/PHP-job-list-project.git
cd job-listing-api
```

Run the following command to install the required PHP dependencies:

```bash
composer install
```


Copy the `.env.example` file to create a `.env` file:

```bash
cp .env.example .env
```

Open the `.env` file and configure your database settings:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_listing_db
DB_USERNAME=root
DB_PASSWORD=
```

Ensure you replace the database values with the correct credentials for your environment.

Laravel requires an application key for security. You can generate one using the following command:

```bash
php artisan key:generate
```

The database schema is managed by Laravel migrations. Run the following command to create the necessary database tables:

```bash
php artisan migrate
```





Once the setup is complete, you can run the development server:

```bash
php artisan serve
```

This will start the server at `http://localhost:8000`.

To run the tests and make sure everything is functioning as expected, use the following command:

```bash
php artisan test
```

This will execute the test suite and show you the results.

## API Endpoints

Here are some of the main API endpoints:

- **POST /api/register** - Register a new user (authentication).
- **POST /api/login** - Login an existing user.
- **GET /api/jobs** - Get a list of all job listings.
- **POST /api/jobs** - Create a new job listing.
- **GET /api/jobs/{id}** - Get a specific job listing by ID.
- **PUT /api/jobs/{id}** - Update a job listing.
- **DELETE /api/jobs/{id}** - Delete a job listing.

### Authentication

This API uses token-based authentication. After registering or logging in, you will receive a token which should be included in the `Authorization` header for protected routes.

The project follows MVC architecture using the Laravel framework. For pagination, use query parameters like `?page=1` for the job listings API. The API supports advanced filtering based on job type, location, salary range, etc.

Feel free to fork this repository and submit pull requests for any improvements.


