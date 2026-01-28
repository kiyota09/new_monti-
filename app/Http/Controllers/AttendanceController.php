<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Show the time entry form
     */
    public function create()
    {
        // Fetch all active employees
        $employees = Employee::where('status', 'active')
            ->orderBy('name')
            ->get();
        
        return view('uno.hrm.hrm_staff.time', compact('employees'));
    }

    /**
     * Store a new time entry
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            // Check if attendance already exists for this employee on this date
            $existingAttendance = Attendance::where('employee_id', $validated['employee_id'])
                ->where('date', $validated['date'])
                ->first();

            if ($existingAttendance) {
                // Update existing attendance
                $existingAttendance->update($validated);
                $message = 'Attendance updated successfully!';
            } else {
                // Create new attendance
                Attendance::create($validated);
                $message = 'Time entry saved successfully!';
            }

            return redirect()->route('hrm.staff.time')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Error saving attendance: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display attendance records
     */
    public function index(Request $request)
    {
        $query = Attendance::with('employee')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        // Add search filters if needed
        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $attendance = $query->paginate(50);
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('attendance.index', compact('attendance', 'employees'));
    }
}