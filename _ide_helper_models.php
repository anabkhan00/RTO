<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $rto_id
 * @property string $title
 * @property string $file_path
 * @property string $original_name
 * @property int $file_size
 * @property bool $is_signed
 * @property \Illuminate\Support\Carbon|null $signed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $rto
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereIsSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereRtoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereUpdatedAt($value)
 */
	class Contract extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CoordinatorDetail whereUserId($value)
 */
	class CoordinatorDetail extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $credit_hours
 * @property string|null $description
 * @property bool $status
 * @property int|null $placement_hours
 * @property int $no_of_students
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\CourseChecklist|null $courseChecklist
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreditHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereNoOfStudents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course wherePlacementHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereUpdatedAt($value)
 */
	class Course extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $course_id
 * @property array<array-key, mixed> $checklist_ids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist whereChecklistIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseChecklist whereUpdatedAt($value)
 */
	class CourseChecklist extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentDocument> $studentDocuments
 * @property-read int|null $student_documents_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentChecklist whereUpdatedAt($value)
 */
	class DocumentChecklist extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $signature_path
 * @property string $signature_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature whereSignaturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature whereSignatureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Esignature whereUserId($value)
 */
	class Esignature extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $contact_person
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $website
 * @property bool $status
 * @property string $industry_status
 * @property array<array-key, mixed>|null $course_ids
 * @property array<array-key, mixed>|null $checklist_ids
 * @property array<array-key, mixed>|null $availability
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndustryCourseChecklist> $courseChecklists
 * @property-read int|null $course_checklists_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $courses
 * @property-read int|null $courses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndustryWeeklySchedule> $weeklySchedules
 * @property-read int|null $weekly_schedules_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereChecklistIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereCourseIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereIndustryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Industry whereWebsite($value)
 */
	class Industry extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $industry_id
 * @property int $course_id
 * @property array<array-key, mixed> $checklist_ids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Industry $industry
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist whereChecklistIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryCourseChecklist whereUpdatedAt($value)
 */
	class IndustryCourseChecklist extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $industry_id
 * @property \Illuminate\Support\Carbon $week_start_date
 * @property \Illuminate\Support\Carbon $week_end_date
 * @property array<array-key, mixed>|null $selected_time_slots
 * @property numeric $total_hours
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Industry $industry
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereSelectedTimeSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereTotalHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereWeekEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndustryWeeklySchedule whereWeekStartDate($value)
 */
	class IndustryWeeklySchedule extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $placement_opportunity_id
 * @property int $student_id
 * @property int $placement_coordinator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\PlacementOpportunity $opportunity
 * @property-read \App\Models\User $placementCoordinator
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment wherePlacementCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment wherePlacementOpportunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementAssignment whereUpdatedAt($value)
 */
	class PlacementAssignment extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $industry_id
 * @property int $sourcing_coordinator_id
 * @property int $total_slots
 * @property int $filled_slots
 * @property string|null $requirements
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlacementAssignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read int $available_slots
 * @property-read \App\Models\Industry $industry
 * @property-read \App\Models\User $sourcingCoordinator
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereFilledSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereSourcingCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereTotalSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementOpportunity whereUpdatedAt($value)
 */
	class PlacementOpportunity extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $rto_number
 * @property string|null $code
 * @property string|null $website
 * @property string|null $contact_person
 * @property string|null $notes
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereRtoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDetail whereWebsite($value)
 */
	class RtoDetail extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $label
 * @property string $file_name
 * @property string $file_path
 * @property string $file_type
 * @property int $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoDocument whereUserId($value)
 */
	class RtoDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $rto_id
 * @property string $label
 * @property string $file_path
 * @property string $original_name
 * @property int $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $rto
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereRtoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoPersonalDocument whereUpdatedAt($value)
 */
	class RtoPersonalDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $rto_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $rto
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent whereRtoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RtoStudent whereUpdatedAt($value)
 */
	class RtoStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $coordinator_id
 * @property string $keyword
 * @property string $industry_name
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $coordinator
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereIndustryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedIndustryKeyword whereUpdatedAt($value)
 */
	class SavedIndustryKeyword extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property string $title
 * @property string $date
 * @property string $time
 * @property string|null $notes
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAppointment whereUpdatedAt($value)
 */
	class StudentAppointment extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $placement_coordinator_id
 * @property int $sourcing_coordinator_id
 * @property string|null $industry_preference
 * @property string|null $special_requirements
 * @property string $status
 * @property string|null $progress_notes
 * @property \Illuminate\Support\Carbon $assigned_at
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $placementCoordinator
 * @property-read \App\Models\User $sourcingCoordinator
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest completed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest forSourcingCoordinator($coordinatorId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest inProgress()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereIndustryPreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest wherePlacementCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereProgressNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereSourcingCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereSpecialRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignmentRequest whereUpdatedAt($value)
 */
	class StudentAssignmentRequest extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $industry_id
 * @property string|null $priority
 * @property string|null $progress_status
 * @property int|null $days_left
 * @property \Illuminate\Support\Carbon|null $placement_booked_at
 * @property string|null $emergency_contact
 * @property int|null $placement_hours
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $student_status
 * @property array<array-key, mixed>|null $student_availability
 * @property int|null $assigned_coordinator_id
 * @property int|null $placement_coordinator_id
 * @property int|null $sourcing_coordinator_id
 * @property string|null $medical_condition
 * @property string|null $transport
 * @property string|null $placement_data
 * @property string|null $gender
 * @property-read \App\Models\User|null $assignedCoordinator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Industry|null $industry
 * @property-read \App\Models\User|null $placementCoordinator
 * @property-read \App\Models\User|null $sourcingCoordinator
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereAssignedCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereDaysLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereMedicalCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail wherePlacementBookedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail wherePlacementCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail wherePlacementData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail wherePlacementHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereProgressStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereSourcingCoordinatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereStudentAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereStudentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereTransport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDetail whereUserId($value)
 */
	class StudentDetail extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $uploaded_by
 * @property string $label
 * @property string $file_path
 * @property string $original_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $checklist_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User $uploader
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereChecklistIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentDocument whereUploadedBy($value)
 */
	class StudentDocument extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Industry|null $industry
 * @property-read \App\Models\User|null $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentIndustry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentIndustry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentIndustry query()
 */
	class StudentIndustry extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $author_id
 * @property string $content
 * @property string $author_role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereAuthorRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentNote whereUpdatedAt($value)
 */
	class StudentNote extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon $week_start_date
 * @property \Illuminate\Support\Carbon $week_end_date
 * @property int $hours_assigned
 * @property numeric $total_hours
 * @property array<array-key, mixed>|null $selected_time_slots
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereHoursAssigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereSelectedTimeSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereTotalHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereWeekEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentWeeklySchedule whereWeekStartDate($value)
 */
	class StudentWeeklySchedule extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $role
 * @property string|null $address
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property int|null $course_id
 * @property string|null $profile_image
 * @property int $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Industry> $assignedIndustries
 * @property-read int|null $assigned_industries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $assignedRtos
 * @property-read int|null $assigned_rtos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentAssignmentRequest> $assignmentRequests
 * @property-read int|null $assignment_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $coordinatorAssignments
 * @property-read int|null $coordinator_assignments_count
 * @property-read \App\Models\CoordinatorDetail|null $coordinatorDetail
 * @property-read \App\Models\Course|null $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentDocument> $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\Esignature|null $esignature
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\RtoDetail|null $rtoDetail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RtoDocument> $rtoDocuments
 * @property-read int|null $rto_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $rtos
 * @property-read int|null $rtos_count
 * @property-read \App\Models\StudentDetail|null $studentDetail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentDocument> $studentDocuments
 * @property-read int|null $student_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentWeeklySchedule> $weeklySchedules
 * @property-read int|null $weekly_schedules_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

