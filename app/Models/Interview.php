<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'interview_date',
        'interview_time',
        'interview_type',
        'interviewers',
        'notes',
        'scheduled_by',
        'scheduled_at',
        'score',
        'feedback',
        'cancelled_at',
        'completed_at'
    ];

    protected $casts = [
        'interview_date' => 'date',
        'scheduled_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
        'score' => 'decimal:1',
    ];

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    // Accessors
    public function getFormattedDateTimeAttribute(): string
    {
        return $this->interview_date->format('F j, Y') . ' at ' . 
               date('g:i A', strtotime($this->interview_time));
    }

    public function getInterviewTypeNameAttribute(): string
    {
        $types = Applicant::interviewTypeOptions();
        return $types[$this->interview_type] ?? ucfirst($this->interview_type);
    }

    public function getDurationAttribute(): string
    {
        // Default to 1 hour
        $start = strtotime($this->interview_time);
        $end = strtotime('+1 hour', $start);
        return date('g:i A', $start) . ' - ' . date('g:i A', $end);
    }

    public function getStatusAttribute(): string
    {
        if ($this->cancelled_at) {
            return 'Cancelled';
        }

        if ($this->completed_at) {
            return 'Completed';
        }

        $interviewDateTime = $this->interview_date->copy();
        $timeParts = explode(':', $this->interview_time);
        $interviewDateTime->setTime($timeParts[0], $timeParts[1] ?? 0);

        return $interviewDateTime->isPast() ? 'Missed' : 'Scheduled';
    }

    public function getIsUpcomingAttribute(): bool
    {
        $interviewDateTime = $this->interview_date->copy();
        $timeParts = explode(':', $this->interview_time);
        $interviewDateTime->setTime($timeParts[0], $timeParts[1] ?? 0);

        return $interviewDateTime->isFuture();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->whereDate('interview_date', '>=', now()->toDateString())
                    ->whereNull('cancelled_at')
                    ->orderBy('interview_date', 'asc')
                    ->orderBy('interview_time', 'asc');
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeCancelled($query)
    {
        return $query->whereNotNull('cancelled_at');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('interview_date', $date);
    }

    public function scopeForApplicant($query, $applicantId)
    {
        return $query->where('applicant_id', $applicantId);
    }

    // Business logic
    public function markAsCompleted(float $score = null, string $feedback = null): void
    {
        $this->update([
            'completed_at' => now(),
            'score' => $score,
            'feedback' => $feedback,
        ]);

        // Update applicant status
        $this->applicant->markAsInterviewed();
    }

    public function cancel(): void
    {
        $this->update(['cancelled_at' => now()]);
        $this->applicant->cancelInterview();
    }

    public function reschedule(string $newDate, string $newTime): void
    {
        $this->update([
            'interview_date' => $newDate,
            'interview_time' => $newTime,
            'scheduled_at' => now(),
            'cancelled_at' => null,
        ]);

        $this->applicant->update([
            'interview_date' => $newDate,
            'interview_time' => $newTime,
        ]);
    }
}