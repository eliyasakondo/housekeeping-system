# 🧪 TESTING GUIDE - New Features

## Server Status
✅ Server running at: **http://127.0.0.1:8000**

---

## 📋 TEST PLAN OVERVIEW

### New Features to Test (Just Implemented):
1. ✅ **Beds/Baths on Properties**
2. ✅ **Owner Housekeeper Management** 
3. ✅ **Owner Room Management**

### Test Accounts:
```
ADMIN:
Email: admin@housekeeping.com
Password: password

OWNER:
Email: owner@housekeeping.com
Password: password

HOUSEKEEPER 1:
Email: maria@housekeeping.com
Password: password

HOUSEKEEPER 2:
Email: carlos@housekeeping.com
Password: password
```

---

## 🧪 TEST 1: BEDS/BATHS ON PROPERTIES

### Login as Owner
1. Go to: http://127.0.0.1:8000
2. Login: `owner@housekeeping.com` / `password`
3. Click **"Properties"** in navigation

### Test Create New Property
4. Click **"Add New Property"** button
5. **Fill in the form:**
   - Name: `Test Property with Beds/Baths`
   - **Beds: `3`** ← NEW FIELD
   - **Baths: `2.5`** ← NEW FIELD (supports half baths)
   - Address: `123 Test Street, Test City`
   - Latitude: `25.7617`
   - Longitude: `-80.1918`
   - Description: `Testing beds and baths feature`
6. Click **"Create Property"**

### Verify:
- ✅ Success message appears
- ✅ Property appears in list
- ✅ Click property name to view details
- ✅ **Beds: 3** shows in details
- ✅ **Baths: 2.5** shows in details

### Test Edit Existing Property
7. Go back to Properties list
8. Click **"Edit"** on "Sunset Beach House"
9. **Verify form shows:**
   - Beds field is pre-filled with `4`
   - Baths field is pre-filled with `3`
10. Change Beds to `5` and Baths to `3.5`
11. Click **"Update Property"**
12. View property details
13. **Verify changes saved:**
    - ✅ Beds: 5
    - ✅ Baths: 3.5

**✅ TEST 1 RESULT:** __________

---

## 🧪 TEST 2: OWNER HOUSEKEEPER MANAGEMENT

### Navigate to Housekeepers
1. Still logged in as `owner@housekeeping.com`
2. Click **"Housekeepers"** in navigation (new link!)

### Test View Housekeepers List
3. **Verify you see:**
   - ✅ Maria Rodriguez card with email and phone
   - ✅ Carlos Santos card with email and phone
   - ✅ **Active Assignments** count
   - ✅ **Completed Checklists** count
   - ✅ "Member Since" date
   - ✅ Edit and Remove buttons

### Test Create New Housekeeper
4. Click **"Add New Housekeeper"** button
5. **Fill in the form:**
   - Name: `Sarah Johnson`
   - Email: `sarah@housekeeping.com`
   - Phone: `305-555-7890`
   - Password: `password123`
   - Confirm Password: `password123`
6. Click **"Create Housekeeper"**

### Verify:
- ✅ Success message: "Housekeeper created successfully"
- ✅ Sarah appears in housekeepers list
- ✅ Card shows all details correctly
- ✅ Active Assignments: 0
- ✅ Completed: 0

### Test Edit Housekeeper
7. Click **"Edit"** on Sarah Johnson
8. **Verify form is pre-filled:**
   - Name, Email, Phone all correct
   - Password fields are EMPTY (optional update)
9. Change Phone to: `305-555-9999`
10. Leave password fields EMPTY
11. Click **"Update Housekeeper"**
12. **Verify:**
    - ✅ Success message
    - ✅ Phone updated to new number
    - ✅ Can still login with old password (not changed)

### Test Password Change
13. Click **"Edit"** on Sarah again
14. Fill in:
    - Password: `newpassword`
    - Confirm Password: `newpassword`
15. Click **"Update Housekeeper"**
16. **Verify password changed:**
    - Logout
    - Try login: `sarah@housekeeping.com` / `newpassword`
    - ✅ Should login successfully

