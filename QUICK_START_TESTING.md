# 🎯 QUICK START TESTING GUIDE

**Server:** http://127.0.0.1:8000 ✅ Running

---

## Test the Multi-Step Workflow (Priority 1)

### Login as Housekeeper
```
Email: housekeeper@housekeeping.com
Password: password
```

### Step-by-Step Test:

#### 1. Start Checklist
- Go to Dashboard → Click on assigned checklist
- Click "Start Checklist" button
- Allow location access (GPS verification)
- ✅ Should show: Step 1 - Room Tasks

#### 2. Complete First Room
- See ONLY first room displayed
- Check all task checkboxes
- ✅ "Complete Room" button should enable
- Click "Complete Room & Continue"
- ✅ Should move to next room

#### 3. Complete All Rooms
- Repeat for each room
- On last room, click "Complete Room"
- ✅ Should transition to Step 2 - Inventory

#### 4. Complete Inventory
- See 12 inventory items (Towels, Sheets, etc.)
- Enter quantity for each item
- Select "Available" or "Not Available"
- Click "Check" button for each item
- ✅ All items must be checked to proceed
- Click "Complete Inventory & Continue to Photos"
- ✅ Should transition to Step 3 - Photos

#### 5. Upload Photos
- See all rooms displayed
- Upload photos for each room (min 8 per room)
- ✅ Photos should show thumbnail with timestamp
- Click "Review & Submit Checklist"
- ✅ Should show summary page

#### 6. Final Submission
- Review all completed tasks
- Review all uploaded photos
- Click "Confirm & Submit"
- ✅ Checklist marked as completed

---

## Test Admin Features (Priority 2)

### Login as Admin
```
Email: admin@housekeeping.com
Password: password
```

### Test Admin Tasks
1. Go to Admin → Tasks
2. Click "Add New Task"
3. Create a default task (system-wide)
4. Create a custom task (property-specific)
5. Edit and delete tasks
6. ✅ Verify badges show correctly

### Test Admin Rooms
1. Go to Admin → Rooms
2. Click "Add New Room Template"
3. Create "Test Suite" room
4. Edit and delete room templates
5. ✅ Verify only default templates shown

---

## Test Owner Features (Priority 3)

### Login as Owner
```
Email: owner@housekeeping.com
Password: password
```

### Test Owner Tasks
1. Go to Owner → Tasks
2. ✅ See "Default Tasks" (read-only) section
3. ✅ See "My Custom Tasks" (editable) section
4. Click "Add New Custom Task"
5. Create task for your property
6. Edit and delete your custom tasks
7. ✅ Cannot edit default tasks

---

## Enforcement Tests

### Test 1: Cannot Skip Rooms
- Try to complete room with incomplete tasks
- ✅ Button should be disabled

### Test 2: Cannot Skip to Photos
- Try to upload photo in Step 1 (tasks)
- ✅ Should get 403 error or disabled

### Test 3: Cannot Skip Inventory
- Complete all rooms
- Try to skip to photos without inventory
- ✅ Should be on inventory step

### Test 4: Room-by-Room Lock
- In Step 1, only see current room
- ✅ Upcoming rooms shown but locked

---

## Quick Bug Check

- [ ] All pages load without errors
- [ ] Forms submit successfully
- [ ] Photos upload with timestamp
- [ ] Progress bars update correctly
- [ ] Buttons enable/disable properly
- [ ] Navigation works
- [ ] Authorization prevents unauthorized access

---

## Report Issues

If you find bugs, note:
1. What you were doing
2. Expected behavior
3. Actual behavior
4. Error messages

I'll fix them immediately!

---

## Documentation

- **Full Testing Guide:** `TESTING_NEW_FEATURES.md`
- **Workflow Details:** `MULTI_STEP_WORKFLOW_IMPLEMENTATION.md`
- **Requirements:** `REQUIREMENTS_CHECKLIST.md`

---

**Status:** ✅ All features implemented  
**Ready:** 🚀 Start testing now!
