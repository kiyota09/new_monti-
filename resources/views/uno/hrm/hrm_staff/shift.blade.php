<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shift Management - Monti Textile HRM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
         @include('uno.hrm.hrm_staff.style')
    @endif

    <!-- Custom styles -->
    <style>
        /* Content Loading Overlay */
        .content-loading-overlay {
            position: fixed;
            top: 0;
            left: 260px; /* Sidebar width */
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            z-index: 9998;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        
        /* Adjust for collapsed sidebar */
        .sidebar.collapsed ~ .content-loading-overlay {
            left: 80px;
        }
        
        .content-loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 20px;
        }
        
        .loading-content {
            text-align: center;
            color: white;
        }
        
        .loading-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .loading-content p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .loading-progress-bar {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            margin-top: 20px;
            overflow: hidden;
        }
        
        .loading-progress-fill {
            height: 100%;
            background: #ffffff;
            width: 0%;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        
        /* Main content fade-in */
        .main-content.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .main-content.visible {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }
        
        /* Content Fade-in Animation */
        .content-fade-in {
            animation: fadeIn 0.8s ease forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Staggered Animations */
        .stagger-delay-1 { animation-delay: 0.1s; }
        .stagger-delay-2 { animation-delay: 0.2s; }
        .stagger-delay-3 { animation-delay: 0.3s; }
        .stagger-delay-4 { animation-delay: 0.4s; }
        .stagger-delay-5 { animation-delay: 0.5s; }

        .bg-blue-theme { background-color: #2563eb; }
        .bg-yellow-theme { background-color: #fbbf24; }
        .text-blue-theme { color: #2563eb; }
        .text-yellow-theme { color: #fbbf24; }
        
        .sidebar {
            width: 260px;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        
        .sidebar-item {
            position: relative;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
        }
        
        .sidebar-item:hover::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 24px;
            width: 4px;
            background: linear-gradient(to bottom, #3b82f6, #60a5fa);
            border-radius: 0 4px 4px 0;
        }
        
        .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        .sidebar-item.active .sidebar-icon {
            color: #3b82f6;
        }
        
        .main-content {
            transition: margin-left 0.3s ease, opacity 0.8s ease, visibility 0.8s ease;
        }
        
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            background: white;
        }
        
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(to bottom right, #ef4444, #f87171);
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Mobile Sidebar */
        .mobile-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .mobile-sidebar-overlay.active {
            display: block;
        }
        
        /* Shift management specific styles */
        .shift-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .shift-morning { background-color: #3b82f6; color: white; }
        .shift-afternoon { background-color: #8b5cf6; color: white; }
        .shift-night { background-color: #1e293b; color: white; }
        .shift-flexible { background-color: #f59e0b; color: #1f2937; }
        .shift-overtime { background-color: #ef4444; color: white; }
        
        .department-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .department-production { background-color: #3b82f6; color: white; }
        .department-qc { background-color: #8b5cf6; color: white; }
        .department-maintenance { background-color: #f59e0b; color: white; }
        .department-admin { background-color: #10b981; color: white; }
        
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .edit-btn {
            background-color: #fbbf24;
            color: #1f2937;
        }
        
        .edit-btn:hover {
            background-color: #f59e0b;
        }
        
        .assign-btn {
            background-color: #10b981;
            color: white;
        }
        
        .assign-btn:hover {
            background-color: #059669;
        }
        
        .swap-btn {
            background-color: #8b5cf6;
            color: white;
        }
        
        .swap-btn:hover {
            background-color: #7c3aed;
        }
        
        /* Dark mode adjustments */
        .dark .card {
            background-color: #374151;
            border-color: #4b5563;
        }
        
        .dark .sidebar {
            background-color: #1f2937;
            border-color: #374151;
        }
        
        .dark .sidebar-item:hover {
            background-color: #374151;
        }
        
        .dark .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.2);
        }
        
        @media (max-width: 1024px) {
            .content-loading-overlay {
                left: 0;
            }
            
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                height: 100%;
                top: 0;
                left: 0;
                background: white;
            }
            
            .dark .sidebar {
                background-color: #1f2937;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <!-- Mobile Overlay -->
    <div class="mobile-sidebar-overlay" id="mobile-overlay"></div>

    <!-- Sidebar -->
    @include('uno.hrm.hrm_staff.SideBarHrStaff')

    <!-- Content Loading Overlay -->
    <div id="content-loading-overlay" class="content-loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-content">
            <h3>Monti Textile HRM</h3>
            <p>Loading shift management...</p>
        </div>
        <div class="loading-progress-bar">
            <div id="loading-progress-fill" class="loading-progress-fill"></div>
        </div>
    </div>

    <!-- Main Content (Initially hidden) -->
    <div class="main-content flex-1 ml-64 min-h-screen flex flex-col hidden" id="main-content">
        <!-- Top Header -->
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4 px-8 flex items-center justify-between sticky top-0 z-10 content-fade-in">
            <div class="header-content flex items-center justify-between w-full">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Shift Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Manage and adjust employee shifts across all departments</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="date" id="schedule-date" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">2</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-medium hidden md:flex">
                            HR
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Shift Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-sun text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Morning Shift</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">112</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">7AM - 3PM</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-purple-600 dark:text-purple-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Afternoon Shift</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">85</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">3PM - 11PM</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-900 flex items-center justify-center mr-4">
                        <i class="fas fa-moon text-gray-600 dark:text-gray-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Night Shift</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">33</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">11PM - 7AM</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                        <i class="fas fa-exchange-alt text-yellow-600 dark:text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Shift Changes Today</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">8</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Pending: 3</div>
                    </div>
                </div>
            </div>

            <!-- Shift Management Tools -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Bulk Shift Assignment -->
                <div class="card p-6 lg:col-span-2 content-fade-in">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Bulk Shift Assignment</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Department</label>
                            <select id="bulk-department" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Departments</option>
                                <option>Production</option>
                                <option>Quality Control</option>
                                <option>Maintenance</option>
                                <option>Administration</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assign Shift</label>
                            <select id="bulk-shift" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>Morning Shift (7AM - 3PM)</option>
                                <option>Afternoon Shift (3PM - 11PM)</option>
                                <option>Night Shift (11PM - 7AM)</option>
                                <option>Flexible Shift</option>
                                <option>Overtime Shift</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Effective Date</label>
                        <input type="date" id="bulk-effective-date" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button onclick="applyBulkShift()" class="px-6 py-2 bg-blue-theme hover:bg-blue-700 text-white rounded-lg font-medium">
                            <i class="fas fa-users mr-2"></i>Apply to Selected Department
                        </button>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card p-6 content-fade-in stagger-delay-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button onclick="generateShiftSchedule()" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium flex items-center justify-between">
                            <span>Generate Weekly Schedule</span>
                            <i class="fas fa-calendar-plus"></i>
                        </button>
                        <button onclick="viewShiftRotation()" class="w-full px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium flex items-center justify-between">
                            <span>View Shift Rotation</span>
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button onclick="manageOvertime()" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium flex items-center justify-between">
                            <span>Manage Overtime</span>
                            <i class="fas fa-clock"></i>
                        </button>
                        <button onclick="exportShiftReport()" class="w-full px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium flex items-center justify-between">
                            <span>Export Shift Report</span>
                            <i class="fas fa-file-export"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Department Shift Management -->
            <div class="card overflow-hidden mb-8 content-fade-in stagger-delay-2">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Department Shift Assignment</h3>
                        <div class="flex items-center space-x-4">
                            <select id="week-selector" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>This Week</option>
                                <option>Next Week</option>
                                <option>Week 3</option>
                                <option>Week 4</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Employees</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Shift</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Proposed Shift</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Shift Compliance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Production Department -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                            <i class="fas fa-industry text-blue-600 dark:text-blue-300"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Production</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Line 1-4, Cutting, Sewing</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">65</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="shift-badge shift-morning">Morning: 35</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="shift-badge shift-afternoon">Afternoon: 30</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>Morning: 40, Afternoon: 25</option>
                                        <option>Morning: 45, Afternoon: 20</option>
                                        <option>Morning: 35, Afternoon: 30</option>
                                        <option>Rotating Shifts</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 94%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">94%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="manageDepartmentShifts('production')" class="action-btn assign-btn mr-2">
                                        <i class="fas fa-edit mr-1"></i>Manage
                                    </button>
                                    <button onclick="viewDepartmentSchedule('production')" class="action-btn edit-btn">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Quality Control Department -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                            <i class="fas fa-search text-purple-600 dark:text-purple-300"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Quality Control</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Inspection, Testing, QA</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">42</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="shift-badge shift-morning">Morning: 42</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>Morning: 42</option>
                                        <option>Morning: 30, Afternoon: 12</option>
                                        <option>Rotating Shifts</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 96%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">96%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="manageDepartmentShifts('qc')" class="action-btn assign-btn mr-2">
                                        <i class="fas fa-edit mr-1"></i>Manage
                                    </button>
                                    <button onclick="viewDepartmentSchedule('qc')" class="action-btn edit-btn">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Maintenance Department -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                                            <i class="fas fa-tools text-yellow-600 dark:text-yellow-300"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Maintenance</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Equipment, Facilities, Repair</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">28</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="shift-badge shift-morning">Morning: 18</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="shift-badge shift-afternoon">Afternoon: 10</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>Morning: 15, Afternoon: 13</option>
                                        <option>Morning: 20, Afternoon: 8</option>
                                        <option>24/7 Coverage</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 88%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">88%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="manageDepartmentShifts('maintenance')" class="action-btn assign-btn mr-2">
                                        <i class="fas fa-edit mr-1"></i>Manage
                                    </button>
                                    <button onclick="viewDepartmentSchedule('maintenance')" class="action-btn edit-btn">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Administration Department -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                            <i class="fas fa-building text-green-600 dark:text-green-300"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Administration</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">HR, Finance, Management</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">15</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span class="shift-badge shift-morning">Morning: 15</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>Morning: 15</option>
                                        <option>Flexible Hours</option>
                                        <option>Hybrid Schedule</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 98%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">98%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="manageDepartmentShifts('admin')" class="action-btn assign-btn mr-2">
                                        <i class="fas fa-edit mr-1"></i>Manage
                                    </button>
                                    <button onclick="viewDepartmentSchedule('admin')" class="action-btn edit-btn">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <button onclick="saveAllShifts()" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                            <i class="fas fa-save mr-2"></i>Save All Changes
                        </button>
                    </div>
                </div>
            </div>

            <!-- Individual Employee Shift Adjustment -->
            <div class="card p-6 content-fade-in stagger-delay-3">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Individual Shift Adjustment</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Employee</label>
                        <select id="employee-select" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Search or select employee...</option>
                            <option>John Dela Cruz (EMP-2023-001) - Production</option>
                            <option>Maria Santos (EMP-2023-002) - Production</option>
                            <option>Robert Garcia (EMP-2023-003) - Production</option>
                            <option>Ana Perez (EMP-2023-004) - Production</option>
                            <option>Carlos Reyes (EMP-2023-101) - Quality Control</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Shift</label>
                        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm">
                            <span id="current-shift-display">Morning Shift (7AM - 3PM)</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Shift</label>
                        <select id="new-shift" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Morning Shift (7AM - 3PM)</option>
                            <option>Afternoon Shift (3PM - 11PM)</option>
                            <option>Night Shift (11PM - 7AM)</option>
                            <option>Flexible Shift</option>
                            <option>Overtime Shift</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Effective Date</label>
                        <input type="date" id="effective-date" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date (Optional)</label>
                        <input type="date" id="end-date" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Change</label>
                    <select id="change-reason" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Select reason...</option>
                        <option>Production Requirements</option>
                        <option>Employee Request</option>
                        <option>Training Schedule</option>
                        <option>Leave Coverage</option>
                        <option>Performance Management</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Notes</label>
                    <textarea id="change-notes" rows="3" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add any additional notes or instructions..."></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button onclick="previewShiftChange()" class="px-6 py-2 bg-blue-theme hover:bg-blue-700 text-white rounded-lg font-medium">
                        <i class="fas fa-eye mr-2"></i>Preview Change
                    </button>
                    <button onclick="applyIndividualShift()" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                        <i class="fas fa-check mr-2"></i>Apply Shift Change
                    </button>
                </div>
            </div>

            <!-- Upcoming Shift Changes -->
            <div class="card mt-8 p-6 content-fade-in stagger-delay-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Upcoming Shift Changes</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">From</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Effective Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-medium text-xs">
                                            JD
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">John Dela Cruz</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">EMP-2023-001</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="department-badge department-production">Production</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="shift-badge shift-morning">Morning</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="shift-badge shift-afternoon">Afternoon</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Nov 28, 2023</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="approveShiftChange(1)" class="action-btn assign-btn mr-2 text-xs">
                                        Approve
                                    </button>
                                    <button onclick="rejectShiftChange(1)" class="action-btn time-out-btn text-xs">
                                        Reject
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-medium text-xs">
                                            MS
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Maria Santos</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">EMP-2023-002</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="department-badge department-production">Production</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="shift-badge shift-afternoon">Afternoon</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="shift-badge shift-morning">Morning</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Nov 30, 2023</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Approved</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="viewShiftDetails(2)" class="action-btn edit-btn text-xs">
                                        View
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Content loading functionality
        const contentLoadingOverlay = document.getElementById('content-loading-overlay');
        const loadingProgressFill = document.getElementById('loading-progress-fill');
        const mainContent = document.getElementById('main-content');
        const sidebar = document.getElementById('sidebar');
        
        // Adjust loading overlay position when sidebar collapses/expands
        function adjustLoadingOverlay() {
            if (window.innerWidth >= 1024) {
                if (sidebar.classList.contains('collapsed')) {
                    contentLoadingOverlay.style.left = '80px';
                } else {
                    contentLoadingOverlay.style.left = '260px';
                }
            } else {
                contentLoadingOverlay.style.left = '0';
            }
        }
        
        // Simulate loading progress
        function simulateLoading() {
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 95) {
                    progress = 95;
                }
                loadingProgressFill.style.width = progress + '%';
                
                if (progress >= 95) {
                    clearInterval(interval);
                }
            }, 200);
        }
        
        // Hide loading overlay and show main content
        function showMainContent() {
            loadingProgressFill.style.width = '100%';
            
            setTimeout(() => {
                contentLoadingOverlay.classList.add('hidden');
                mainContent.classList.remove('hidden');
                mainContent.classList.add('visible');
                
                // Add animation classes to content elements
                const contentElements = document.querySelectorAll('.content-fade-in');
                contentElements.forEach((el, index) => {
                    el.style.animationDelay = (index * 0.1) + 's';
                    el.style.opacity = '1';
                });
                
                // Remove loading overlay from DOM after animation
                setTimeout(() => {
                    contentLoadingOverlay.style.display = 'none';
                }, 500);
            }, 300);
        }
        
        // Start loading simulation
        document.addEventListener('DOMContentLoaded', () => {
            simulateLoading();
            adjustLoadingOverlay();
            
            // Initialize sidebar toggle listeners immediately
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileOverlay = document.getElementById('mobile-overlay');
            
            // Function to toggle sidebar
            function toggleSidebar() {
                if (window.innerWidth < 1024) {
                    // Mobile behavior
                    sidebar.classList.toggle('active');
                    mobileOverlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
                } else {
                    // Desktop behavior
                    sidebar.classList.toggle('collapsed');
                    mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '260px';
                    adjustLoadingOverlay();
                }
            }
            
            // Function to close sidebar on mobile
            function closeSidebar() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
            
            // Event listeners for sidebar (work immediately)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleSidebar);
            }
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', closeSidebar);
            }
            
            // Handle responsive behavior on load
            if (window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
            }
        });
        
        // Hide overlay when window is fully loaded
        window.addEventListener('load', () => {
            showMainContent();
        });
        
        // Fallback: hide loading after 3 seconds max
        setTimeout(() => {
            if (!contentLoadingOverlay.classList.contains('hidden')) {
                showMainContent();
            }
        }, 3000);
        
        // Handle window resize
        window.addEventListener('resize', () => {
            adjustLoadingOverlay();
            
            if (window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
                sidebar.classList.remove('collapsed');
                
                // Close sidebar if open when resizing to mobile
                if (sidebar.classList.contains('active')) {
                    document.body.style.overflow = '';
                }
            } else {
                // Reset to desktop behavior
                mobileOverlay.classList.remove('active');
                sidebar.classList.remove('active');
                document.body.style.overflow = '';
                
                // Apply collapsed state if needed
                mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '80px' : '260px';
                adjustLoadingOverlay();
            }
        });

        // Initialize progress animations when main content is shown
        mainContent.addEventListener('animationend', () => {
            // Add any specific animations for shift page
        });

        // Shift management functions
        function applyBulkShift() {
            const department = document.getElementById('bulk-department').value;
            const shift = document.getElementById('bulk-shift').value;
            const effectiveDate = document.getElementById('bulk-effective-date').value;
            
            if(confirm(`Apply ${shift} to ${department} effective ${effectiveDate}?`)) {
                alert(`Shift assignment applied successfully to ${department}`);
                // In a real application, you would make an AJAX call here
            }
        }
        
        function manageDepartmentShifts(department) {
            alert(`Managing shifts for ${department} department`);
            // In a real application, you would open a modal here
        }
        
        function viewDepartmentSchedule(department) {
            alert(`Viewing schedule for ${department} department`);
            // In a real application, you would open a modal here
        }
        
        function saveAllShifts() {
            if(confirm('Save all shift changes?')) {
                alert('All shift changes saved successfully');
                // In a real application, you would make an AJAX call here
            }
        }
        
        function applyIndividualShift() {
            const employee = document.getElementById('employee-select').value;
            const newShift = document.getElementById('new-shift').value;
            const effectiveDate = document.getElementById('effective-date').value;
            const reason = document.getElementById('change-reason').value;
            
            if(confirm(`Apply ${newShift} to ${employee} effective ${effectiveDate}?`)) {
                alert('Individual shift change applied successfully');
                // In a real application, you would make an AJAX call here
            }
        }
        
        function previewShiftChange() {
            alert('Preview shift change modal would open here');
            // In a real application, you would open a preview modal here
        }
        
        function approveShiftChange(id) {
            if(confirm('Approve this shift change?')) {
                alert(`Shift change #${id} approved`);
                // In a real application, you would make an AJAX call here
            }
        }
        
        function rejectShiftChange(id) {
            if(confirm('Reject this shift change?')) {
                alert(`Shift change #${id} rejected`);
                // In a real application, you would make an AJAX call here
            }
        }
        
        function viewShiftDetails(id) {
            alert(`Viewing details for shift change #${id}`);
            // In a real application, you would open a modal here
        }
        
        // Quick action functions
        function generateShiftSchedule() {
            alert('Generating weekly shift schedule...');
            // In a real application, you would trigger schedule generation
        }
        
        function viewShiftRotation() {
            alert('Opening shift rotation view...');
            // In a real application, you would navigate or open a modal
        }
        
        function manageOvertime() {
            alert('Opening overtime management...');
            // In a real application, you would navigate or open a modal
        }
        
        function exportShiftReport() {
            alert('Exporting shift report...');
            // In a real application, you would trigger report export
        }
        
        // Initialize date pickers
        document.addEventListener('DOMContentLoaded', () => {
            // Set today's date in date pickers
            const today = new Date().toISOString().split('T')[0];
            if (document.getElementById('schedule-date')) {
                document.getElementById('schedule-date').value = today;
            }
            if (document.getElementById('bulk-effective-date')) {
                document.getElementById('bulk-effective-date').value = today;
            }
            if (document.getElementById('effective-date')) {
                document.getElementById('effective-date').value = today;
            }
            
            // Set next week for end date
            const nextWeek = new Date();
            nextWeek.setDate(nextWeek.getDate() + 7);
            const nextWeekFormatted = nextWeek.toISOString().split('T')[0];
            if (document.getElementById('end-date')) {
                document.getElementById('end-date').value = nextWeekFormatted;
            }
        });
    </script>
</body>
</html>