# Testing Guide for New Features

**Testing Date:** October 18, 2025
**Server URL:** http://127.0.0.1:8000
**Status:** All bugs fixed, ready for comprehensive testing

---

## Test Credentials

```
Admin:
Email: admin@housekeeping.com
Password: password

Owner:
Email: owner@housekeeping.com
Password: password

Housekeeper:
Email: housekeeper@housekeeping.com
Password: password
```

---

## 1. Admin Task Management Tests

**URL:** http://127.0.0.1:8000/admin/tasks

### Test 1.1: View Task List
- [ ] Login as admin@housekeeping.com
- [ ] Navigate to Admin → Tasks
- [ ] Verify task list displays with columns: Name, Description, Room Type, Type (Default/Custom), Property, Room, Actions
- [ ] Check that default tasks show blue "Default" badge
- [ ] Check that custom tasks show green "Custom" badge
- [ ] Verify property and room names display correctly

### Test 1.2: Create Default Task
- [ ] Click "Add New Task" button
- [ ] Select "Default (System-wide)" radio button
- [ ] Enter name: "Test Default Task"
- [ ] Enter description: "This is a default task"
- [ ] Select room type: "Bedroom"
- [ ] Verify property/room selectors are disabled
- [ ] Click "Create Task"
- [ ] Verify success message
- [ ] Verify task appears in list with "Default" badge
- [ ] Verify property and room columns are empty

### Test 1.3: Create Custom Task
- [ ] Click "Add New Task"
- [ ] Select "Custom (Property-specific)" radio button
- [ ] Enter name: "Test Custom Task"
- [ ] Enter description: "This is a custom task"
- [ ] Select room type: "Kitchen"
- [ ] Select a property from dropdown
- [ ] Select a room from dropdown
- [ ] Click "Create Task"
- [ ] Verify success message
- [ ] Verify task appears with "Custom" badge
- [ ] Verify property and room names display

### Test 1.4: Edit Task
- [ ] Click "Edit" button on any task
- [ ] Modify the name
- [ ] Modify the description
- [ ] Click "Update Task"
- [ ] Verify success message
- [ ] Verify changes appear in list

### Test 1.5: Delete Task Protection
- [ ] Try to delete a task that's used in checklist items
- [ ] Verify error message appears
- [ ] Verify task is NOT deleted

### Test 1.6: Delete Unused Task
- [ ] Delete the test tasks created above (if not in use)
- [ ] Verify confirmation prompt
- [ ] Verify success message
- [ ] Verify task removed from list

---

## 2. Admin Room Template Tests

**URL:** http://127.0.0.1:8000/admin/rooms

### Test 2.1: View Room Templates
- [ ] Navigate to Admin → Rooms
- [ ] Verify only default room templates display
- [ ] Verify card layout with room name and action buttons
- [ ] Check that property-specific rooms do NOT appear

### Test 2.2: Create Default Room Template
- [ ] Click "Add New Room Template"
- [ ] Enter name: "Executive Suite"
- [ ] Enter description: "Luxury executive suite with workspace"
- [ ] Click "Create Room Template"
- [ ] Verify success message
- [ ] Verify new template appears in list
- [ ] Verify it's available system-wide (property_id = null, is_default = true)

### Test 2.3: Edit Room Template
- [ ] Click "Edit" on "Executive Suite"
- [ ] Change description
- [ ] Click "Update Room Template"
- [ ] Verify success message
- [ ] Verify changes appear

### Test 2.4: Delete Protection Test
- [ ] Try to delete a room template that's used in checklists
- [ ] Verify error message about rooms in use
- [ ] Verify room is NOT deleted

### Test 2.5: Delete Unused Template
- [ ] Delete "Executive Suite" (if not in use)
- [ ] Verify confirmation
- [ ] Verify success message
- [ ] Verify template removed

---

## 3. Owner Task Management Tests

**URL:** http://127.0.0.1:8000/owner/tasks

