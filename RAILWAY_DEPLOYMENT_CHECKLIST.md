# ⚡ RAILWAY DEPLOYMENT - QUICK CHECKLIST

**Platform:** Railway.app  
**Time:** 20 minutes  
**Cost:** FREE ($5 credit/month)

---

## ✅ PRE-DEPLOYMENT CHECKLIST

- [ ] Your Laravel app is working locally (http://127.0.0.1:8000)
- [ ] You have a GitHub account
- [ ] You have Git installed
- [ ] Database is using MySQL (not SQLite)

---

## 🚀 DEPLOYMENT STEPS

### Step 1: Prepare Your Project (5 min)

```powershell
# Navigate to your project
cd C:\xampp\htdocs\housekeeping

# Create/update .gitignore
echo "vendor/" > .gitignore
echo "node_modules/" >> .gitignore
echo ".env" >> .gitignore
echo "storage/logs/*" >> .gitignore
echo "storage/framework/cache/*" >> .gitignore
echo "storage/framework/sessions/*" >> .gitignore
echo "storage/framework/views/*" >> .gitignore
echo "public/storage" >> .gitignore

# Initialize git (if not done)
git init
git add .
git commit -m "Initial commit - Ready for Railway"
```

- [ ] Git initialized
- [ ] Files committed

---

### Step 2: Update composer.json (2 min)

Open `composer.json` and add this to the `scripts` section:

```json
{
  "scripts": {
    "post-install-cmd": [
      "php artisan key:generate --ansi --force",
      "php artisan migrate --force",
      "php artisan db:seed --force",
      "php artisan storage:link --force",
      "php artisan config:cache",
      "php artisan route:cache"
    ],
    "post-update-cmd": [
      "php artisan config:cache",
      "php artisan route:cache"
    ]
  }
}
```

```powershell
# Commit the changes
git add composer.json
git commit -m "Add Railway deployment scripts"
```

- [ ] composer.json updated
- [ ] Changes committed

---

### Step 3: Create GitHub Repository (3 min)

1. Go to https://github.com
2. Click "+" → "New repository"
3. Name: `housekeeping-demo`
4. Make it Public (for free deployment)
5. Don't add README, .gitignore, or license
6. Click "Create repository"

```powershell
# Link your local repo to GitHub
git remote add origin https://github.com/YOUR_USERNAME/housekeeping-demo.git
git branch -M main
git push -u origin main
```

- [ ] GitHub repository created
- [ ] Code pushed to GitHub

---

### Step 4: Create Railway Account (2 min)

1. Go to https://railway.app
2. Click "Login"
3. Click "Login with GitHub"
4. Authorize Railway
5. Verify your email

- [ ] Railway account created
- [ ] Email verified

---

### Step 5: Deploy to Railway (3 min)

1. In Railway dashboard, click "+ New Project"
2. Select "Deploy from GitHub repo"
3. Choose your `housekeeping-demo` repository
4. Railway will auto-detect Laravel
5. Click "Deploy"
6. Wait for build (2-3 minutes)

- [ ] Project created
- [ ] Deployment started

---

### Step 6: Add MySQL Database (1 min)

1. In your Railway project dashboard
2. Click "+ New"
3. Select "Database"
4. Choose "Add MySQL"
5. MySQL will be created automatically
6. Connection details will auto-populate

- [ ] MySQL database added
- [ ] Variables connected

---

### Step 7: Configure Environment Variables (3 min)

1. Click on your app service (not MySQL)
2. Go to "Variables" tab
3. Click "RAW Editor"
4. Paste this:

```env
APP_NAME=HK Checklist
APP_ENV=production
APP_DEBUG=false
APP_URL=https://housekeeping-demo-production.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

LOG_CHANNEL=stack
LOG_LEVEL=error
```

4. Click "Update variables"
5. App will auto-redeploy

- [ ] Environment variables added
- [ ] App redeployed

---

### Step 8: Generate Domain (1 min)

1. In your app service, click "Settings"
2. Scroll to "Networking" section
3. Click "Generate Domain"
4. Copy your URL (example: `housekeeping-demo-production.up.railway.app`)

- [ ] Domain generated
- [ ] URL copied

---

### Step 9: Test Your Application (2 min)

Visit your Railway URL and test:

- [ ] Homepage loads
- [ ] Login page works
- [ ] Can login as admin (admin@housekeeping.com / password)
- [ ] Dashboard shows
- [ ] No errors

---

## 🎯 YOUR LIVE DEMO URL

```
https://housekeeping-demo-production.up.railway.app
```

---

## 🔐 TEST CREDENTIALS FOR CONTEST

```
ADMIN LOGIN:
Email: admin@housekeeping.com
Password: password

OWNER LOGIN:
Email: owner@housekeeping.com
Password: password

HOUSEKEEPER LOGIN:
Email: housekeeper@housekeeping.com
Password: password
```

---

## 🐛 TROUBLESHOOTING

### Error: "Application Key Not Set"
**Fix:**
1. Go to Variables tab
2. Add manually: `APP_KEY=base64:YOUR_KEY_HERE`
3. Or trigger redeploy

### Error: "Connection refused (MySQL)"
**Fix:**
1. Make sure MySQL service is created
2. Check variables use `${{MYSQL_HOST}}` format
3. Redeploy app

### Error: "500 Internal Server Error"
**Fix:**
1. Click "View Logs"
2. Look for actual error
3. Usually missing storage link or permissions

### Site is slow/sleeping
**Fix:**
This is normal on free tier. First request wakes it up (30s).
Subsequent requests are fast.

---

## 💰 MONITORING CREDITS

1. Go to Railway dashboard
2. Click your profile icon
3. Select "Account Settings"
4. See "Usage" section

**$5 credits should last 30+ days for a demo!**

---

## 🎨 CUSTOM DOMAIN (Optional)

If you want `housekeeping-demo.com` instead of Railway subdomain:

1. Buy domain (Namecheap, $1/year)
2. In Railway: Settings → Add custom domain
3. Update DNS records
4. Wait 5 minutes for SSL

---

## 📊 DEPLOYMENT CHECKLIST SUMMARY

```
✅ Step 1: Prepare project (Git setup)           5 min
✅ Step 2: Update composer.json                  2 min
✅ Step 3: Push to GitHub                        3 min
✅ Step 4: Create Railway account                2 min
✅ Step 5: Deploy app                            3 min
✅ Step 6: Add MySQL                             1 min
✅ Step 7: Configure variables                   3 min
✅ Step 8: Generate domain                       1 min
✅ Step 9: Test application                      2 min
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TOTAL TIME:                                     22 min
```

---

## 🎯 WHAT TO SUBMIT TO CONTEST

### In Your Contest Entry:

```
🔗 Live Demo URL:
https://housekeeping-demo-production.up.railway.app

👤 Login Credentials:

Admin:
Email: admin@housekeeping.com
Password: password

Owner:
Email: owner@housekeeping.com
Password: password

Housekeeper:
Email: housekeeper@housekeeping.com
Password: password

📚 Documentation:
See attached diagrams and system overview

✅ Status: Fully functional, production-ready
```

---

## 🚀 READY TO DEPLOY?

**Start with Step 1 above and work through each checkbox!**

**Estimated Time:** 20-25 minutes  
**Difficulty:** Easy (follow step-by-step)  
**Result:** Professional live demo URL

---

## 💡 PRO TIP

After deployment, take screenshots:
1. Homepage
2. Login page
3. Admin dashboard
4. Owner calendar
5. Housekeeper checklist
6. Photo gallery

Use these in your contest submission!

---

**Good luck! Railway is the easiest and most professional option for your demo! 🎉**
