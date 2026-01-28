<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Time Tracking - Monti Textile HRM</title>

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
        
        /* Time tracking specific styles */
        .time-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .time-in-btn {
            background-color: #10b981;
            color: white;
        }
        
        .time-in-btn:hover {
            background-color: #059669;
        }
        
        .time-out-btn {
            background-color: #ef4444;
            color: white;
        }
        
        .time-out-btn:hover {
            background-color: #dc2626;
        }
        
        .edit-btn {
            background-color: #fbbf24;
            color: #1f2937;
        }
        
        .edit-btn:hover {
            background-color: #f59e0b;
        }
        
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
        
        .status-present { background-color: #d1fae5; color: #065f46; }
        .status-absent { background-color: #fee2e2; color: #991b1b; }
        .status-late { background-color: #fef3c7; color: #92400e; }
        .status-on-duty { background-color: #dbeafe; color: #1e40af; }
        
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
            <p>Loading time tracking...</p>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Time In & Time Out Tracking</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Monitor and manage employee attendance across all departments</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="date" id="date-selector" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-medium hidden md:flex">
                            TA
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Department Filter -->
            <div class="mb-8 content-fade-in">
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="px-4 py-2 bg-blue-theme text-white rounded-lg text-sm font-medium">All Departments</button>
                    <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">Production</button>
                    <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">Quality Control</button>
                    <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">Maintenance</button>
                    <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600">Administration</button>
                </div>
                
                <div class="flex justify-between items-center">
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ now()->format('F d, Y') }}</div>
                    <div class="flex items-center space-x-4">
                        <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                            <i class="fas fa-sync-alt mr-2"></i>Sync Biometric Data
                        </button>
                        <button class="px-4 py-2 bg-blue-theme hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                            <i class="fas fa-download mr-2"></i>Export Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Time Tracking Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-users text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Employees</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">230</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                        <i class="fas fa-user-check text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Clocked In Today</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">218</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Pending Time Out</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">45</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Late Arrivals</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">8</div>
                    </div>
                </div>
            </div>

            <!-- Time Tracking Table -->
            <div class="card overflow-hidden content-fade-in stagger-delay-1">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Employee Time Records</h3>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search employee..." class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                            </div>
                            <select class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Status</option>
                                <option>Present</option>
                                <option>Absent</option>
                                <option>Late</option>
                                <option>On Duty</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Shift</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Hours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        {{-- <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Production Department -->
                            <tr class="bg-blue-50/30 dark:bg-blue-900/20">
                                <td colspan="8" class="px-6 py-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-industry text-blue-600 dark:text-blue-400 mr-2"></i>
                                        <span class="font-bold text-blue-700 dark:text-blue-300">Production Department</span>
                                        <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">(65 employees)</span>
                                    </div>
                                </td>
                            </tr>
                            
                            @php
                                $productionEmployees = [
                                    ['id' => 'EMP-2023-001', 'name' => 'John Dela Cruz', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '06:58 AM', 'time_out' => '03:05 PM', 'status' => 'present', 'hours' => '8.1'],
                                    ['id' => 'EMP-2023-002', 'name' => 'Maria Santos', 'shift' => 'Afternoon (3PM-11PM)', 'time_in' => '02:55 PM', 'time_out' => '--:--', 'status' => 'on-duty', 'hours' => '--'],
                                    ['id' => 'EMP-2023-003', 'name' => 'Robert Garcia', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '08:25 AM', 'time_out' => '03:10 PM', 'status' => 'late', 'hours' => '6.8'],
                                    ['id' => 'EMP-2023-004', 'name' => 'Ana Perez', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '--:--', 'time_out' => '--:--', 'status' => 'absent', 'hours' => '0'],
                                ];
                            @endphp
                            
                            @foreach($productionEmployees as $employee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-medium">
                                            {{ substr($employee['name'], 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $employee['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $employee['id'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="department-badge department-production">Production</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $employee['shift'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $employee['time_in'] == '--:--' ? 'text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $employee['time_in'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $employee['time_out'] == '--:--' ? 'text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $employee['time_out'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($employee['status'] == 'present')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-present">Present</span>
                                    @elseif($employee['status'] == 'absent')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-absent">Absent</span>
                                    @elseif($employee['status'] == 'late')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-late">Late</span>
                                    @elseif($employee['status'] == 'on-duty')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-on-duty">On Duty</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $employee['hours'] == '--' ? '--' : $employee['hours'] . ' hrs' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($employee['time_out'] == '--:--' && $employee['time_in'] != '--:--')
                                        <button class="time-out-btn time-btn mr-2" onclick="recordTimeOut('{{ $employee['id'] }}')">
                                            <i class="fas fa-sign-out-alt mr-1"></i>Time Out
                                        </button>
                                    @elseif($employee['time_in'] == '--:--')
                                        <button class="time-in-btn time-btn mr-2" onclick="recordTimeIn('{{ $employee['id'] }}')">
                                            <i class="fas fa-sign-in-alt mr-1"></i>Time In
                                        </button>
                                    @endif
                                    <button class="edit-btn time-btn" onclick="editTimeRecord('{{ $employee['id'] }}')">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                            <!-- Quality Control Department -->
                            <tr class="bg-purple-50/30 dark:bg-purple-900/20">
                                <td colspan="8" class="px-6 py-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-search text-purple-600 dark:text-purple-400 mr-2"></i>
                                        <span class="font-bold text-purple-700 dark:text-purple-300">Quality Control Department</span>
                                        <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">(42 employees)</span>
                                    </div>
                                </td>
                            </tr>
                            
                            @php
                                $qcEmployees = [
                                    ['id' => 'EMP-2023-101', 'name' => 'Carlos Reyes', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '06:55 AM', 'time_out' => '03:02 PM', 'status' => 'present', 'hours' => '8.1'],
                                    ['id' => 'EMP-2023-102', 'name' => 'Sofia Martinez', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '07:05 AM', 'time_out' => '03:10 PM', 'status' => 'present', 'hours' => '8.1'],
                                ];
                            @endphp
                            
                            @foreach($qcEmployees as $employee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-medium">
                                            {{ substr($employee['name'], 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $employee['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $employee['id'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="department-badge department-qc">Quality Control</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $employee['shift'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $employee['time_in'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $employee['time_out'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-present">Present</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $employee['hours'] }} hrs</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="edit-btn time-btn" onclick="editTimeRecord('{{ $employee['id'] }}')">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                            <!-- Maintenance Department -->
                            <tr class="bg-yellow-50/30 dark:bg-yellow-900/20">
                                <td colspan="8" class="px-6 py-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-tools text-yellow-600 dark:text-yellow-400 mr-2"></i>
                                        <span class="font-bold text-yellow-700 dark:text-yellow-300">Maintenance Department</span>
                                        <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">(28 employees)</span>
                                    </div>
                                </td>
                            </tr>
                            
                            @php
                                $maintenanceEmployees = [
                                    ['id' => 'EMP-2023-201', 'name' => 'James Wilson', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '07:10 AM', 'time_out' => '03:15 PM', 'status' => 'late', 'hours' => '8.1'],
                                    ['id' => 'EMP-2023-202', 'name' => 'Lisa Brown', 'shift' => 'Afternoon (3PM-11PM)', 'time_in' => '02:45 PM', 'time_out' => '--:--', 'status' => 'on-duty', 'hours' => '--'],
                                ];
                            @endphp
                            
                            @foreach($maintenanceEmployees as $employee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center text-yellow-600 dark:text-yellow-300 font-medium">
                                            {{ substr($employee['name'], 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $employee['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $employee['id'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="department-badge department-maintenance">Maintenance</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $employee['shift'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $employee['time_in'] == '--:--' ? 'text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $employee['time_in'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $employee['time_out'] == '--:--' ? 'text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $employee['time_out'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($employee['status'] == 'late')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-late">Late</span>
                                    @elseif($employee['status'] == 'on-duty')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-on-duty">On Duty</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $employee['hours'] == '--' ? '--' : $employee['hours'] . ' hrs' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($employee['time_out'] == '--:--')
                                        <button class="time-out-btn time-btn mr-2" onclick="recordTimeOut('{{ $employee['id'] }}')">
                                            <i class="fas fa-sign-out-alt mr-1"></i>Time Out
                                        </button>
                                    @endif
                                    <button class="edit-btn time-btn" onclick="editTimeRecord('{{ $employee['id'] }}')">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                            <!-- Administration Department -->
                            <tr class="bg-green-50/30 dark:bg-green-900/20">
                                <td colspan="8" class="px-6 py-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-building text-green-600 dark:text-green-400 mr-2"></i>
                                        <span class="font-bold text-green-700 dark:text-green-300">Administration Department</span>
                                        <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">(15 employees)</span>
                                    </div>
                                </td>
                            </tr>
                            
                            @php
                                $adminEmployees = [
                                    ['id' => 'EMP-2023-301', 'name' => 'Michael Chen', 'shift' => 'Morning (7AM-3PM)', 'time_in' => '07:00 AM', 'time_out' => '03:05 PM', 'status' => 'present', 'hours' => '8.1'],
                                ];
                            @endphp
                            
                            @foreach($adminEmployees as $employee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 font-medium">
                                            {{ substr($employee['name'], 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $employee['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $employee['id'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="department-badge department-admin">Administration</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $employee['shift'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $employee['time_in'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $employee['time_out'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-present">Present</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $employee['hours'] }} hrs</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="edit-btn time-btn" onclick="editTimeRecord('{{ $employee['id'] }}')">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody> --}}
                        <tbody></tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">230</span> employees
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Previous</button>
                            <button class="px-3 py-1 bg-blue-theme text-white rounded-lg text-sm">1</button>
                            <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-700">2</button>
                            <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-700">3</button>
                            <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Time Entry -->
            <div class="card mt-8 p-6 content-fade-in stagger-delay-2">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Manual Time Entry</h3>
    
<form action="{{ route('hrm.staff.time.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Employee *</label>
                <select name="employee_id" required
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select employee...</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->name }} ({{ $employee->employee_id }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time In</label>
                <input type="time" name="time_in"
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('time_in')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time Out</label>
                <input type="time" name="time_out"
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('time_out')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Remarks (Optional)</label>
            <textarea name="remarks" rows="2"
                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Add remarks for this time entry..."></textarea>
            @error('remarks')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="resetForm()"
                class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-300 rounded-lg font-medium">
                <i class="fas fa-redo mr-2"></i>Reset
            </button>
            <button type="submit"
                class="px-6 py-2 bg-blue-theme hover:bg-blue-700 text-white rounded-lg font-medium">
                <i class="fas fa-save mr-2"></i>Save Time Entry
            </button>
        </div>
    </form>
</div>

<script>
function resetForm() {
    document.querySelector('form').reset();
    // Reset date to today
    document.querySelector('input[name="date"]').value = '{{ date("Y-m-d") }}';
}
</script>
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
            // Add any specific animations for time page
        });

        // Time tracking functions
        function recordTimeIn(employeeId) {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            
            if(confirm(`Record Time In for employee ${employeeId} at ${timeString}?`)) {
                alert(`Time In recorded for ${employeeId} at ${timeString}`);
                // In a real application, you would make an AJAX call here
            }
        }
        
        function recordTimeOut(employeeId) {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            
            if(confirm(`Record Time Out for employee ${employeeId} at ${timeString}?`)) {
                alert(`Time Out recorded for ${employeeId} at ${timeString}`);
                // In a real application, you would make an AJAX call here
            }
        }
        
        function editTimeRecord(employeeId) {
            alert(`Edit time record for employee ${employeeId}`);
            // In a real application, you would open a modal here
        }
        
        // Initialize date picker
        document.addEventListener('DOMContentLoaded', () => {
            // Set today's date in date picker
            const today = new Date().toISOString().split('T')[0];
            if (document.getElementById('date-selector')) {
                document.getElementById('date-selector').value = today;
            }
        });
    </script>
</body>
</html>