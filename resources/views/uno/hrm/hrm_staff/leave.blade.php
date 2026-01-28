<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave Request - Monti Textile HRM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
         @include('uno.hrm.hrm_staff.style')
    @endif

    <!-- Custom color overrides for blue/orange theme -->
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
        .bg-orange-theme { background-color: #f97316; }
        .bg-teal-theme { background-color: #0d9488; }
        .text-blue-theme { color: #2563eb; }
        .text-orange-theme { color: #f97316; }
        .text-teal-theme { color: #0d9488; }
        .border-blue-theme { border-color: #2563eb; }
        .border-orange-theme { border-color: #f97316; }
        .border-teal-theme { border-color: #0d9488; }
        .hover\:bg-blue-theme:hover { background-color: #1d4ed8; }
        .hover\:bg-orange-theme:hover { background-color: #ea580c; }
        .hover\:bg-teal-theme:hover { background-color: #0f766e; }
        .dark .bg-blue-theme { background-color: #1e40af; }
        .dark .bg-orange-theme { background-color: #9a3412; }
        .dark .bg-teal-theme { background-color: #115e59; }
        .dark .text-blue-theme { color: #60a5fa; }
        .dark .text-orange-theme { color: #fdba74; }
        .dark .text-teal-theme { color: #5eead4; }
        
        .input-field { 
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: border-color 0.15s ease-in-out;
        }
        .input-field:focus { 
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .dark .input-field {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        .dark .input-field:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }
        
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
            transform: translateY(-2px);
        }
        
        .course-progress {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            background-color: #e5e7eb;
        }
        
        .course-progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            transition: width 1s ease;
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
        
        .profile-image {
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .nav-tab {
            position: relative;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .nav-tab:hover {
            background-color: #f3f4f6;
        }
        
        .nav-tab.active {
            color: #3b82f6;
            font-weight: 500;
        }
        
        .nav-tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            border-radius: 3px 3px 0 0;
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .status-online {
            background-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }
        
        .status-offline {
            background-color: #94a3b8;
            box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.3);
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }
        
        .featured-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }
        
        .leave-status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .leave-status-approved {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .leave-status-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }
        
        .leave-status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Custom scrollbar */
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
        
        .dark .featured-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
        }
        
        .dark .leave-status-approved {
            background-color: #14532d;
            color: #86efac;
        }
        
        .dark .leave-status-pending {
            background-color: #713f12;
            color: #fde047;
        }
        
        .dark .leave-status-rejected {
            background-color: #7f1d1d;
            color: #fca5a5;
        }
        
        /* Responsive Design */
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
            
            .search-input {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .main-grid {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .featured-banner {
                text-align: center;
                padding: 1.5rem !important;
            }
            
            .featured-banner-content {
                padding-right: 0 !important;
            }
            
            .featured-banner img {
                display: none;
            }
            
            .instructors-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .instructors-grid {
                grid-template-columns: 1fr;
            }
            
            .header-title {
                font-size: 1.5rem;
            }
            
            .featured-banner {
                text-align: center;
            }
            
            .featured-banner-button {
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
            <p>Loading leave management content...</p>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Leave Request Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Employee Leave Applications & Approvals</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-search-toggle">
                            <i class="fas fa-search"></i>
                        </button>
                        
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">8</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900 flex items-center justify-center text-teal-700 dark:text-teal-300 font-medium hidden md:flex">
                            LR
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Leave Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900 flex items-center justify-center mr-4">
                        <i class="fas fa-hourglass-half text-orange-600 dark:text-orange-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Pending Requests</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">18</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Approved This Month</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">42</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center mr-4">
                        <i class="fas fa-times-circle text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Rejected This Month</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">7</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-day text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Leave Days</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">245</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 main-grid">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Leave Management Banner -->
                    <div class="featured-banner content-fade-in">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="featured-banner-content mb-6 md:mb-0">
                                    <h2 class="text-2xl font-bold mb-3 text-white">Leave Request Dashboard</h2>
                                    <p class="text-blue-100 mb-6 max-w-lg">Manage employee leave applications, approvals, and track leave balances efficiently.</p>
                                    <a href="{{ route('hrm.staff.LeaveRequest') }}"
                                    class="inline-flex px-6 py-3 bg-orange-theme hover:bg-orange-600 text-white font-semibold rounded-xl transition-colors shadow-md items-center featured-banner-button">
                                        View All Leave Requests <i class="fas fa-arrow-right ml-3"></i>
                                    </a>
                                </div>
                                <div class="featured-banner-image animate-float">
                                    <div class="w-48 h-32 bg-gradient-to-r from-teal-400 to-teal-300 dark:from-teal-500 dark:to-teal-400 rounded-lg shadow-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-check text-white text-4xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leave Management Tools -->
                    <div class="card p-6 content-fade-in stagger-delay-1">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-xl text-gray-900 dark:text-white">Leave Management Tools</h3>
                            <a href="#" class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm">
                                All Functions <i class="fas fa-chevron-right ml-2 text-xs"></i>
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-lg bg-orange-theme flex items-center justify-center">
                                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                                    </div>
                                    <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-medium px-2 py-1 rounded">PENDING</span>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Leave Applications</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">Review & approve requests</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Processing Rate</span>
                                        <span class="text-blue-theme font-medium">85%</span>
                                    </div>
                                    <div class="course-progress">
                                        <div class="course-progress-fill" style="width: 85%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>18 Pending</span>
                                    <span>42 Processed</span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-lg bg-teal-600 flex items-center justify-center">
                                        <i class="fas fa-chart-line text-white text-xl"></i>
                                    </div>
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium px-2 py-1 rounded">ANALYTICS</span>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Leave Analytics</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">Track leave patterns & trends</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Report Completion</span>
                                        <span class="text-blue-theme font-medium">92%</span>
                                    </div>
                                    <div class="course-progress">
                                        <div class="course-progress-fill" style="width: 92%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Monthly Reports</span>
                                    <span>Quarterly Analysis</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Leave Manager Profile Card -->
                    <div class="card p-6 content-fade-in stagger-delay-2">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-4">
                                <div class="profile-image w-20 h-20 rounded-full bg-teal-theme flex items-center justify-center text-white text-2xl font-bold">
                                    LM
                                </div>
                                <div class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-blue-theme flex items-center justify-center border-2 border-white dark:border-gray-800 cursor-pointer hover:bg-blue-700">
                                    <i class="fas fa-pen text-xs text-white"></i>
                                </div>
                            </div>
                            
                            <h2 class="font-bold text-lg text-gray-900 dark:text-white">Leave Manager</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center justify-center">
                                <i class="fas fa-building mr-1.5 text-blue-theme"></i> 
                                HR Administration
                            </p>
                            
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-5">
                                <div class="bg-teal-theme h-2.5 rounded-full" style="width: 88%"></div>
                            </div>
                            <div class="w-full flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                                <span>Approval Efficiency</span>
                                <span class="text-gray-900 dark:text-white font-medium">88%</span>
                            </div>
                            
                            <a href="#" class="w-full mt-5">
                                <button class="w-full py-3 bg-blue-theme hover:bg-blue-700 text-white rounded-xl font-medium transition-colors px-4">
                                    Process Pending Requests
                                </button>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Upcoming Leave Calendar -->
                    <div class="card p-6 content-fade-in stagger-delay-3">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Upcoming Leaves</h3>
                            <a href="#" class="text-blue-theme text-sm font-medium hover:text-blue-700 dark:hover:text-blue-400">View Calendar</a>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-umbrella-beach text-orange-600 dark:text-orange-300"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">VACATION LEAVE</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">John Dela Cruz</p>
                                    </div>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Nov 20-25</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-stethoscope text-blue-600 dark:text-blue-300"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">SICK LEAVE</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">Maria Santos</p>
                                    </div>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Nov 22-24</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-heart text-red-600 dark:text-red-300"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">MATERNITY LEAVE</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">Anna Gomez</p>
                                    </div>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Dec 1-31</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Leave Requests -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white content-fade-in">Recent Leave Requests</h3>
                    <a href="#" class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm content-fade-in stagger-delay-1">
                        View All Requests <i class="fas fa-chevron-right ml-2 text-xs"></i>
                    </a>
                </div>
                
                <div class="card p-6 content-fade-in stagger-delay-2">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Leave Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Applied Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-medium">
                                                JD
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">John Dela Cruz</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Production Dept.</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center mr-2">
                                                <i class="fas fa-umbrella-beach text-orange-600 dark:text-orange-300 text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-900 dark:text-white">Vacation</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        Nov 20 - 25, 2023<br>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">6 days</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="leave-status-badge leave-status-pending">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nov 10, 2023</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-medium">
                                                MS
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Maria Santos</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Quality Control</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-2">
                                                <i class="fas fa-stethoscope text-blue-600 dark:text-blue-300 text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-900 dark:text-white">Sick Leave</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        Nov 22 - 24, 2023<br>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">3 days</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="leave-status-badge leave-status-approved">
                                            Approved
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nov 12, 2023</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 font-medium">
                                                RG
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Robert Garcia</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Maintenance</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center mr-2">
                                                <i class="fas fa-gavel text-gray-600 dark:text-gray-300 text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-900 dark:text-white">Emergency</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        Nov 18, 2023<br>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">1 day</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="leave-status-badge leave-status-rejected">
                                            Rejected
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nov 15, 2023</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Leave Balance Summary -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white content-fade-in stagger-delay-1">Employee Leave Balance Summary</h3>
                    <a href="#" class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm content-fade-in stagger-delay-2">
                        Export Report <i class="fas fa-download ml-2"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 instructors-grid">
                    <div class="card p-5 content-fade-in stagger-delay-1">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full w-12 h-12 bg-orange-100 dark:bg-orange-900 flex items-center justify-center text-orange-600 dark:text-orange-300 text-xl mr-3">
                                <i class="fas fa-umbrella-beach"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Vacation Leave</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">15 days</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Average used: 8 days per employee
                        </div>
                    </div>
                    
                    <div class="card p-5 content-fade-in stagger-delay-2">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full w-12 h-12 bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 text-xl mr-3">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Sick Leave</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">10 days</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Average used: 3 days per employee
                        </div>
                    </div>
                    
                    <div class="card p-5 content-fade-in stagger-delay-3">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full w-12 h-12 bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 text-xl mr-3">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Maternity Leave</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">105 days</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            3 employees currently on leave
                        </div>
                    </div>
                    
                    <div class="card p-5 content-fade-in stagger-delay-4">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full w-12 h-12 bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-600 dark:text-gray-300 text-xl mr-3">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Emergency Leave</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">5 days</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Used 12 times this quarter
                        </div>
                    </div>
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
            const progressBars = document.querySelectorAll('.course-progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });

        // Leave request actions
        document.addEventListener('DOMContentLoaded', () => {
            // Approve button functionality
            document.querySelectorAll('button').forEach(button => {
                if (button.textContent.includes('Approve')) {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const statusCell = row.querySelector('.leave-status-badge');
                        statusCell.textContent = 'Approved';
                        statusCell.className = 'leave-status-badge leave-status-approved';
                        
                        // Show success message
                        showToast('Leave request approved successfully!', 'success');
                    });
                }
                
                if (button.textContent.includes('Reject')) {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const statusCell = row.querySelector('.leave-status-badge');
                        statusCell.textContent = 'Rejected';
                        statusCell.className = 'leave-status-badge leave-status-rejected';
                        
                        // Show success message
                        showToast('Leave request rejected.', 'info');
                    });
                }
            });
        });
        
        function showToast(message, type) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${
                type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
            }`;
            toast.textContent = message;
            
            // Add to DOM
            document.body.appendChild(toast);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
        // Add Font Awesome JS
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.querySelector('script[src*="font-awesome"]')) {
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js';
                document.head.appendChild(script);
            }
        });
    </script>
</body>
</html>