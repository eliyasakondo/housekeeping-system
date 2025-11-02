# 🗑️ Clear Database - Production Railway

## Purpose
Clear all sample data from Railway production database, keeping only 3 essential users:
- 1 Admin
- 1 Owner  
- 1 Housekeeper

## What Gets Deleted
- ❌ All properties
- ❌ All rooms
- ❌ All tasks
- ❌ All checklists
- ❌ All checklist items
- ❌ All photos
- ❌ All extra users (keeping only 1 of each role)
- ❌ All sessions

## What Gets Kept
- ✅ 1 Admin user
- ✅ 1 Owner user
- ✅ 1 Housekeeper user

---

## Method 1: Using Railway CLI (Recommended)

### Step 1: Install Railway CLI
```bash
# Windows (PowerShell)
iwr https://railway.app/install.ps1 | iex

# Or download from: https://docs.railway.app/guides/cli
```

### Step 2: Login to Railway
```bash
railway login
```

### Step 3: Link to Your Project
```bash
cd c:\xampp\htdocs\housekeeping
railway link
```
Select your project: **housekeeping-system-production**

### Step 4: Run the Command
```bash
railway run php artisan data:clear --force
```

This will clear all data on Railway production database!

---

## Method 2: Using Railway Dashboard (If CLI doesn't work)

### Option A: Using Railway Shell

1. Go to: https://railway.app/dashboard
2. Select your project: **housekeeping-system-production**
3. Click on your service
4. Go to **Settings** tab
5. Scroll to **Service Settings**
6. Look for **Railway Shell** or **Console** option
7. Open shell and run:
   ```bash
   php artisan data:clear --force
   ```

### Option B: Using Deployment Variables

1. Go to Railway Dashboard
2. Select your project
3. Go to **Variables** tab
4. Add a temporary variable:
   - Name: `RUN_CLEAR_DATA`
   - Value: `true`
5. Trigger a new deployment
6. After deployment, run via Railway's shell:
   ```bash
   php artisan data:clear --force
   ```
7. Remove the `RUN_CLEAR_DATA` variable

---

## Method 3: Direct Database Access (Advanced)

### Using Railway Database URL

1. Get your database credentials from Railway:
   - Go to Railway Dashboard → Your Database Service
   - Copy the connection string

2. Connect using MySQL client:
   ```bash
   # Using Railway's DATABASE_URL
   railway run mysql
   ```

3. Run SQL commands manually (NOT RECOMMENDED - use artisan command instead)

---

## Verification After Cleanup

### Check Users Remaining:
```bash
railway run php artisan tinker
```

Then in tinker:
```php
\App\Models\User::all()->pluck('name', 'role', 'email');
exit
```

Should show exactly 3 users.

### Check Data Cleared:
```bash
railway run php artisan tinker
```

Then:
```php
\App\Models\Property::count();  // Should be 0
\App\Models\Task::count();      // Should be 0
\App\Models\Checklist::count(); // Should be 0
exit
```

---

## Important Notes

⚠️ **BACKUP FIRST** (if you want to keep any data):
```bash
# On Railway, this creates a backup
railway run pg_dump > backup.sql  # if using PostgreSQL
# or
railway run mysqldump > backup.sql  # if using MySQL
```

⚠️ **This action is IRREVERSIBLE!** All data except 3 users will be permanently deleted.

⚠️ After running this command:
- Your client can start fresh
- They need to:
  1. Create their own properties
  2. Add their own rooms and tasks
  3. Create housekeepers
  4. Start assigning work

---

## Quick Command Reference

```bash
# Test locally first
php artisan data:clear

# Run on Railway (with confirmation)
railway run php artisan data:clear

# Run on Railway (skip confirmation)
railway run php artisan data:clear --force
```

---

## Troubleshooting

### "Command not found"
- Make sure you've committed and pushed the changes to GitHub
- Railway needs to redeploy with the new command

### "Railway CLI not working"
- Use Railway Dashboard shell method instead
- Or contact Railway support

### "Users not found"
- Make sure you have at least 1 admin, 1 owner, 1 housekeeper in database
- Command will fail if any role is missing

---

**After clearing data, your client will have a clean slate to build their property management system!** 🎉
