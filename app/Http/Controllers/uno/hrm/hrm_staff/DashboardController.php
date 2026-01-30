<?php

namespace App\Http\Controllers\uno\hrm\hrm_staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Applicant;
use App\Models\Employee; // Add this import
use App\Http\Controllers\uno\hrm\ApplicantController;

class DashboardController extends Controller
{
    /**
     * Show the HRM Staff Dashboard.
     */
    public function dashboard()
    {
        $users = User::hrm()->orderByName()->get();

        return view('uno.hrm.hrm_staff.dashboard', compact('users'));
    }

    /**
     * Show HRM Staff Payroll.
     */
    public function payroll()
    {
        return $this->view('payroll');
    }

    /**
     * Show HRM Staff Leave.
     */
    public function leave()
    {
        return $this->view('leave');
    }

    /**
     * Show HRM Staff Attendance.
     */
    public function attendance()
    {
        return $this->view('attendance');
    }

    /**
     * Show HRM Staff Training.
     */
    public function training()
    {
        return $this->view('training');
    }

    /**
     * Show HRM Staff Employee.
     */
    public function employee()
    {
        return $this->view('employee');
    }

    /**
     * Show HRM Staff Application.
     */
    public function application()
    {
        $applicants = Applicant::orderBy('created_at', 'desc')->paginate(10);
        return view('uno.hrm.hrm_staff.application', compact('applicants'));
    }

    /**
     * Show HRM Staff Paylist.
     */
    public function paylist()
    {
        return $this->view('paylist');
    }

    /**
     * Show HRM Staff Leave Request.
     */
    public function leaveRequest()
    {
        return $this->view('LeaveRequest');
    }

    /**
     * Show HRM Staff Time.
     */
    public function time()
    {
        // Fetch active employees for the dropdown
        // $employees = Employee::where('status', 'active')
        //     ->orderBy('name')
        //     ->get();
        
        // // // Pass employees to the view
        return view('uno.hrm.hrm_staff.time');
    }

    /**
     * Show HRM Staff Shift.
     */
    public function shift()
    {
        return $this->view('shift');
    }

    /**
     * Show HRM Staff Trainee.
     */
    public function trainee()
    {
        return $this->view('trainee');
    }

    /**
     * Helper method to render views consistently.
     */
    private function view(string $page)
    {
        return view("uno.hrm.hrm_staff.{$page}");
    }
}