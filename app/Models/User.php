<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'emergency_contact',
        'placement_hours',
        'student_status',
        'student_availability',
        'assigned_coordinator_id',
        'password',
        'role',
        'address',
        'rto_number',
        'code',
        'website',
        'contact_person',
        'status',
        'course_id',
        'profile_image',
        'coordinator_type'
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
            'student_availability' => 'array',
        ];
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

    public function assignedCoordinator()
    {
        return $this->belongsTo(User::class, 'assigned_coordinator_id');
    }

    public function assignedStudents()
    {
        return $this->hasMany(User::class, 'assigned_coordinator_id');
    }
}
