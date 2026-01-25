# Deployment Guide for Railway.app

## Overview
This guide explains how to deploy the Osamunime-App to Railway.app with proper database configuration.

## Why Switch from SQLite to PostgreSQL/MySQL?

Railway.app uses containerized environments where file persistence is limited. SQLite databases stored on the local filesystem will be lost when containers restart. For reliable deployments, it's recommended to use PostgreSQL or MySQL services provided by Railway.

## Step-by-Step Deployment Process

### 1. Prepare Your Repository
Make sure your repository is up-to-date with all changes:
```bash
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

### 2. Create Railway Account and Project
1. Go to [Railway.app](https://railway.app) and create an account
2. Click "New Project" 
3. Select "Deploy from GitHub"
4. Choose your Osamunime-App repository

### 3. Configure Environment Variables
After connecting your repository, click on "Variables" in the Railway dashboard and add:

```
APP_NAME=Osamunime-App
APP_ENV=production
APP_KEY= # Leave empty, Railway will generate this
APP_DEBUG=false
APP_URL=https://[your-app-name].up.railway.app
JIKAN_API_BASE_URL=https://api.jikan.moe/v4
```

### 4. Add a Database Plugin
1. Go to the "Plugins" tab in your Railway project
2. Click "New" and select "PostgreSQL" (recommended) or "MySQL"
3. Railway will automatically add database connection variables

### 5. Update Build & Start Commands
Go to the "Settings" tab in your Railway project and make sure the following are set:

Build Command: `npm run build`
Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### 6. Deploy
Click "Deploy Now" in the Railway dashboard to trigger the first deployment.

### 7. Run Initial Migrations
After the first successful deployment:
1. Go to the "Logs" tab to confirm the app is running
2. Open the Railway CLI or use the web terminal
3. Run the command: `php artisan migrate --force`

## Alternative: Using SQLite with Persistent Storage

While not recommended, if you insist on using SQLite, you can configure it to use Railway's temporary storage. However, note that data may still be lost during deployments or container restarts.

To use SQLite on Railway:
1. Keep `DB_CONNECTION=sqlite` in your environment variables
2. Set `DB_DATABASE=/tmp/database.sqlite`
3. Make sure your application handles database initialization on startup

## Troubleshooting Common Issues

### Issue: Database Connection Error
- Verify that your database plugin is properly connected
- Check that environment variables are correctly set
- Ensure migrations have been run

### Issue: Assets Not Loading
- Confirm that `npm run build` completes successfully during deployment
- Check that asset paths are correctly configured for production

### Issue: Application Crashes on Startup
- Review logs in the Railway dashboard
- Ensure all required environment variables are set
- Verify that the port is correctly configured using `$PORT` variable

## Best Practices for Railway Deployment

1. Always use the `$PORT` environment variable provided by Railway
2. Use PostgreSQL or MySQL instead of SQLite for production
3. Store sensitive information in Railway variables, not in code
4. Test your deployment process in a staging environment first
5. Monitor application logs regularly after deployment