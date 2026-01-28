<?php

namespace App\Http\Controllers\uno\scm\scm_staff;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the SCM Staff Dashboard.
     */
    public function dashboard()
    {
        $users = User::scm()->orderByName()->get();

        return view('uno.scm.scm_staff.dashboard', compact('users'));
    }

    /**
     * Show SCM Staff Inventory.
     */
    public function inventory()
    {
        return $this->view('inventory');
    }

    /**
     * Show SCM Staff Orders.
     */
    public function orders()
    {
        return $this->view('orders');
    }

    /**
     * Show SCM Staff Suppliers.
     */
    public function suppliers()
    {
        return $this->view('suppliers');
    }

    /**
     * Show SCM Staff Warehouse.
     */
    public function warehouse()
    {
        return $this->view('warehouse');
    }

    /**
     * Show SCM Staff Onboarding.
     */
    public function onboarding()
    {
        return $this->view('onboarding');
    }

    /**
     * Show SCM Staff Settings.
     */
    public function settings()
    {
        return $this->view('settings');
    }

    /**
     * Helper method to render views consistently.
     */
    private function view(string $page)
    {
        return view("uno.scm.scm_staff.{$page}");
    }
}
