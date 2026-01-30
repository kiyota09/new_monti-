<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Applicant extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'street_address',
        'street_address_2',
        'city',
        'state',
        'postal_code',
        'email',
        'phone',
        'linkedin',
        'position_applied',
        'source',
        'available_start_date',
        'sss_document',
        'philhealth_document',
        'pagibig_document',
        'expected_salary',
        'notice_period',
        'experience',
        'status',
        'interview_date', // Added for quick access
        'interview_time', // Added for quick access
    ];

    protected $casts = [
        'birth_date' => 'date',
        'available_start_date' => 'date',
        'interview_date' => 'date',
        'has_textile_experience' => 'boolean',
        'expected_salary' => 'decimal:2',
    ];

    // Add these accessors for interview data
    public function getInterviewDateTimeAttribute(): ?string
    {
        if ($this->interview_date && $this->interview_time) {
            return $this->interview_date->format('Y-m-d') . ' ' . $this->interview_time;
        }
        return null;
    }

    public function getFormattedInterviewDateTimeAttribute(): ?string
    {
        if ($this->interview_date && $this->interview_time) {
            return $this->interview_date->format('F d, Y') . ' at ' . 
                   date('g:i A', strtotime($this->interview_time));
        }
        return null;
    }

    public function getUpcomingInterviewAttribute(): bool
    {
        if (!$this->interview_date) {
            return false;
        }
        
        $interviewDateTime = $this->interview_date->copy();
        if ($this->interview_time) {
            $timeParts = explode(':', $this->interview_time);
            $interviewDateTime->setTime($timeParts[0], $timeParts[1] ?? 0);
        }
        
        return $interviewDateTime->isFuture();
    }

    public function getInterviewStatusAttribute(): string
    {
        if ($this->status === 'interview_scheduled') {
            if ($this->upcoming_interview) {
                return 'Upcoming';
            } else {
                return 'Past Interview';
            }
        }
        return '';
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        $names = [$this->first_name, $this->middle_name, $this->last_name];
        return implode(' ', array_filter($names));
    }

    public function getFormattedAddressAttribute(): string
    {
        $address = $this->street_address;

        if ($this->street_address_2) {
            $address .= ', ' . $this->street_address_2;
        }

        $address .= ', ' . $this->city . ', ' . $this->state . ' ' . $this->postal_code;

        return $address;
    }

    public function getBirthDateFormattedAttribute(): string
    {
        return $this->birth_date->format('F d, Y');
    }

    public function getAvailableStartDateFormattedAttribute(): string
    {
        return $this->available_start_date->format('F d, Y');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', 'shortlisted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeInterviewScheduled($query)
    {
        return $query->where('status', 'interview_scheduled');
    }

    public function scopeInterviewed($query)
    {
        return $query->where('status', 'interviewed');
    }

    public function scopeHired($query)
    {
        return $query->where('status', 'hired');
    }

    public function scopeWithUpcomingInterviews($query)
    {
        return $query->where('status', 'interview_scheduled')
                    ->whereDate('interview_date', '>=', now());
    }

    public function scopeWithPastInterviews($query)
    {
        return $query->where('status', 'interview_scheduled')
                    ->whereDate('interview_date', '<', now());
    }

    // Position names mapping
    public static function positionOptions(): array
    {
        return [
            'production_supervisor' => 'Production Supervisor',
            'quality_inspector' => 'Quality Control Inspector',
            'maintenance_tech' => 'Maintenance Technician',
            'hr_assistant' => 'HR Assistant',
            'warehouse_staff' => 'Warehouse Staff',
            'textile_designer' => 'Textile Designer',
            'machine_operator' => 'Machine Operator',
        ];
    }

    public static function sourceOptions(): array
    {
        return [
            'linkedin' => 'LinkedIn',
            'job_portal' => 'Job Portal',
            'referral' => 'Employee Referral',
            'social_media' => 'Social Media',
            'company_website' => 'Company Website',
            'career_fair' => 'Career Fair',
        ];
    }

    public static function noticePeriodOptions(): array
    {
        return [
            'immediate' => 'Immediate',
            '1_week' => '1 Week',
            '2_weeks' => '2 Weeks',
            '1_month' => '1 Month',
            '2_months' => '2 Months',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'under_review' => 'Under Review',
            'interview_scheduled' => 'Interview Scheduled',
            'interviewed' => 'Interviewed',
            'shortlisted' => 'Shortlisted',
            'rejected' => 'Rejected',
            'hired' => 'Hired',
        ];
    }

    public static function interviewTypeOptions(): array
    {
        return [
            'phone' => 'Phone Interview',
            'video' => 'Video Interview',
            'in_person' => 'In-Person Interview',
        ];
    }

    public function getPositionNameAttribute(): string
    {
        return self::positionOptions()[$this->position_applied] ?? $this->position_applied;
    }

    public function getSourceNameAttribute(): string
    {
        return self::sourceOptions()[$this->source] ?? $this->source;
    }

    public function getStatusNameAttribute(): string
    {
        return self::statusOptions()[$this->status] ?? $this->status;
    }

    // Relationships
    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class)->orderBy('interview_date', 'desc');
    }

    public function latestInterview(): HasOne
    {
        return $this->hasOne(Interview::class)->latestOfMany();
    }

    public function upcomingInterview(): HasOne
    {
        return $this->hasOne(Interview::class)
                    ->where('interview_date', '>=', now()->toDateString())
                    ->orderBy('interview_date', 'asc');
    }

    // Business logic methods
    public function scheduleInterview(array $interviewData): Interview
    {
        $interview = $this->interviews()->create([
            'interview_date' => $interviewData['interview_date'],
            'interview_time' => $interviewData['interview_time'],
            'interview_type' => $interviewData['interview_type'],
            'interviewers' => $interviewData['interviewers'] ?? null,
            'notes' => $interviewData['notes'] ?? null,
            'scheduled_by' => auth()->id(),
            'scheduled_at' => now(),
        ]);

        // Update applicant status and store interview details
        $this->update([
            'status' => 'interview_scheduled',
            'interview_date' => $interviewData['interview_date'],
            'interview_time' => $interviewData['interview_time'],
        ]);

        return $interview;
    }

    public function cancelInterview(): void
    {
        $this->update([
            'status' => 'pending',
            'interview_date' => null,
            'interview_time' => null,
        ]);

        // Optionally, you could also mark the interview as cancelled
        $this->latestInterview?->update(['cancelled_at' => now()]);
    }

    public function markAsInterviewed(): void
    {
        $this->update([
            'status' => 'interviewed'
        ]);
    }

    public function hasInterviewScheduled(): bool
    {
        return $this->status === 'interview_scheduled';
    }

    public function getInterviewScoreAttribute(): ?float
    {
        $latestInterview = $this->latestInterview;
        return $latestInterview ? $latestInterview->score : null;
    }

    public function getInterviewFeedbackAttribute(): ?string
    {
        $latestInterview = $this->latestInterview;
        return $latestInterview ? $latestInterview->feedback : null;
    }

    // Event handlers
    protected static function boot()
    {
        parent::boot();

        // Automatically set available_start_date if not provided
        static::creating(function ($applicant) {
            if (!$applicant->available_start_date) {
                $applicant->available_start_date = now()->addDays(14);
            }
        });

        // Clean up interviews when applicant is deleted
        static::deleting(function ($applicant) {
            $applicant->interviews()->delete();
        });
    }
}