### Test Delete Housekeeper (No Active Assignments)
17. Login back as owner
18. Go to Housekeepers
19. Click **"Remove"** on Sarah Johnson
20. Confirm deletion
21. **Verify:**
    - ✅ Success message
    - ✅ Sarah removed from list

### Test Delete Prevention (Active Housekeeper)
22. Try to delete **Maria Rodriguez** (has active checklists)
23. **Expected behavior:**
    - ⚠️ Error message: "Cannot delete housekeeper with active assignments"
    - ✅ Maria still in list (not deleted)

**✅ TEST 2 RESULT:** __________

---

## 🧪 TEST 3: OWNER ROOM MANAGEMENT

### Navigate to Rooms
1. Still logged in as `owner@housekeeping.com`
2. Go to **"Properties"**
3. Click on **"Sunset Beach House"** to view details
4. Click **"Manage Rooms"** button (new feature!)

### Test View Rooms List
5. **Verify you see:**
   - ✅ List of rooms (Master Bedroom, Guest Room, Living Room, Kitchen)
   - ✅ Each card shows room name
   - ✅ Description displays
   - ✅ **Min Photos badge** (e.g., "Min: 8 photos")
   - ✅ Edit and Delete buttons
   - ✅ "Add Room" button at top

### Test Create New Room
6. Click **"Add Room"** button
7. **Fill in the form:**
   - Name: `Home Office`
   - Description: `Dedicated workspace with desk and bookshelf`
   - **Min Photos: `10`**
8. Click **"Create Room"**

### Verify:
- ✅ Success message: "Room created successfully"
- ✅ Redirected back to rooms list
- ✅ Home Office appears in list
- ✅ Min Photos badge shows: "Min: 10 photos"
- ✅ Description displays correctly

### Test Edit Room
9. Click **"Edit"** on "Home Office"
10. **Verify form is pre-filled:**
    - Name: Home Office
    - Description: matches what you entered
    - Min Photos: 10
11. Change:
    - Min Photos to: `12`
    - Description to: `Updated: Workspace with new equipment`
12. Click **"Update Room"**
13. **Verify:**
    - ✅ Success message
    - ✅ Min Photos badge now shows "Min: 12 photos"
    - ✅ Description updated

### Test Validation
14. Click **"Add Room"**
15. Try to submit with:
    - Name: (empty)
    - Min Photos: `100` (over max)
16. **Expected:**
    - ✅ Validation errors appear
    - ✅ Name is required
    - ✅ Min Photos must be between 1-50

### Test Delete Room (No Checklists)
17. Click **"Delete"** on "Home Office"
18. Confirm deletion
19. **Verify:**
    - ✅ Success message
    - ✅ Home Office removed from list

### Test Delete Prevention (Room in Use)
20. Try to delete **"Master Bedroom"** (has checklist items)
21. **Expected behavior:**
    - ⚠️ Error message: "Cannot delete room that has been used in checklists"
    - ✅ Master Bedroom still in list (protected)

### Test Navigation
22. Click **"Back to Property"** button
23. **Verify:**
    - ✅ Returns to property details page

**✅ TEST 3 RESULT:** __________

---

## 🧪 TEST 4: AUTHORIZATION & SECURITY

### Test Owner Isolation
1. Login as `owner@housekeeping.com`
2. Note the PropertyID of "Sunset Beach House" (should be 1)
3. **Try to access another owner's property:**
   - In URL, manually change property ID to `999`
   - Example: `http://127.0.0.1:8000/owner/properties/999/edit`
4. **Expected:**
   - ✅ 403 Forbidden or redirect
   - ✅ Cannot access other owner's data

### Test Housekeeper Access
5. Logout and login as `maria@housekeeping.com`
6. **Try to access owner URLs:**
   - `http://127.0.0.1:8000/owner/properties`
   - `http://127.0.0.1:8000/owner/housekeepers`
7. **Expected:**
   - ✅ Access denied or redirect
   - ✅ Only sees housekeeper menu items

