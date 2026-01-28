<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    ];


    protected $casts = [
        'birth_date' => 'date',
        'available_start_date' => 'date',
        'has_textile_experience' => 'boolean',
    ];

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
            'shortlisted' => 'Shortlisted',
            'rejected' => 'Rejected',
            'hired' => 'Hired',
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

}
