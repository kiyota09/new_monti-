<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'department',
        'position',
        'email',
        'status',
        'hire_date',
        'street_address',
        'street_address_2',
        'city',
        'state',
        'postal_code',
        'sss_document',
        'philhealth_document',
        'pagibig_document',
    ];

    /**
     * Get the attendance records for the employee.
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}