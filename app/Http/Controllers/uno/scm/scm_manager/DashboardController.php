<?php

namespace App\Http\Controllers\uno\scm\scm_manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the SCM Manager Dashboard.
     */
    public function dashboard()
    {
        $staff = User::scmStaff()->orderByName()->get();

        return view('uno.scm.scm_manager.dashboard', compact('staff'));
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
     * Show SCM Manager Onboarding.
     */
    public function onboarding()
    {
        return $this->view('onboarding');
    }

    /**
     * Show SCM Manager Inventory.
     */
    public function inventory()
    {
        return $this->view('inventory');
    }

    /**
     * Show SCM Manager Orders.
     */
    public function orders()
    {
        return $this->view('orders');
    }

    /**
     * Show SCM Manager Settings.
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
        if (! $user->isScm() || $user->isManager()) {
            abort(403, 'Invalid user for promotion');
        }
    }

    /**
     * Helper method to render views consistently.
     */
    private function view(string $page)
    {
        return view("uno.scm.scm_manager.{$page}");
    }
}
