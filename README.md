# Osamunime - Anime Favorite Tracker

**Student Name:** [Your Name]  
**NIM:** [Your NIM]

## Description

Osamunime is a multi-user web application that allows users to search and view anime data from a public API, then save their favorite anime to a personal collection. The application is built with Laravel and consumes the Jikan API (unofficial MyAnimeList API).

## Technologies Used

- **Backend Framework:** Laravel
- **Frontend:** Blade Templates + Bootstrap
- **Database:** SQLite (for development)
- **Authentication:** Laravel Session (bcrypt password hashing)
- **Public API:** Jikan API (MyAnimeList)
- **Version Control:** Git & GitHub

## Features

### Authentication (Multi-User)
- Register new accounts
- User login/logout
- Passwords stored as bcrypt hashes
- Data isolation (users only access their own data)

### Anime Functionality
- View top anime from API
- Search anime by title
- View detailed anime information

### Favorites System (CRUD)
- **Create:** Save anime from API to personal favorites
- **Read:** View personal favorite list
- **Update:** Modify watching status and add notes
- **Delete:** Remove anime from favorites

## Installation

1. Clone the repository:
```bash
git clone https://github.com/shineistu86/Osamunime-App.git
cd Osamunime-App
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Copy the environment file and configure:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run database migrations:
```bash
php artisan migrate
```

6. Compile assets:
```bash
npm run dev
```

7. Start the development server:
```bash
php artisan serve
```

## Usage

1. Visit the application in your browser
2. Register a new account or log in
3. Browse top anime or search for specific titles
4. View anime details
5. Add anime to your favorites
6. Manage your favorite list (update status, add notes, remove)

## API Integration

The application integrates with the Jikan API to fetch anime data:
- Base URL: `https://api.jikan.moe/v4`
- Endpoints used:
  - `/top/anime` - Get top anime
  - `/anime?q={keyword}` - Search anime by keyword
  - `/anime/{id}` - Get detailed anime information

## Database Schema

The application uses the following main tables:
- `users` - Standard Laravel users table
- `favorites` - Stores user's favorite anime with fields:
  - id
  - user_id
  - anime_id
  - title
  - image_url
  - score
  - rating
  - review
  - status
  - notes
  - created_at
  - updated_at
- `tags` - Stores tags for categorizing favorites
- `favorite_tag` - Pivot table connecting favorites and tags

## Environment Configuration

For production deployment, configure these environment variables:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=sqlite` (for local development) or `external_mysql` (for deployment to serverless platforms)
- `DB_HOST=your_db_host` (when using external database)
- `DB_PORT=your_db_port` (when using external database)
- `DB_DATABASE=your_db_name` (when using external database)
- `DB_USERNAME=your_db_username` (when using external database)
- `DB_PASSWORD=your_db_password` (when using external database)
- `JIKAN_API_BASE_URL=https://api.jikan.moe/v4`

### External Database Configuration (for Serverless Platforms like Vercel)

When deploying to serverless platforms, you must use an external database because SQLite files are ephemeral and will be lost when the serverless function is not active.

For external MySQL database, configure these additional variables:
- `EXTERNAL_DB_HOST` - Host dari database MySQL eksternal
- `EXTERNAL_DB_PORT` - Port dari database MySQL (default: 3306)
- `EXTERNAL_DB_DATABASE` - Nama database
- `EXTERNAL_DB_USERNAME` - Username untuk koneksi ke database
- `EXTERNAL_DB_PASSWORD` - Password untuk koneksi ke database
- `EXTERNAL_MYSQL_ATTR_SSL_CA` - Path ke file SSL certificate authority jika database memerlukan koneksi SSL

## Testing

Run the application tests:
```bash
php artisan test
```

## Screenshots

![Homepage](screenshots/homepage.png)
![Anime Search](screenshots/search.png)
![Anime Detail](screenshots/detail.png)
![Favorites](screenshots/favorites.png)

## Deployment

The application can be deployed to various hosting platforms. For production deployment:

1. Set `APP_ENV=production` and `APP_DEBUG=false` in your environment
2. Configure your production database settings
3. Run migrations after deployment: `php artisan migrate`
4. Configure your web server to point to the `public` directory
5. Set proper file permissions for storage and bootstrap/cache directories

## Repository

GitHub Repository: https://github.com/shineistu86/Osamunime-App.git

## License

This project is open source and available under the [MIT License](LICENSE).