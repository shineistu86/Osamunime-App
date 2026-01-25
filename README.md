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
- **Deployment:** Railway.app (optional)

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
  - status
  - notes
  - created_at
  - updated_at

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

The application can be deployed to platforms like Railway.app. For deployment:

1. Connect your GitHub repository to Railway
2. Configure environment variables
3. Run migrations after deployment

## Repository

GitHub Repository: https://github.com/shineistu86/Osamunime-App.git

## License

This project is open source and available under the [MIT License](LICENSE).