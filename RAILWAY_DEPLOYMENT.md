# 🚀 Railway Deployment Guide

## Prerequisites
- ✅ Git repository (already setup)
- ✅ Railway account (sign up at https://railway.app)
- ✅ GitHub account connected to Railway

## Step 1: Commit and Push Your Changes

```bash
# Add all changes
git add .

# Commit with a message
git commit -m "Complete housekeeping system with mobile responsiveness and GPS verification"

# Push to GitHub
git push origin main
```

## Step 2: Deploy to Railway

### Option A: Deploy from Railway Dashboard (Recommended)

1. **Login to Railway**
   - Go to https://railway.app
   - Sign in with your GitHub account

2. **Create New Project**
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose your repository: `eliyasakondo/housekeeping-system`
   - Railway will auto-detect Laravel and use `nixpacks.toml`

3. **Add MySQL Database**
   - In your project, click "New"
   - Select "Database" → "Add MySQL"
   - Railway will automatically create the database

4. **Configure Environment Variables**
   - Click on your Laravel service
   - Go to "Variables" tab
   - Add these variables:

```bash
APP_NAME="HK Checklist"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (Railway will auto-provide these, just verify):
DB_CONNECTION=mysql
DB_HOST=${{MYSQL.RAILWAY_PRIVATE_DOMAIN}}
DB_PORT=3306
DB_DATABASE=${{MYSQL.MYSQLDB_DATABASE}}
DB_USERNAME=${{MYSQL.MYSQLUSER}}
DB_PASSWORD=${{MYSQL.MYSQL_ROOT_PASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=public

# Mail (optional - for password resets)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Generate these with: php artisan key:generate
APP_KEY=base64:YOUR_32_CHARACTER_KEY_HERE
```

5. **Generate APP_KEY Locally**
   ```bash
   php artisan key:generate --show
   ```
   Copy the output and paste it as `APP_KEY` in Railway

6. **Deploy**
   - Railway will automatically deploy
   - Wait 2-5 minutes for deployment
   - Check "Deployments" tab for progress

### Option B: Deploy with Railway CLI

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Initialize
railway init

# Link to project
railway link

# Add MySQL database
railway add --database mysql

# Deploy
railway up
```

## Step 3: Post-Deployment Setup

### 1. Create Admin User
Railway will run migrations and seeders automatically (configured in `nixpacks.toml`).

Default admin credentials:
- Email: `admin@admin.com`
- Password: `password`

**⚠️ IMPORTANT:** Change the admin password immediately after first login!

### 2. Verify Deployment
Visit your Railway URL and check:
- ✅ Homepage loads
- ✅ Login works
- ✅ Admin dashboard accessible
- ✅ Database connection working
- ✅ File uploads work
- ✅ Mobile responsiveness

### 3. Configure Custom Domain (Optional)
- In Railway project → Settings → Domains
- Add your custom domain
- Update DNS records as shown
- Update `APP_URL` environment variable

## Environment Variables Reference

| Variable | Production Value | Description |
|----------|-----------------|-------------|
| `APP_ENV` | `production` | Environment mode |
| `APP_DEBUG` | `false` | Disable debug mode in production |
| `APP_URL` | Your Railway URL | Application URL |
| `DB_CONNECTION` | `mysql` | Database driver |
| `SESSION_DRIVER` | `database` | Use database for sessions |
| `CACHE_DRIVER` | `database` | Use database for cache |
| `FILESYSTEM_DISK` | `public` | Local file storage |

## Railway Configuration Files

### `nixpacks.toml` (Already created)
This file tells Railway how to build and run your Laravel app:
- Installs PHP 8.2 and Composer
- Runs `composer install`
- Caches config and routes
- Runs migrations and seeds on startup
- Serves the app on Railway's assigned port

## Troubleshooting

### Issue: 500 Error After Deployment
**Solution:**
1. Check Railway logs: Click on deployment → View Logs
2. Verify `APP_KEY` is set
3. Ensure database variables are correct

### Issue: Database Connection Failed
**Solution:**
1. Verify MySQL database is running in Railway
2. Check database variables match Railway's provided values
3. Use Railway's private domain for `DB_HOST`

### Issue: Storage/Upload Issues
**Solution:**
1. Verify `FILESYSTEM_DISK=public`
2. Railway runs `php artisan storage:link` automatically
3. Check file permissions in logs

### Issue: Migrations Not Running
**Solution:**
Railway auto-runs migrations via `nixpacks.toml`. If needed, run manually:
```bash
railway run php artisan migrate --force
```

## Monitoring & Logs

- **View Logs:** Railway Dashboard → Your Service → Logs
- **Metrics:** Dashboard shows CPU, Memory, Network usage
- **Restart:** Settings → Restart

## Updating Your App

```bash
# Make changes locally
git add .
git commit -m "Your update message"
git push origin main

# Railway auto-deploys on push!
```

## Production Checklist

- [ ] All environment variables set
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production` set
- [ ] APP_KEY generated and set
- [ ] MySQL database connected
- [ ] Admin password changed
- [ ] GPS coordinates added to properties
- [ ] Test mobile responsiveness
- [ ] Test calendar assignment
- [ ] Test checklist workflow
- [ ] Test photo uploads
- [ ] Verify user roles work

## Estimated Costs

Railway offers:
- **Hobby Plan:** $5/month (500 hours execution time)
- **MySQL Database:** Included in Hobby plan
- **Bandwidth:** Generous free tier

Perfect for small to medium housekeeping operations!

## Security Recommendations

1. **Change Default Admin Password** immediately
2. Set `APP_DEBUG=false` in production
3. Use strong passwords for all users
4. Keep Laravel and dependencies updated
5. Enable HTTPS (Railway provides SSL automatically)
6. Regular database backups (Railway provides automatic backups)

## Support

- Railway Docs: https://docs.railway.app
- Laravel Docs: https://laravel.com/docs
- Project Issues: https://github.com/eliyasakondo/housekeeping-system/issues

---

🎉 **Your housekeeping system is now live on Railway!**
