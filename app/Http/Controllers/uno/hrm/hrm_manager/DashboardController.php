<?php

namespace App\Http\Controllers\uno\hrm\hrm_manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the HRM Manager Dashboard.
     */
    public function dashboard()
    {
        $staff = User::hrmStaff()->orderByName()->get();

        return view('uno.hrm.hrm_manager.dashboard', compact('staff'));
    }

    /**
     * Promote a staff to manager.
     */
    public function promoteUser(Request $request, User $user)
    {
        $this->authorizePromotion($user);
        $user->update(['position' => 'manager']);

        return back()->with('success', 'User promoted to manager successfully!');
    }

    /**
     * Show HRM Manager Onboarding.
     */
    public function onboarding()
    {
        return $this->view('onboarding');
    }

    /**
     * Show HRM Manager Payroll.
     */
    public function payroll()
    {
        return $this->view('payroll');
    }

    /**
     * Show HRM Manager Analytics.
     */
    public function analytics()
    {
        return $this->view('analytics');
    }

    /**
     * Show HRM Manager Settings.
     */
    public function settings()
    {
        return $this->view('settings');
    }

    /**
     * Authorize user promotion.
     */
    private function authorizePromotion(User $user): void
    {
        if (! $user->isHrm() || $user->isManager()) {
            abort(403, 'Invalid user for promotion');
        }
    }

    /**
     * Helper method to render views consistently.
     */
    private function view(string $page)
    {
        return view("uno.hrm.hrm_manager.{$page}");
    }
}