### Test 3.1: View Tasks (Owner Perspective)
- [ ] Logout and login as owner@housekeeping.com
- [ ] Navigate to Owner → Tasks
- [ ] Verify two sections appear:
  - "Default Tasks (System-wide)" - read-only list
  - "My Custom Tasks" - editable list
- [ ] Verify default tasks show with disabled Edit/Delete buttons
- [ ] Verify custom tasks show with enabled Edit/Delete buttons

### Test 3.2: Create Custom Task (Owner)
- [ ] Click "Add New Custom Task"
- [ ] Enter name: "Owner Custom Task"
- [ ] Enter description: "Task for my property"
- [ ] Select room type: "Living Room"
- [ ] Select YOUR property from dropdown
- [ ] Select a room from dropdown
- [ ] Click "Create Task"
- [ ] Verify success message
- [ ] Verify task appears in "My Custom Tasks" section

### Test 3.3: Edit Custom Task (Owner)
- [ ] Click "Edit" on your custom task
- [ ] Modify name and description
- [ ] Click "Update Task"
- [ ] Verify success message
- [ ] Verify changes appear

### Test 3.4: Authorization Test - Edit Default Task
- [ ] Try to manually access: http://127.0.0.1:8000/owner/tasks/{default_task_id}/edit
- [ ] Verify you're redirected or get error
- [ ] Confirm default tasks cannot be edited by owners

### Test 3.5: Authorization Test - Other Owner's Tasks
- [ ] Try to access another owner's task (if available)
- [ ] Verify 403 Forbidden or redirect
- [ ] Confirm property isolation works

### Test 3.6: Delete Custom Task (Owner)
- [ ] Delete your custom task (if not in use)
- [ ] Verify confirmation
- [ ] Verify success message
- [ ] Verify task removed from list

---

## 4. Summary Review Page Tests

**URL:** http://127.0.0.1:8000/housekeeper/checklist/{id}/summary

### Test 4.1: Access Summary Page
- [ ] Logout and login as housekeeper@housekeeping.com
- [ ] Navigate to an active checklist
- [ ] Complete all required tasks (mark checkboxes)
- [ ] Upload photos for each room
- [ ] Click "Review & Submit Checklist" button
- [ ] Verify redirect to summary page

### Test 4.2: Review Summary Content
- [ ] Verify page shows checklist details at top
- [ ] Verify "Completed Tasks" section groups items by room
- [ ] Verify each room shows:
  - Room name
  - All completed tasks
  - Task completion status (✓)
- [ ] Verify "Photos Uploaded" section groups photos by room
- [ ] Verify photo counts display correctly
- [ ] Verify red warning if photos < required

### Test 4.3: Go Back and Edit
- [ ] Click "Go Back & Make Changes" button
- [ ] Verify redirect to checklist page
- [ ] Verify you can make changes
- [ ] Return to summary page
- [ ] Verify changes are reflected

### Test 4.4: Confirm and Submit
- [ ] Click "Confirm & Submit" button
- [ ] Verify checklist is marked as completed
- [ ] Verify redirect to completed checklist view
- [ ] Verify timestamp is recorded
- [ ] Verify checklist appears in history

---

## 5. Integration Tests

### Test 5.1: Default Task Propagation
- [ ] Login as admin
- [ ] Create a new default task
- [ ] Login as owner
- [ ] Go to Tasks page
- [ ] Verify new default task appears in "Default Tasks" section

### Test 5.2: Default Room Propagation
- [ ] Login as admin
- [ ] Create a new room template "Test Suite"
- [ ] Login as owner
- [ ] Create a new property
- [ ] When adding rooms, verify "Test Suite" is available
- [ ] Create room based on template
- [ ] Verify room inherits template properties

### Test 5.3: Custom Task Visibility
- [ ] Login as owner
- [ ] Create a custom task for your property
- [ ] Login as admin
- [ ] Go to Admin → Tasks
- [ ] Verify owner's custom task appears in list
- [ ] Verify you can edit/delete it

### Test 5.4: Task Assignment in Checklist
- [ ] Login as owner
- [ ] Create a checklist with both default and custom tasks
- [ ] Login as housekeeper
- [ ] Open checklist
- [ ] Verify both default and custom tasks appear
- [ ] Complete checklist
- [ ] Verify summary page shows both types

