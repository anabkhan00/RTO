<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasRoles, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'address',
        'latitude',
        'longitude',
        'course_id',
        'status',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rtoDetail()
    {
        return $this->hasOne(RtoDetail::class);
    }

    public function coordinatorDetail()
    {
        return $this->hasOne(CoordinatorDetail::class);
    }

    public function rtoDocuments()
    {
        return $this->hasMany(RtoDocument::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function studentDocuments()
    {
        return $this->hasMany(StudentDocument::class, 'student_id');
    }

    public function esignature()
    {
        return $this->hasOne(Esignature::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'rto_id');
    }

    public function studentDetail()
    {
        return $this->hasOne(StudentDetail::class);
    }

    // All RTOs assigned to this student
    public function rtos()
    {
        return $this->belongsToMany(User::class, 'rto_students', 'student_id', 'rto_id');
    }

    // Get the primary/first RTO
    public function primaryRto()
    {
        return $this->rtos()->first();
    }

    // Industries assigned to this student
    public function assignedIndustries()
    {
        return $this->belongsToMany(Industry::class, 'student_industries', 'student_id', 'industry_id');
    }

    public function weeklySchedules()
    {
        return $this->hasMany(StudentWeeklySchedule::class, 'student_id');
    }

    // RTOs assigned to this coordinator (for placement coordinators)
    public function assignedRtos()
    {
        return $this->belongsToMany(User::class, 'coordinator_rto', 'coordinator_id', 'rto_id');
    }

    // Coordinators assigned to this RTO (inverse relationship)
    public function coordinatorAssignments()
    {
        return $this->belongsToMany(User::class, 'coordinator_rto', 'rto_id', 'coordinator_id');
    }

    public function assignmentRequests()
    {
        return $this->hasMany(StudentAssignmentRequest::class, 'student_id');
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class, 'student_id');
    }

    public function getProfileImageUrlAttribute(): ?string
    {
        if (!$this->profile_image) {
            return null;
        }

        return asset('storage/' . ltrim($this->profile_image, '/'));
    }
}