### Test Admin Override
8. Logout and login as `admin@housekeeping.com`
9. Click **"Users"** in navigation
10. **Verify:**
    - ✅ Can see ALL users (admin, owners, housekeepers)
    - ✅ Can edit any user
    - ✅ Has full system access

**✅ TEST 4 RESULT:** __________

---

## 🧪 TEST 5: COMPLETE OWNER WORKFLOW

### Full Feature Integration Test
1. Login as `owner@housekeeping.com`

### Step 1: Create Property
2. Go to Properties → Add New Property
3. Create:
   - Name: `Miami Beach Condo`
   - **Beds: 2**
   - **Baths: 2**
   - Address: `456 Ocean Drive, Miami Beach, FL`
   - Latitude: `25.7907`
   - Longitude: `-80.1300`
   - Description: `Beachfront condo`
4. ✅ Property created

### Step 2: Add Rooms
5. Click **"Manage Rooms"** on Miami Beach Condo
6. Add room 1:
   - Name: `Master Suite`
   - Description: `King bed with ocean view`
   - Min Photos: `8`
7. Add room 2:
   - Name: `Guest Bedroom`
   - Description: `Queen bed`
   - Min Photos: `8`
8. Add room 3:
   - Name: `Kitchen`
   - Description: `Full kitchen with appliances`
   - Min Photos: `8`
9. ✅ All 3 rooms created

### Step 3: Verify Housekeeper Exists
10. Go to Housekeepers
11. ✅ Maria and Carlos are listed

### Step 4: Assign via Calendar
12. Click **"Calendar"** in navigation
13. Click a future date (e.g., tomorrow)
14. **Create assignment:**
    - Property: `Miami Beach Condo` ← NEW PROPERTY
    - Housekeeper: `Maria Rodriguez`
15. Click **"Assign"**
16. **Verify:**
    - ✅ Event appears on calendar
    - ✅ Colored as "Pending" (gray)
    - ✅ Shows property name and housekeeper

### Step 5: Verify Housekeeper Sees Assignment
17. Logout and login as `maria@housekeeping.com`
18. Go to **"My Schedule"** (calendar)
19. **Verify:**
    - ✅ Assignment for Miami Beach Condo appears
    - ✅ Only Maria's assignments visible (not Carlos's)

**✅ TEST 5 RESULT:** __________

---

## 🧪 TEST 6: HOUSEKEEPER WORKFLOW (Existing Features)

### Quick Verification of Existing System
1. Login as `maria@housekeeping.com`
2. Go to Dashboard
3. **Verify:**
   - ✅ Upcoming checklists display
   - ✅ Can click to start checklist
   - ✅ GPS verification prompt appears
   - ✅ Can check off tasks
   - ✅ Can upload multiple photos
   - ✅ Photo count validates against min_photos
   - ✅ Completion works

**✅ TEST 6 RESULT:** __________

---

## 📊 FINAL TEST SUMMARY

| Test | Feature | Status | Notes |
|------|---------|--------|-------|
| 1 | Beds/Baths on Properties | ☐ | |
| 2 | Housekeeper Management | ☐ | |
| 3 | Room Management | ☐ | |
| 4 | Authorization & Security | ☐ | |
| 5 | Complete Owner Workflow | ☐ | |
| 6 | Housekeeper Workflow | ☐ | |

---

## 🐛 BUGS FOUND

(Document any issues discovered during testing)

1. _______________________________________________
2. _______________________________________________
3. _______________________________________________

---

## ✅ TESTING COMPLETE CHECKLIST

After all tests pass:
- [ ] All new features work correctly
- [ ] No validation errors
- [ ] Authorization properly blocks unauthorized access
- [ ] Delete prevention works
- [ ] Forms pre-fill correctly
- [ ] Success/error messages display
- [ ] Navigation links work
- [ ] Calendar integration works
- [ ] No console errors in browser

**Ready for Screenshots?** ☐ YES ☐ NO

**Ready for Deployment?** ☐ YES ☐ NO

---

## 📸 NEXT STEPS AFTER TESTING

1. **Fix any bugs found**
2. **Take screenshots** for contest submission
3. **Deploy demo** to hosting
4. **Submit to freelancer.com**

Good luck! 🚀
