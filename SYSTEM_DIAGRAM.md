# 📊 SYSTEM DIAGRAM - ONE PAGE OVERVIEW

```
╔════════════════════════════════════════════════════════════════════════════╗
║                                                                            ║
║         LARAVEL HOUSEKEEPING MANAGEMENT SYSTEM                             ║
║         Complete Accountability & Photo Verification                       ║
║                                                                            ║
╚════════════════════════════════════════════════════════════════════════════╝


┌──────────────────────────────────────────────────────────────────────────┐
│                           SYSTEM USERS                                    │
└──────────────────────────────────────────────────────────────────────────┘

        👤 ADMIN                 👤 OWNER              👤 HOUSEKEEPER
        ┌──────────┐            ┌──────────┐          ┌──────────┐
        │• Manage  │            │• Create  │          │• View    │
        │  Users   │            │  Property│          │  Tasks   │
        │• Create  │            │• Add     │          │• Complete│
        │  Template│            │  Rooms   │          │  Work    │
        │• View    │            │• Assign  │          │• Upload  │
        │  All     │            │  Tasks   │          │  Photos  │
        └────┬─────┘            │• Schedule│          └────┬─────┘
             │                  └────┬─────┘               │
             └──────────────────────┼─────────────────────┘
                                    │
                                    ▼
        ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
        ┃           LARAVEL APPLICATION SERVER              ┃
        ┃  ─────────────────────────────────────────────── ┃
        ┃  • Authentication & Authorization                 ┃
        ┃  • Business Logic                                 ┃
        ┃  • GPS Verification                               ┃
        ┃  • Photo Processing                               ┃
        ┃  • Workflow Management                            ┃
        ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
                                    │
                    ┌───────────────┼───────────────┐
                    │               │               │
                    ▼               ▼               ▼
            ┌──────────┐    ┌──────────┐    ┌──────────┐
            │ DATABASE │    │  STORAGE │    │   LOGS   │
            │  (MySQL) │    │  (Photos)│    │ (Activity)│
            └──────────┘    └──────────┘    └──────────┘


┌──────────────────────────────────────────────────────────────────────────┐
│                        WORKFLOW PROCESS                                   │
└──────────────────────────────────────────────────────────────────────────┘

 PHASE 1: SETUP            PHASE 2: EXECUTION          PHASE 3: REVIEW
 ═══════════════           ════════════════════        ═══════════════

 Owner Creates              Housekeeper Arrives         Owner Reviews
 Property                   at Property                 Completed Work
      │                          │                           │
      ▼                          ▼                           ▼
 Add Rooms                  GPS Verified ✓              View Photos
      │                          │                           │
      ▼                          ▼                           ▼
 Assign Tasks               Complete Tasks              Check Tasks
      │                     (Room-by-Room)                   │
      ▼                          │                           ▼
 Schedule                        ▼                      Verify Quality
 Housekeeper                Check Inventory                  │
      │                          │                           ▼
      ▼                          ▼                      Property Ready ✓
 Create                     Upload Photos
 Assignment                 (8+ per room)
                                 │
                                 ▼
                            Submit for
                             Review


┌──────────────────────────────────────────────────────────────────────────┐
│                    3-STEP HOUSEKEEPER WORKFLOW                            │
└──────────────────────────────────────────────────────────────────────────┘

╔════════════════════════════════════════════════════════════════════════╗
║  STEP 1: TASKS                                                         ║
║  ────────────────────────────────────────────────────────────────────  ║
║                                                                        ║
║  🏠 BEDROOM                   [✓] Make bed                            ║
║     (Current Room)            [✓] Clean floor                         ║
║                               [✓] Dust furniture                      ║
║     Progress: 3/3 (100%)                                              ║
║     [Complete Room & Continue to Kitchen] ──────────────────┐         ║
║                                                              │         ║
║  🏠 KITCHEN (Locked 🔒)                                      │         ║
║     Will unlock after Bedroom complete                       │         ║
║                                                              │         ║
║  🏠 BATHROOM (Locked 🔒)                                     │         ║
║     Will unlock after Kitchen complete                       │         ║
║                                                              │         ║
╚══════════════════════════════════════════════════════════════┼═════════╝
                                                               │
                All Rooms Complete                             │
                       ↓                                       │
╔══════════════════════════════════════════════════════════════┼═════════╗
║  STEP 2: INVENTORY                                           │         ║
║  ────────────────────────────────────────────────────────────┼───────  ║
║                                                              │         ║
║  [✓] Towels .............. Qty: 8 ..... Available           │         ║
║  [✓] Bed Sheets .......... Qty: 4 ..... Available           │         ║
║  [✓] Toilet Paper ........ Qty: 12 .... Available           │         ║
║  [✓] Hand Soap ........... Qty: 4 ..... Available          │         ║
║  [✓] ... (8 more items)                                      │         ║
║                                                              │         ║
║  Progress: 12/12 (100%)                                      │         ║
║  [Complete Inventory & Continue to Photos] ───────────────┐  │         ║
║                                                            │  │         ║
╚════════════════════════════════════════════════════════════┼══┼═════════╝
                                                             │  │
                All Inventory Checked                        │  │
                       ↓                                     │  │
╔════════════════════════════════════════════════════════════┼══┼═════════╗
║  STEP 3: PHOTOS                                            │  │         ║
║  ────────────────────────────────────────────────────────────┼───────  ║
║                                                            │  │         ║
║  📸 Bedroom ........ 8/8 photos ✓ [9:15-9:22 AM]          │  │         ║
║  📸 Kitchen ........ 8/8 photos ✓ [9:25-9:32 AM]          │  │         ║
║  📸 Bathroom ....... 8/8 photos ✓ [9:35-9:42 AM]          │  │         ║
║                                                            │  │         ║
║  Total: 24 photos uploaded with timestamps                 │  │         ║
║  GPS coordinates recorded for all photos                   │  │         ║
║                                                            │  │         ║
║  [Review Summary & Submit] ────────────────────┐           │  │         ║
║                                                 │           │  │         ║
╚═════════════════════════════════════════════════┼═══════════┼══┼═════════╝
                                                  │           │  │
                                                  ▼           │  │
                                          ┌──────────────┐    │  │
                                          │   SUMMARY    │    │  │
                                          │              │    │  │
                                          │ ✓ Tasks: 9/9 │    │  │
                                          │ ✓ Inventory  │    │  │
                                          │ ✓ Photos: 24 │    │  │
                                          │              │    │  │
                                          │ [Submit] ────┼────┘  │
                                          └──────────────┘       │
                                                                 │
                                                                 ▼
                                                         [COMPLETED ✓]


┌──────────────────────────────────────────────────────────────────────────┐
│                         GPS VERIFICATION                                  │
└──────────────────────────────────────────────────────────────────────────┘

    Housekeeper Arrives              System Checks              Decision
         at Property                    Location
              │                             │                       │
              │                             │                       │
              ▼                             ▼                       ▼
    ┌──────────────────┐         ┌──────────────────┐    ┌──────────────────┐
    │  Click "Start"   │────────>│  Get GPS         │───>│  Within 100m?    │
    │   Checklist      │         │  Coordinates     │    │                  │
    └──────────────────┘         └──────────────────┘    └─────────┬────────┘
                                                                    │
                                                     ┌──────────────┴───────────┐
                                                     │                          │
                                                  YES ✓                       NO ✗
                                                     │                          │
                                                     ▼                          ▼
                                          ┌──────────────────┐      ┌──────────────────┐
                                          │  Allow Access    │      │  Block Access    │
                                          │  Record GPS      │      │  Show Error      │
                                          │  Start Workflow  │      │  "Not at site"   │
                                          └──────────────────┘      └──────────────────┘


┌──────────────────────────────────────────────────────────────────────────┐
│                      DATABASE STRUCTURE                                   │
└──────────────────────────────────────────────────────────────────────────┘

    ┌──────────┐        ┌──────────┐        ┌──────────┐        ┌──────────┐
    │  USERS   │───────>│PROPERTIES│───────>│  ROOMS   │<───────│  TASKS   │
    └──────────┘        └──────────┘        └──────────┘        └──────────┘
         │                    │                    │                    │
         │                    │                    └────────────────────┘
         │                    │                           │
         │                    │                      ┌─────────┐
         │                    │                      │ROOM_TASK│
         │                    │                      │ (Pivot) │
         │                    │                      └─────────┘
         │                    │                           │
         ▼                    ▼                           ▼
    ┌──────────┐        ┌──────────────────────────────────┐
    │CHECKLISTS│───────>│      CHECKLIST_ITEMS             │
    └──────────┘        │  (Task completion records)       │
         │              └──────────────────────────────────┘
         │
         ├─────────────────┬──────────────────┬────────────────┐
         │                 │                  │                │
         ▼                 ▼                  ▼                ▼
    ┌──────────┐     ┌──────────┐     ┌──────────┐    ┌──────────┐
    │  PHOTOS  │     │INVENTORY │     │   GPS    │    │   LOGS   │
    │ (Storage)│     │  ITEMS   │     │   DATA   │    │(Tracking)│
    └──────────┘     └──────────┘     └──────────┘    └──────────┘


┌──────────────────────────────────────────────────────────────────────────┐
│                       CALENDAR VIEW                                       │
└──────────────────────────────────────────────────────────────────────────┘

    OWNER/ADMIN VIEW                      HOUSEKEEPER VIEW
    ════════════════════                  ════════════════════

    October 2025                          My Schedule - October 2025
    ┌───────────────────────┐             ┌───────────────────────┐
    │ Mon Tue Wed Thu Fri   │             │ Mon Tue Wed Thu Fri   │
    ├───────────────────────┤             ├───────────────────────┤
    │  1   2   3   4   5    │             │  1   2   3   4   5    │
    │     🟥      🟩        │             │     🟥      🟩        │
    │                       │             │     ↑       ↑         │
    │  8   9  10  11  12    │             │  Assigned  Complete   │
    │ 🟧  🟩      🟥  🟩   │             │                       │
    │                       │             │  8   9  10  11  12    │
    │ 15  16  17  18  19    │             │      🟩              │
    │     🟩  🟧  🟩  🟥   │             │                       │
    └───────────────────────┘             └───────────────────────┘
                                          (Only their assignments)
    🟥 Pending (Not Started)
    🟧 In Progress (Active)
    🟩 Completed (Finished)


┌──────────────────────────────────────────────────────────────────────────┐
│                      SECURITY & ACCESS CONTROL                            │
└──────────────────────────────────────────────────────────────────────────┘

    ┌─────────────────────────────────────────────────────────────────┐
    │  AUTHENTICATION LAYER                                           │
    │  • Email/Password (Encrypted)                                   │
    │  • Session Management                                           │
    └────────────────────────────┬────────────────────────────────────┘
                                 │
                                 ▼
    ┌─────────────────────────────────────────────────────────────────┐
    │  AUTHORIZATION LAYER                                            │
    │  • Role-Based Access Control (RBAC)                             │
    │  • Admin: Full access                                           │
    │  • Owner: Own properties only                                   │
    │  • Housekeeper: Assigned checklists only                        │
    └────────────────────────────┬────────────────────────────────────┘
                                 │
                                 ▼
    ┌─────────────────────────────────────────────────────────────────┐
    │  POLICY LAYER                                                   │
    │  • ChecklistPolicy (ownership verification)                     │
    │  • PropertyPolicy (access control)                              │
    │  • TaskPolicy (modification rights)                             │
    └────────────────────────────┬────────────────────────────────────┘
                                 │
                                 ▼
    ┌─────────────────────────────────────────────────────────────────┐
    │  VALIDATION LAYER                                               │
    │  • Input sanitization                                           │
    │  • SQL injection prevention                                     │
    │  • XSS protection                                               │
    └─────────────────────────────────────────────────────────────────┘


┌──────────────────────────────────────────────────────────────────────────┐
│                      WHAT MAKES THIS UNIQUE                               │
└──────────────────────────────────────────────────────────────────────────┘

    ✓ GPS ENFORCEMENT              ✓ STEP-BY-STEP WORKFLOW
      Cannot start without         Cannot skip rooms or steps
      being at property            Sequential progression

    ✓ PHOTO VERIFICATION           ✓ INVENTORY TRACKING
      8+ photos per room           12 common Airbnb items
      Timestamped                  Quantity & availability

    ✓ COMPLETE AUDIT TRAIL         ✓ MOBILE FRIENDLY
      Every action logged          Works on phones
      GPS + Timestamps             Touch-optimized

    ✓ ROLE-BASED ACCESS            ✓ CALENDAR SCHEDULING
      3 distinct user types        Visual timeline
      Secure separation            Color-coded status


═══════════════════════════════════════════════════════════════════════════

                        SYSTEM STATUS: ✅ READY

            Complete | Tested | Professional | Production-Ready

═══════════════════════════════════════════════════════════════════════════
```

**End of One-Page System Diagram**
