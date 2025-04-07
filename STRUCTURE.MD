# Project Structure and Technologies

## Project Overview
This is a Laravel-based PHP service project that utilizes modern web development technologies and follows Laravel's recommended architecture.

## Technologies Used

### Core Technologies
- PHP 8.0+
- Laravel Framework 8.75
- Composer (PHP Package Manager)
- NPM (Node Package Manager)

### Key Dependencies
- Firebase PHP-JWT 6.10 - For JWT authentication
- Laravel Sanctum 2.11 - For API authentication
- Laravel CORS - For handling Cross-Origin Resource Sharing
- GuzzleHTTP 7.0.1 - For HTTP requests
- Laravel Mix - For asset compilation

## Detailed Project Structure

```plaintext
service_php/
├── app/                    
│   ├── Console/           
│   ├── Exceptions/        
│   ├── Http/              
│   │   ├── Controllers/   
│   │   │   ├── API/      # API Controllers
│   │   │   │   ├── AuthController.php
│   │   │   │   └── UserController.php
│   │   │   └── Controller.php
│   │   ├── Middleware/    
│   │   ├── Requests/      # Form requests for validation
│   │   │   ├── Auth/
│   │   │   │   ├── LoginRequest.php
│   │   │   │   └── RegisterRequest.php
│   │   │   └── API/
│   │   └── Resources/    # API Resources for response transformation
│   │       └── UserResource.php
│   ├── Models/           
│   ├── Services/         # Business Logic Layer
│   │   ├── Auth/        # Authentication related services
│   │   │   ├── AuthService.php
│   │   │   └── JWTService.php
│   │   ├── User/        # User related services
│   │   │   └── UserService.php
│   │   └── Base/        # Base service classes
│   │       └── BaseService.php
│   ├── Repositories/    # Data Access Layer
│   │   ├── Interfaces/ # Repository interfaces
│   │   │   └── UserRepositoryInterface.php
│   │   ├── Eloquent/   # Eloquent implementations
│   │   │   └── UserRepository.php
│   │   └── Base/       # Base repository classes
│   │       └── BaseRepository.php
│   ├── Traits/         # Reusable traits
│   │   ├── ApiResponse.php
│   │   └── ServiceResponse.php
│   ├── Constants/      # Application constants
│   │   └── ErrorConstants.php
│   └── Providers/      
│       ├── RepositoryServiceProvider.php  # Bind repositories
│       └── [Other providers...]
│   ├── Models/            # Database models
│   └── Providers/         # Service providers
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── BroadcastServiceProvider.php
│       ├── EventServiceProvider.php
│       └── RouteServiceProvider.php
├── bootstrap/             # Framework bootstrap files
│   ├── app.php
│   └── cache/            # Framework cache files
├── config/               # Configuration files
│   ├── app.php          # Main app configuration
│   ├── auth.php         # Authentication configuration
│   ├── cors.php         # CORS configuration
│   ├── database.php     # Database configuration
│   ├── logging.php      # Logging configuration
│   ├── mail.php         # Mail configuration
│   └── services.php     # Third-party services configuration
├── database/            
│   ├── factories/       # Model factories for testing
│   ├── migrations/      # Database migrations
│   └── seeders/        # Database seeders
├── public/              # Publicly accessible files
│   ├── index.php       # Entry point
│   ├── css/            # Compiled CSS
│   ├── js/             # Compiled JavaScript
│   └── storage/        # Public storage symlink
├── resources/
│   ├── css/            # Source CSS files
│   ├── js/             # Source JavaScript files
│   ├── lang/           # Language files
│   └── views/          # Blade templates
│       ├── layouts/    # Layout templates
│       └── welcome.blade.php
├── routes/              # Application routes
│   ├── api.php         # API routes
│   ├── channels.php    # Broadcasting channels
│   ├── console.php     # Console commands
│   └── web.php         # Web routes
├── storage/            # Application storage
│   ├── app/           # Application storage
│   │   └── public/    # Public storage
│   ├── framework/     # Framework storage
│   │   ├── cache/    
│   │   ├── sessions/
│   │   └── views/
│   └── logs/          # Application logs
├── tests/             # Test files
│   ├── Feature/       # Feature tests
│   ├── Unit/          # Unit tests
│   └── TestCase.php   # Base test case
├── vendor/            # Composer dependencies
├── .env              # Environment configuration
├── .env.example      # Example environment configuration
├── .gitignore        # Git ignore rules
├── artisan           # Laravel command line tool
├── composer.json     # Composer dependencies
├── composer.lock     # Composer lock file
├── package.json      # NPM dependencies
├── phpunit.xml      # PHPUnit configuration
├── webpack.mix.js   # Laravel Mix configuration
└── Dockerfile       # Docker configuration