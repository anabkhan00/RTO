# Student Placement Hours + Weekly Calendar Scheduling Module

## Overview
Complete implementation of weekly scheduling system for student placement hours management. Students have varying weekly availability, and this system allows admins to schedule hours week-by-week until total placement hours are completed.

## Database Schema

### 1. Users Table (Modified)
Added columns:
- `emergency_contact` (string, nullable) - Emergency contact number
- `placement_hours` (integer, nullable) - Total hours student must complete (varies per student: 80, 100, 120, etc.)

### 2. Student Weekly Schedules Table (New)
Table: `student_weekly_schedules`

Columns:
- `id` - Primary key
- `student_id` - Foreign key to users table
- `week_start_date` - Start date of the week
- `week_end_date` - End date of the week
- `hours_assigned` - Hours assigned for this week
- `notes` - Optional notes for the week
- `created_at` - Timestamp
- `updated_at` - Timestamp

## Models

### StudentWeeklySchedule Model
**Location**: `app/Models/StudentWeeklySchedule.php`

**Fillable Fields**:
- student_id
- week_start_date
- week_end_date
- hours_assigned
- notes

**Relationships**:
- `student()` - belongsTo User model

**Casts**:
- week_start_date: date
- week_end_date: date

### User Model (Updated)
**Location**: `app/Models/User.php`

**Added to Fillable**:
- emergency_contact
- placement_hours

**New Relationship**:
- `weeklySchedules()` - hasMany StudentWeeklySchedule

## Controllers

### WeeklyScheduleController
**Location**: `app/Http/Controllers/Admin/WeeklyScheduleController.php`

**Methods**:

1. **index($studentId)**
   - Shows the weekly schedule page for a student
   - Returns view with student data

2. **getSchedules($studentId)**
   - Returns JSON with all schedules for a student
   - Calculates total assigned hours
   - Calculates remaining hours
   - Returns: schedules, total_assigned, placement_hours, remaining_hours

3. **store(Request $request)**
   - Creates new weekly schedule
   - Validates: student_id, week_start_date, week_end_date, hours_assigned, notes
   - Returns success JSON response

4. **update(Request $request, $id)**
   - Updates existing weekly schedule
   - Validates same fields as store
   - Returns success JSON response

5. **destroy($id)**
   - Deletes a weekly schedule
   - Returns success JSON response

## Routes

**Prefix**: `/admin/weekly-schedules`

```php
GET    /admin/weekly-schedules/{studentId}              - Show calendar page
GET    /admin/weekly-schedules/{studentId}/schedules   - Get all schedules (API)
POST   /admin/weekly-schedules                         - Create schedule
PUT    /admin/weekly-schedules/{id}                    - Update schedule
DELETE /admin/weekly-schedules/{id}                    - Delete schedule
```

## Views

### Weekly Schedule Page
**Location**: `resources/views/admin/pages/weekly_schedule.blade.php`

**Features**:
- Student info card showing:
  - Total Placement Hours (gold)
  - Hours Assigned (blue)
  - Remaining Hours (green)
  - Emergency Contact
- Add Weekly Schedule button
- List of all weekly schedules with:
  - Week date range
  - Hours assigned
  - Notes
  - Edit/Delete buttons
- Modal for adding/editing schedules

**UI Components**:
- Clean card-based layout
- Gold branding (#d4af37)
- Responsive design
- Real-time calculations
- AJAX operations

## Workflow

### 1. Student Profile Setup
- Admin adds/edits student
- Sets emergency_contact and placement_hours fields
- These fields are now part of student profile

### 2. Access Weekly Schedule
- From students list, click calendar icon next to student
- Opens weekly schedule page for that student

### 3. Add Weekly Schedule
- Click "Add Weekly Schedule" button
- Fill in:
  - Week Start Date
  - Week End Date
  - Hours Assigned (e.g., 20 hours)
  - Notes (optional)
- Submit to save

### 4. Track Progress
- Dashboard shows:
  - Total placement hours required
  - Hours already assigned across all weeks
  - Remaining hours to be scheduled
- Add more weeks until total hours are covered

### 5. Edit/Delete Schedules
- Each schedule entry has edit and delete buttons
- Edit opens modal with pre-filled data
- Delete removes the schedule and recalculates totals

## Key Features

### Flexible Scheduling
- Week-by-week scheduling (not daily)
- Variable hours per week (10, 20, 30 hours, etc.)
- Custom date ranges for each week
- Optional notes for each week

### Real-Time Calculations
- Automatically calculates total assigned hours
- Shows remaining hours to be scheduled
- Updates instantly when schedules are added/edited/deleted

### Validation
- Week end date must be after or equal to start date
- Hours must be positive integer
- Student must exist
- All required fields validated

### User Experience
- Clean, intuitive interface
- Modal-based add/edit forms
- Confirmation before delete
- Success/error notifications via toastr
- Responsive design

## Integration Points

### Students DataTable
- Added calendar icon in actions column
- Links directly to weekly schedule page
- Icon: `bi-calendar-week` (Bootstrap Icons)

### Student Update Form
- Emergency contact field added
- Placement hours field added
- Both fields saved to database

## Technical Implementation

### AJAX Operations
All CRUD operations use fetch API:
- GET schedules - loads on page load
- POST new schedule - adds without page reload
- PUT update schedule - updates without page reload
- DELETE schedule - removes without page reload

### JSON Responses
All API endpoints return consistent JSON:
```json
{
  "success": true,
  "message": "Operation successful",
  "schedules": [...],
  "total_assigned": 60,
  "placement_hours": 120,
  "remaining_hours": 60
}
```

### Error Handling
- Try-catch blocks in JavaScript
- Validation in controller
- User-friendly error messages
- Console logging for debugging

## Files Created/Modified

### New Files:
1. `database/migrations/2025_12_09_075558_add_emergency_contact_and_placement_hours_to_students_table.php`
2. `database/migrations/2025_12_09_075611_create_student_weekly_schedules_table.php`
3. `app/Models/StudentWeeklySchedule.php`
4. `app/Http/Controllers/Admin/WeeklyScheduleController.php`
5. `resources/views/admin/pages/weekly_schedule.blade.php`

### Modified Files:
1. `app/Models/User.php` - Added fillable fields and relationship
2. `routes/web.php` - Added weekly schedule routes
3. `app/Http/Controllers/Admin/StudentController.php` - Added calendar icon to DataTable

## Testing Checklist

- [ ] Emergency contact field saves correctly
- [ ] Placement hours field saves correctly
- [ ] Calendar icon appears in students list
- [ ] Calendar page loads with correct student data
- [ ] Can add new weekly schedule
- [ ] Can edit existing schedule
- [ ] Can delete schedule
- [ ] Total hours calculate correctly
- [ ] Remaining hours calculate correctly
- [ ] Validation works (dates, hours)
- [ ] Modal opens/closes properly
- [ ] Success/error messages display
- [ ] Responsive design works on mobile

## Future Enhancements

Potential additions:
- Visual calendar grid view
- Color coding for weeks (completed, upcoming, overdue)
- Export schedule to PDF
- Email notifications for upcoming weeks
- Bulk schedule creation
- Schedule templates
- Conflict detection (overlapping weeks)
- Progress percentage visualization
- Student-facing view of their schedule

## Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify database migrations ran successfully
4. Ensure all routes are registered
5. Clear cache: `php artisan optimize:clear`
