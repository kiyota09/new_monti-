<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    /**
     * Display a listing of applicants
     */
    public function index()
    {
        $applicants = Applicant::orderBy('created_at', 'desc')->paginate(10);

        return view('uno.hrm.hrm_staff.application', compact('applicants'));
    }

    /**
     * Show the form for creating a new resources
     */
    public function create()
    {
        return view('applicants.create');
    }

    /**
     * Store a newly created applicant
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_month' => 'required|numeric|between:1,12',
            'birth_day' => 'required|numeric|between:1,31',
            'birth_year' => 'required|numeric|min:1960|max:' . date('Y'),
            'street_address' => 'required|string|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'position_applied' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'available_start_date' => 'required|date',
            'expected_salary' => 'nullable|string|max:50',
            'notice_period' => 'nullable|string|max:50',
            'experience' => 'nullable|in:yes,no',
            // Add validation for new government documents
            'sss_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'philhealth_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pagibig_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // Build birth date
            $birthMonth = str_pad($validated['birth_month'], 2, '0', STR_PAD_LEFT);
            $birthDay = str_pad($validated['birth_day'], 2, '0', STR_PAD_LEFT);
            $birthYear = $validated['birth_year'];

            $birthDate = "{$birthYear}-{$birthMonth}-{$birthDay}";

            if (!checkdate($validated['birth_month'], $validated['birth_day'], $validated['birth_year'])) {
                return back()->with('error', 'Invalid birth date')->withInput();
            }

            // Store resume

            // Store government documents if provided
            $sssPath = null;
            $philhealthPath = null;
            $pagibigPath = null;

            if ($request->hasFile('sss_document')) {
                $sssPath = $request->file('sss_document')->store('government_documents', 'public');
            }

            if ($request->hasFile('philhealth_document')) {
                $philhealthPath = $request->file('philhealth_document')->store('government_documents', 'public');
            }

            if ($request->hasFile('pagibig_document')) {
                $pagibigPath = $request->file('pagibig_document')->store('government_documents', 'public');
            }

            // Create applicant
            $applicant = Applicant::create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'birth_date' => $birthDate,
                'street_address' => $validated['street_address'],
                'street_address_2' => $validated['street_address_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'postal_code' => $validated['postal_code'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'linkedin' => $validated['linkedin'] ?? null,
                'position_applied' => $validated['position_applied'],
                'source' => $validated['source'],
                'available_start_date' => $validated['available_start_date'],
                'archived' => false,
                'expected_salary' => $validated['expected_salary'] ?? null,
                'notice_period' => $validated['notice_period'] ?? null,
                'experience' => ($validated['experience'] ?? null) === 'yes',
                'status' => 'pending',
                // Add new fields for government documents
                'sss_document' => $sssPath,
                'philhealth_document' => $philhealthPath,
                'pagibig_document' => $pagibigPath,
            ]);

            return redirect()->route('applicants.index')
                ->with('success', 'Applicant saved successfully!');
        } catch (\Exception $e) {
            \Log::error('Error saving applicant: ' . $e->getMessage());

            return back()->with('error', 'Error saving applicant: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Display the specified applicant
     */
    public function show(Applicant $applicant)
    {
        return view('applicants.show', compact('applicants'));
    }
    
    /**
     * Show the form for editing the specified applicant
     */
    public function edit(Applicant $applicant)
    {
        return view('applicants.edit', compact('applicant'));
    }

    /**
     * Update the specified applicant
     */
    public function update(Request $request, Applicant $applicant)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'street_address' => 'required|string|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'position_applied' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'available_start_date' => 'required|date',
            'expected_salary' => 'nullable|string|max:50',
            'notice_period' => 'nullable|string|max:50',
            'experience' => 'nullable|boolean',
            'status' => 'required|in:pending,reviewed,interview_scheduled,interviewed,shortlisted,rejected,hired',
        ]);

        // if ($request->hasFile('resume')) {
        //     if ($applicant->resume && Storage::disk('public')->exists($applicant->resume)) {
        //         Storage::disk('public')->delete($applicant->resume);
        //     }
        //     $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        // }

        $applicant->update($validated);

        return redirect()->route('applicants.index')
            ->with('success', 'Applicant updated successfully.');
    }

    /**
     * UPDATE STATUS METHOD - This was missing!
     */
    public function updateStatus(Request $request, Applicant $applicant)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview_scheduled,interviewed,shortlisted,rejected,hired',
        ]);

        $applicant->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully!');
    }

    /**
     * Remove the specified applicant
     */
    public function destroy(Applicant $applicant)
    {
        if ($applicant->resume && Storage::disk('public')->exists($applicant->resume)) {
            Storage::disk('public')->delete($applicant->resume);
        }

        $applicant->delete();

        return redirect()->route('applicants.index')
            ->with('success', 'Applicant deleted successfully.');
    }
}
