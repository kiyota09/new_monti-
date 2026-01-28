<div class="sidebar bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col py-6 px-4 fixed h-full z-10">
    <div class="flex items-center justify-between px-2 mb-8">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-blue-theme flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
            </div>
            <span class="font-bold text-xl text-gray-900 dark:text-white">
                Monti Textile
            </span>
        </div>
    </div>

    <nav class="flex-1 space-y-1">
        <a href="{{ route('hrm.staff.dashboard') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
            <i class="fas fa-home w-6 text-center"></i>
            <span>Employee Information</span>
        </a>

        <a href="{{ route('hrm.staff.payroll') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
            <i class="fas fa-money-check-alt w-6 text-center"></i>
            <span>Payroll Management</span>
        </a>

        <a href="{{ route('hrm.staff.leave') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
            <i class="fas fa-calendar-alt w-6 text-center"></i>
            <span>Leave Request</span>
        </a>

        <a href="{{ route('hrm.staff.attendance') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
            <i class="fas fa-clock w-6 text-center"></i>
            <span>Time and Attendance</span>
        </a>

        <a href="{{ route('hrm.staff.training') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl text-gray-600 dark:text-gray-300 hover:text-blue-theme">
            <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
            <span>Training Records</span>
        </a>

        <div class="py-4 px-4">
            <div class="border-t border-gray-200 dark:border-gray-700"></div>
        </div>

        <!-- ✅ LOGOUT (PLAIN & SAFE) -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center space-x-3 py-3 px-4 rounded-xl
                       text-gray-600 dark:text-gray-300 hover:text-red-600">
                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>

    <!-- ✅ HELP SECTION RESTORED -->
    <div class="px-4 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="bg-blue-50 dark:bg-blue-900 rounded-xl p-4">
            <div class="text-blue-800 dark:text-blue-200 font-medium text-sm mb-2">
                Need help?
            </div>
            <p class="text-blue-600 dark:text-blue-300 text-xs mb-3">
                Contact our Tech support team for assistance
            </p>
            <button
                class="w-full bg-blue-theme hover:bg-blue-700 text-white py-2 rounded-lg text-xs font-medium transition-colors">
                Get Help
            </button>
        </div>
    </div>
</div>