---

## 6. Edge Cases & Error Handling

### Test 6.1: Validation Tests
- [ ] Try creating task with empty name → should show error
- [ ] Try creating task without room type → should show error
- [ ] Try creating custom task without property → should show error
- [ ] Try creating room template with empty name → should show error

### Test 6.2: Unauthorized Access Tests
- [ ] Login as owner
- [ ] Try to access: http://127.0.0.1:8000/admin/tasks → should redirect
- [ ] Try to access: http://127.0.0.1:8000/admin/rooms → should redirect
- [ ] Login as housekeeper
- [ ] Try to access: http://127.0.0.1:8000/owner/tasks → should redirect

### Test 6.3: Cascade Delete Tests
- [ ] Create a property with custom task
- [ ] Delete the property
- [ ] Verify custom task is deleted (ON DELETE CASCADE)
- [ ] Verify default tasks remain

### Test 6.4: Null Property/Room Handling
- [ ] Verify default tasks display properly with NULL property_id
- [ ] Verify admin can create tasks without property selection
- [ ] Verify owner must select property (validation)

---

## 7. UI/UX Tests

### Test 7.1: Navigation
- [ ] Verify all menu items work correctly
- [ ] Verify breadcrumbs display on all pages
- [ ] Verify back buttons work

### Test 7.2: Responsive Design
- [ ] Resize browser window
- [ ] Verify layouts adapt to smaller screens
- [ ] Test on mobile view (F12 → device emulation)

### Test 7.3: Visual Feedback
- [ ] Verify success messages appear after create/update/delete
- [ ] Verify error messages are clear and helpful
- [ ] Verify loading states (if any)

### Test 7.4: Form Behavior
- [ ] Verify default/custom radio buttons toggle property/room selectors
- [ ] Verify dropdowns populate correctly
- [ ] Verify form validation shows inline errors

---

## 8. Database Integrity Tests

### Test 8.1: Verify Migrations
```sql
-- Run these in phpMyAdmin or MySQL console:

-- Check rooms table has is_default field
DESC rooms;

-- Check tasks table has property_id and room_id
DESC tasks;

-- Verify foreign keys exist
SHOW CREATE TABLE tasks;

-- Check default rooms
SELECT * FROM rooms WHERE is_default = 1 AND property_id IS NULL;

-- Check default tasks
SELECT * FROM tasks WHERE is_default = 1 AND property_id IS NULL;
```

### Test 8.2: Verify Relationships
- [ ] Create task with property
- [ ] Query: `SELECT * FROM tasks WHERE property_id IS NOT NULL`
- [ ] Verify property_id matches existing property
- [ ] Verify foreign key constraint works

---

## Testing Results Summary

### Admin Task Management
- [ ] All tests passed
- [ ] Issues found: ___________

### Admin Room Templates
- [ ] All tests passed
- [ ] Issues found: ___________

### Owner Task Management
- [ ] All tests passed
- [ ] Issues found: ___________

### Summary Review Page
- [ ] All tests passed
- [ ] Issues found: ___________

### Integration Tests
- [ ] All tests passed
- [ ] Issues found: ___________

### Edge Cases
- [ ] All tests passed
- [ ] Issues found: ___________

---

## Known Issues to Fix

1. [ ] Issue: ___________
   - Severity: High/Medium/Low
   - Steps to reproduce: ___________
   - Expected: ___________
   - Actual: ___________

2. [ ] Issue: ___________
   - Severity: High/Medium/Low
   - Steps to reproduce: ___________
   - Expected: ___________
   - Actual: ___________

---

## Next Steps After Testing

1. [ ] Fix all critical bugs found
2. [ ] Take screenshots for contest submission
3. [ ] Deploy to live server
4. [ ] Submit to freelancer.com contest

---

**Server Status:** ✅ Running on http://127.0.0.1:8000
**All Bugs Fixed:** ✅ Routes, relationships, database schema
**Ready for Testing:** ✅ All 5 new features implemented
