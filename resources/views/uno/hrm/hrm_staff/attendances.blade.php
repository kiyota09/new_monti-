<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Time & Attendance - Monti Textile HRM</title>

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

    <!-- Custom color overrides for blue/yellow theme -->
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
        .border-blue-theme { border-color: #2563eb; }
        .border-yellow-theme { border-color: #fbbf24; }
        .hover\:bg-blue-theme:hover { background-color: #1d4ed8; }
        .hover\:bg-yellow-theme:hover { background-color: #f59e0b; }
        .dark .bg-blue-theme { background-color: #1e40af; }
        .dark .bg-yellow-theme { background-color: #d97706; }
        .dark .text-blue-theme { color: #60a5fa; }
        .dark .text-yellow-theme { color: #fbbf24; }
        
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
        
        /* Button styles for attendance management - UPDATED */
        .attendance-btn {
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
            outline: none;
            border: 2px solid #e5e7eb;
            display: block;
            width: 100%;
            background: white;
            position: relative;
            overflow: hidden;
        }
        
        .attendance-btn:hover {
            border-color: #3b82f6;
            transform: translateY(-4px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
        }
        
        .attendance-btn:active {
            transform: translateY(-1px);
        }
        
        .attendance-btn:focus {
            outline: 3px solid rgba(59, 130, 246, 0.3);
            outline-offset: 2px;
        }
        
        .attendance-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .attendance-btn:hover::after {
            opacity: 1;
        }
        
        /* Button indicator */
        .btn-indicator {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #3b82f6;
            animation: pulse 2s infinite;
        }
        
        /* Clickable button text */
        .btn-clickable {
            display: inline-flex;
            align-items: center;
            color: #3b82f6;
            font-weight: 600;
            font-size: 0.875rem;
            margin-top: 8px;
        }
        
        .btn-clickable i {
            margin-left: 4px;
            transition: transform 0.2s ease;
        }
        
        .attendance-btn:hover .btn-clickable i {
            transform: translateX(4px);
        }
        
        .dark .attendance-btn {
            border-color: #4b5563;
            background-color: #374151;
        }
        
        .dark .attendance-btn:hover {
            border-color: #60a5fa;
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
            <p>Loading attendance management...</p>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Time & Attendance Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Employee Attendance Tracking & Schedule Management</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">5</span>
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
            <!-- Attendance Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                        <i class="fas fa-user-check text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Present Today</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">218</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center mr-4">
                        <i class="fas fa-user-times text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Absent Today</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">12</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Late Arrivals</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">8</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-percentage text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Attendance Rate</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">94.8%</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 main-grid">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Attendance Welcome Banner -->
                    <div class="featured-banner content-fade-in">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="featured-banner-content mb-6 md:mb-0">
                                    <h2 class="text-2xl font-bold mb-3 text-white">Attendance Tracking Dashboard</h2>
                                    <p class="text-blue-100 mb-6 max-w-lg">Monitor employee attendance, track working hours, and manage schedules efficiently.</p>
                                    <button class="px-6 py-3 bg-yellow-theme hover:bg-yellow-600 text-gray-900 font-semibold rounded-xl transition-colors shadow-md flex items-center featured-banner-button">
                                        Generate Attendance Report <i class="fas fa-file-export ml-2"></i>
                                    </button>
                                </div>
                                <div class="featured-banner-image animate-float">
                                    <div class="w-48 h-32 bg-gradient-to-r from-blue-400 to-blue-300 dark:from-blue-500 dark:to-blue-400 rounded-lg shadow-xl flex items-center justify-center">
                                        <i class="fas fa-clock text-white text-4xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Management Tools -->
                    <div class="card p-6 content-fade-in stagger-delay-1">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-xl text-gray-900 dark:text-white">Attendance Management</h3>
                            <a href="#" class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm">
                                All Functions <i class="fas fa-chevron-right ml-2 text-xs"></i>
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Time In & Time Out Tracking Button - UPDATED -->
                            <a href="{{ route('hrm.staff.time') }}" 
                            class="attendance-btn bg-gray-50 dark:bg-gray-700 rounded-xl p-4 relative block">
                                <div class="btn-indicator"></div>
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center">
                                        <i class="fas fa-clock text-white text-xl"></i>
                                    </div>
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium px-2 py-1 rounded">
                                        TRACKING
                                    </span>
                                </div>

                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">
                                    Time In & Time Out
                                </h4>

                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                                    Record daily attendance logs
                                </p>

                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Today's Records</span>
                                        <span class="text-blue-theme font-medium">230/250</span>
                                    </div>
                                    <div class="course-progress">
                                        <div class="course-progress-fill" style="width: 92%"></div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <span>Click to manage time tracking</span>
                                    </div>
                                    <div class="btn-clickable">
                                        Open <i class="fas fa-arrow-right text-xs ml-1"></i>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Shift Management Button - UPDATED -->
                            <a href="{{ route('hrm.staff.shift') }}" 
                            class="attendance-btn bg-gray-50 dark:bg-gray-700 rounded-xl p-4 relative block">
                                <div class="btn-indicator"></div>
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-lg bg-purple-600 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                                    </div>
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium px-2 py-1 rounded">
                                        SCHEDULE
                                    </span>
                                </div>
                                
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Shift Management</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">Employee schedules & rotations</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Schedule Compliance</span>
                                        <span class="text-blue-theme font-medium">96%</span>
                                    </div>
                                    <div class="course-progress">
                                        <div class="course-progress-fill" style="width: 96%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <span>Click to manage shifts</span>
                                    </div>
                                    <div class="btn-clickable">
                                        Open <i class="fas fa-arrow-right text-xs ml-1"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Attendance Officer Profile Card -->
                    <div class="card p-6 content-fade-in stagger-delay-2">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-4">
                                <div class="profile-image w-20 h-20 rounded-full bg-blue-theme flex items-center justify-center text-white text-2xl font-bold">
                                    TA
                                </div>
                                <div class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-blue-theme flex items-center justify-center border-2 border-white dark:border-gray-800 cursor-pointer hover:bg-blue-700">
                                    <i class="fas fa-pen text-xs text-white"></i>
                                </div>
                            </div>
                            
                            <h2 class="font-bold text-lg text-gray-900 dark:text-white">Attendance Officer</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center justify-center">
                                <i class="fas fa-building mr-1.5 text-blue-theme"></i> 
                                Operations Department
                            </p>
                            
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-5">
                                <div class="bg-blue-theme h-2.5 rounded-full" style="width: 92%"></div>
                            </div>
                            <div class="w-full flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                                <span>Data Accuracy</span>
                                <span class="text-gray-900 dark:text-white font-medium">92%</span>
                            </div>
                            
                            <a href="#" class="w-full mt-5">
                                <button class="w-full py-3 bg-blue-theme hover:bg-blue-700 text-white rounded-xl font-medium transition-colors px-4">
                                    View Today's Logs
                                </button>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Upcoming Shift Changes -->
                    <div class="card p-6 content-fade-in stagger-delay-3">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Upcoming Shift Changes</h3>
                            <a href="#" class="text-blue-theme text-sm font-medium hover:text-blue-700 dark:hover:text-blue-400">View All</a>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-exchange-alt text-green-600 dark:text-green-300"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">SHIFT ROTATION</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">Morning to Afternoon</p>
                                    </div>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Today</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-plus text-yellow-600 dark:text-yellow-300"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">OVERTIME SCHEDULE</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">Weekend Production</p>
                                    </div>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Nov 25</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                                        <i class="fas fa-user-clock text-blue-600 dark:text-blue-300"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">HOLIDAY SCHEDULE</h4>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">Christmas Season</p>
                                    </div>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Dec 24-26</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Attendance Log -->
            <div class="mt-8 content-fade-in stagger-delay-4">
                <div class="card p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white">Today's Attendance Log</h3>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">{{ now()->format('F d, Y') }}</span>
                            <a href="#" class="text-blue-theme font-medium flex items-center hover:text-blue-700 dark:hover:text-blue-400 text-sm">
                                Export Data <i class="fas fa-download ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Shift</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time In</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time Out</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hours</th>
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
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-2023-001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Morning (7AM-3PM)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">06:58 AM</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">03:05 PM</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Present
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">8.1 hrs</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-medium">
                                                MS
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Maria Santos</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-2023-045</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Afternoon (3PM-11PM)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">02:55 PM</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">--:--</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            On Duty
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">--</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 font-medium">
                                                RG
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Robert Garcia</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-2023-089</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Morning (7AM-3PM)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400">08:25 AM</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">03:10 PM</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            Late
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">6.8 hrs</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-600 dark:text-gray-300 font-medium">
                                                AP
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Ana Perez</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">EMP-2023-112</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Morning (7AM-3PM)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">--:--</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">--:--</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Absent
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">0 hrs</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Attendance Summary Charts -->
            <div class="mt-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="card p-6 content-fade-in stagger-delay-1">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-6">Weekly Attendance Trend</h3>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">94.2%</div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Average Attendance</div>
                            </div>
                            <div class="text-green-600 dark:text-green-400 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>2.1% from last week</span>
                            </div>
                        </div>
                        <div class="h-48 flex items-end space-x-2">
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-200 dark:bg-green-900 rounded-t-lg" style="height: 80%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Mon</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-300 dark:bg-green-800 rounded-t-lg" style="height: 85%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tue</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-400 dark:bg-green-700 rounded-t-lg" style="height: 92%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Wed</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-500 dark:bg-green-600 rounded-t-lg" style="height: 88%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Thu</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-600 dark:bg-green-500 rounded-t-lg" style="height: 95%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Fri</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-400 dark:bg-green-700 rounded-t-lg" style="height: 72%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Sat</div>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-300 dark:bg-green-800 rounded-t-lg" style="height: 65%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Sun</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card p-6 content-fade-in stagger-delay-2">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-6">Department Attendance Rate</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Production</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">96.5%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 96.5%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Quality Control</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">94.2%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 94.2%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Maintenance</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">92.8%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 92.8%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Administration</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">98.1%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: 98.1%"></div>
                                </div>
                            </div>
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

        document.querySelectorAll('.sidebar-item').forEach(l=>l.addEventListener('click',e=>{e.preventDefault();setTimeout(()=>window.location.href=l.getAttribute('href'),300)}));
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>