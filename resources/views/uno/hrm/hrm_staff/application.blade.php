<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application Management - Monti Textile HRM</title>

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

    <!-- Custom Styles (from dashboard) -->
    <style>
        /* Content Loading Overlay */
        .content-loading-overlay {
            position: fixed;
            top: 0;
            left: 260px;
            /* Sidebar width */
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
        .sidebar.collapsed~.content-loading-overlay {
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
            to {
                transform: rotate(360deg);
            }
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
        .stagger-delay-1 {
            animation-delay: 0.1s;
        }

        .stagger-delay-2 {
            animation-delay: 0.2s;
        }

        .stagger-delay-3 {
            animation-delay: 0.3s;
        }

        .stagger-delay-4 {
            animation-delay: 0.4s;
        }

        .stagger-delay-5 {
            animation-delay: 0.5s;
        }

        .bg-blue-theme {
            background-color: #2563eb;
        }

        .bg-yellow-theme {
            background-color: #fbbf24;
        }

        .text-blue-theme {
            color: #2563eb;
        }

        .text-yellow-theme {
            color: #fbbf24;
        }

        .border-blue-theme {
            border-color: #2563eb;
        }

        .border-yellow-theme {
            border-color: #fbbf24;
        }

        .hover\:bg-blue-theme:hover {
            background-color: #1d4ed8;
        }

        .hover\:bg-yellow-theme:hover {
            background-color: #f59e0b;
        }

        .dark .bg-blue-theme {
            background-color: #1e40af;
        }

        .dark .bg-yellow-theme {
            background-color: #d97706;
        }

        .dark .text-blue-theme {
            color: #60a5fa;
        }

        .dark .text-yellow-theme {
            color: #fbbf24;
        }

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

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
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

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table th {
            background-color: #f9fafb;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .dark .data-table th {
            background-color: #374151;
            color: #f9fafb;
            border-bottom-color: #4b5563;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .data-table td {
            border-bottom-color: #4b5563;
        }

        .data-table tr:hover {
            background-color: #f9fafb;
        }

        .dark .data-table tr:hover {
            background-color: #374151;
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .dark .badge-success {
            background-color: #064e3b;
            color: #a7f3d0;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .dark .badge-warning {
            background-color: #78350f;
            color: #fcd34d;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .dark .badge-danger {
            background-color: #7f1d1d;
            color: #fca5a5;
        }

        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .dark .badge-info {
            background-color: #1e3a8a;
            color: #93c5fd;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .btn-outline {
            background-color: transparent;
            border-color: #d1d5db;
            color: #374151;
        }

        .dark .btn-outline {
            border-color: #4b5563;
            color: #f9fafb;
        }

        .btn-outline:hover {
            background-color: #f3f4f6;
        }

        .dark .btn-outline:hover {
            background-color: #374151;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .dark .form-label {
            color: #f9fafb;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background-color: white;
            transition: border-color 0.15s ease-in-out;
        }

        .dark .form-control {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .dark .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }

        /* Department Tag Styles */
        .department-tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin: 2px;
        }

        .department-production {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .department-quality {
            background-color: #dcfce7;
            color: #166534;
        }

        .department-maintenance {
            background-color: #fef3c7;
            color: #92400e;
        }

        .department-admin {
            background-color: #f3e8ff;
            color: #6b21a8;
        }

        .department-logistics {
            background-color: #fce7f3;
            color: #9d174d;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1001;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .dark .modal-content {
            background-color: #374151;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dark .modal-header {
            border-bottom-color: #4b5563;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .monti-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 3px solid #fbbf24;
        }

        /* Scrollbar Styling */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Focus styles */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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

            .data-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
    #calendar {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .fc-day-today {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
    
    .fc-event {
        cursor: pointer;
    }
    
    .fc-event-interview {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    
    .fc-event-interview:hover {
        background-color: #4338ca;
        border-color: #4338ca;
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
            <p>Loading application management...</p>
        </div>
        <div class="loading-progress-bar">
            <div id="loading-progress-fill" class="loading-progress-fill"></div>
        </div>
    </div>

    <!-- Main Content (Initially hidden) -->
    <div class="main-content flex-1 ml-64 min-h-screen flex flex-col hidden" id="main-content">
        <!-- Top Header -->
        <header
            class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4 px-8 flex items-center justify-between sticky top-0 z-10 content-fade-in">
            <div class="header-content flex items-center justify-between w-full">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Application Management
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Manage job applications and recruitment
                        process</p>
                </div>

                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button
                            class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300"
                            id="mobile-search-toggle">
                            <i class="fas fa-search"></i>
                        </button>

                        <button
                            class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>

                        <button
                            class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300"
                            id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>

                        <div
                            class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-medium hidden md:flex">
                            HR
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Status Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Applications</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalApplicants }}</div>
                    </div>
                </div>

                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div
                        class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Pending Review</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalPending }}</div>
                    </div>
                </div>

                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-check text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Scheduled Interviews</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalScheduled }}</div>
                    </div>
                </div>

                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center mr-4">
                        <i class="fas fa-times-circle text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Rejected</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalRejected }}</div>
                    </div>
                </div>
            </div>


            <!-- Applications Table -->
            <div class="card overflow-hidden mb-8 content-fade-in stagger-delay-1">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Job Applications</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Recent applications for various positions</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Position Applied</th>
                                <th>Date Applied</th>
                                <th>Status</th>
                                <th>Contact Info</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applicants as $applicant)
                                <tr>
                                    <td>
                                        <div class="flex items-center">
                                            @php
                                                // Generate initials
                                                $initials = strtoupper(substr($applicant->first_name, 0, 1));
                                                if ($applicant->last_name) {
                                                    $initials .= strtoupper(substr($applicant->last_name, 0, 1));
                                                }

                                                // Generate avatar color based on name
                                                $colors = [
                                                    'blue',
                                                    'green',
                                                    'red',
                                                    'purple',
                                                    'yellow',
                                                    'indigo',
                                                    'pink',
                                                    'gray',
                                                    'orange',
                                                    'teal',
                                                ];
                                                $nameHash = crc32($applicant->first_name . $applicant->last_name);
                                                $color = $colors[$nameHash % count($colors)];
                                            @endphp
                                            <div
                                                class="w-10 h-10 rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900 flex items-center justify-center text-{{ $color }}-600 dark:text-{{ $color }}-300 font-bold mr-3">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-black dark:text-dark">
                                                    {{ $applicant->first_name }}
                                                    {{ $applicant->middle_name ? $applicant->middle_name . ' ' : '' }}{{ $applicant->last_name }}
                                                </div>
                                                <div class="text-black-500 dark:text-gray-400 text-sm">
                                                    Applied: {{ $applicant->created_at->format('Y-m-d') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            // Map position values to display names
                                            $positions = [
                                                'production_supervisor' => 'Production Supervisor',
                                                'quality_inspector' => 'Quality Control Inspector',
                                                'maintenance_tech' => 'Maintenance Technician',
                                                'hr_assistant' => 'HR Assistant',
                                                'warehouse_staff' => 'Warehouse Staff',
                                                'machine_operator' => 'Machine Operator',
                                            ];

                                            $departments = [
                                                'production_supervisor' => 'Production Department',
                                                'quality_inspector' => 'Quality Department',
                                                'maintenance_tech' => 'Maintenance Department',
                                                'hr_assistant' => 'Administration',
                                                'warehouse_staff' => 'Logistics Department',
                                                'machine_operator' => 'Production Department',
                                            ];
                                        @endphp
                                        <div class="font-medium text-black-500 dark:text-gray-400">
                                            {{ $positions[$applicant->position_applied] ?? ucwords(str_replace('_', ' ', $applicant->position_applied)) }}
                                        </div>
                                        <div class="text-black-500 dark:text-gray-400 text-sm">
                                            {{ $departments[$applicant->position_applied] ?? 'General' }}</div>
                                    </td>
                                    <td class="text-black-500 dark:text-gray-400">
                                        {{ $applicant->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @php
                                            // Status mapping
                                            $statusConfig = [
                                                'pending' => [
                                                    'class' => 'badge-warning',
                                                    'icon' => 'fa-clock',
                                                    'text' => 'Pending Review',
                                                ],
                                                'reviewed' => [
                                                    'class' => 'badge-info',
                                                    'icon' => 'fa-eye',
                                                    'text' => 'Reviewed',
                                                ],
                                                'interview_scheduled' => [
                                                    'class' => 'badge-info',
                                                    'icon' => 'fa-calendar-check',
                                                    'text' => 'Interview Scheduled',
                                                ],
                                                'interviewed' => [
                                                    'class' => 'badge-primary',
                                                    'icon' => 'fa-user-check',
                                                    'text' => 'Interviewed',
                                                ],
                                                'shortlisted' => [
                                                    'class' => 'badge-success',
                                                    'icon' => 'fa-star',
                                                    'text' => 'Shortlisted',
                                                ],
                                                'rejected' => [
                                                    'class' => 'badge-danger',
                                                    'icon' => 'fa-times-circle',
                                                    'text' => 'Rejected',
                                                ],
                                            
                                            ];

                                            $status = $applicant->status ?? 'pending';
                                            $config = $statusConfig[$status] ?? [
                                                'class' => 'badge-secondary',
                                                'icon' => 'fa-question-circle',
                                                'text' => ucfirst($status),
                                            ];
                                        @endphp
                                        <span class="badge {{ $config['class'] }}">
                                            <i class="fas {{ $config['icon'] }} text-xs mr-1"></i>
                                            {{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <div class="text-dark-900 dark:text-white">{{ $applicant->email }}</div>
                                            <div class="text-gray-500 dark:text-gray-400">{{ $applicant->phone }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <div class="flex space-x-2">
                                            @if ($status === 'pending')
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="interview_scheduled">
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        {{-- onclick="return confirm('Schedule interview for {{ $applicant->first_name }} {{ $applicant->last_name }}?')"--}}> 
                                                        <i class="fas fa-calendar-alt mr-1"></i> Schedule
                                                    </button>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        {{-- onclick="return confirm('Reject {{ $applicant->first_name }} {{ $applicant->last_name }}?')" --}}
                                                        >
                                                        <i class="fas fa-times mr-1"></i> Reject
                                                    </button>
                                                </form>
                                            @elseif($status === 'interview_scheduled')
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="interviewed">
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-calendar-edit mr-1"></i> Mark Interviewed
                                                    </button>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant->id) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="hired">
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        {{-- onclick="return confirm('Hire {{ $applicant->first_name }} {{ $applicant->last_name }}?')" --}}
                                                        >
                                                        <i class="fas fa-check mr-1"></i> Hire
                                                    </button>
                                                </form>
                                            @elseif($status === 'rejected')
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="btn btn-outline btn-sm">
                                                        <i class="fas fa-redo mr-1"></i> Reconsider
                                                    </button>
                                                </form>
                                            @elseif($status === 'hired')
                                                <button class="btn btn-primary btn-sm"
                                                    {{-- onclick="viewOfferLetter({{ $applicant->id }})" --}}
                                                    >
                                                    <i class="fas fa-file-contract mr-1"></i> Offer Letter
                                                </button>
                                            @elseif($status === 'interviewed')
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('applicants.update-status', $applicant) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times mr-1"></i> Reject
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('applicants.show', $applicant) }}"
                                                class="btn btn-outline btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <form method="POST"
                                                action="{{ route('applicants.destroy', $applicant) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm text-red-600"
                                                    {{-- onclick="return confirm('Delete {{ $applicant->first_name }} {{ $applicant->last_name }}?') "--}}
                                                    >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-users text-4xl mb-4"></i>
                                        <p class="text-lg">No applicants found</p>
                                        <p class="text-sm mt-2">Start by adding new applicants</p>
                                    </td>
                                </tr>
                        
                            <!-- Calendar Modal -->
                            <div id="calendarModal" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Schedule Interview</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="calendarContainer">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div id="calendar" style="min-height: 400px;"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h6 class="card-title">Interview Details</h6>
                                                                <form id="interviewForm">
                                                                    <input type="hidden" id="applicantId" name="applicant_id">
                                                                    <input type="hidden" id="selectedDate" name="interview_date">
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="applicantName" class="form-label">Applicant</label>
                                                                        <input type="text" class="form-control" id="applicantName" readonly>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="interviewTime" class="form-label">Time</label>
                                                                        <input type="time" class="form-control" id="interviewTime" name="interview_time" required>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="interviewType" class="form-label">Interview Type</label>
                                                                        <select class="form-control" id="interviewType" name="interview_type" required>
                                                                            <option value="phone">Phone Interview</option>
                                                                            <option value="video">Video Interview</option>
                                                                            <option value="in_person">In-Person Interview</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="interviewers" class="form-label">Interviewers (comma-separated)</label>
                                                                        <input type="text" class="form-control" id="interviewers" name="interviewers" placeholder="e.g., John Doe, Jane Smith">
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="notes" class="form-label">Notes</label>
                                                                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                                    </div>
                                                                    
                                                                    <div class="d-grid">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="fas fa-calendar-plus mr-1"></i> Schedule Interview
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">
                        Showing 0 entries
                    </div>
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            Previous
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg">1</button>
                        <button
                            class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            Next
                        </button>
                    </div>
                </div>
            </div>

            <!-- Application Status Chart -->
            <div class="card p-6 content-fade-in stagger-delay-2">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Application Status Overview</h2>
                <div class="flex items-center justify-center h-64">
                    <div class="text-center">
                        <div class="text-gray-500 dark:text-gray-400 mb-4">No data available</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Applications will appear here once added
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Encode Applicant Modal -->
    <div class="modal fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4 z-50 hidden"
        id="encode-applicant-modal">
        <div class="modal-content bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <!-- Modal Header with Monti Textile Branding -->
            <div
                class="modal-header monti-header bg-gradient-to-r from-white to-blue-50 p-6 rounded-t-xl border-b border-blue-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-industry text-yellow-600 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Monti Textile</h2>
                            <h3 class="text-lg font-semibold text-blue-700">Encode New Applicant</h3>
                        </div>
                    </div>
                    <button class="text-gray-500 hover:text-red-500 opacity-0 transition-colors duration-200"
                        id="close-modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>


            <div class="max-w-6xl mx-auto">
                <form id="applicant-form" method="POST" action="{{ route('applicants.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-2xl font-bold text-gray-800">New Applicant Form</h2>
                            <p class="text-gray-600 mt-1">Fill in the details below to add a new applicant</p>
                        </div>

                        <!-- Personal Information -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Full Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <input type="text" name="first_name" placeholder="First Name" required
                                                value="{{ old('first_name') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        </div>
                                        <div>
                                            <input type="text" name="middle_name"
                                                placeholder="Middle Name (Optional)" value="{{ old('middle_name') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        </div>
                                        <div>
                                            <input type="text" name="last_name" placeholder="Last Name" required
                                                value="{{ old('last_name') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        </div>
                                    </div>
                                </div>

                                <!-- Birth Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <select name="birth_month" required
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="">Month</option>
                                                @foreach (range(1, 12) as $m)
                                                    <option value="{{ $m }}"
                                                        {{ old('birth_month') == $m ? 'selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $m)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <select name="birth_day" required
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="">Day</option>
                                                @foreach (range(1, 31) as $d)
                                                    <option value="{{ $d }}"
                                                        {{ old('birth_day') == $d ? 'selected' : '' }}>
                                                        {{ $d }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <select name="birth_year" required
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="">Year</option>
                                                @for ($y = now()->year; $y >= 1960; $y--)
                                                    <option value="{{ $y }}"
                                                        {{ old('birth_year') == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <div class="space-y-4">
                                        <input type="text" name="street_address" placeholder="Street Address"
                                            required value="{{ old('street_address') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                        <input type="text" name="street_address_2"
                                            placeholder="Apartment, Suite, etc. (Optional)"
                                            value="{{ old('street_address_2') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <input type="text" name="city" placeholder="City" required
                                                value="{{ old('city') }}"
                                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                            <input type="text" name="state" placeholder="State / Province"
                                                required value="{{ old('state') }}"
                                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                            <input type="text" name="postal_code" placeholder="Postal Code"
                                                required value="{{ old('postal_code') }}"
                                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Position Information -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Contact & Position Details</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Contact Information -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact
                                        Information</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <input type="email" name="email" placeholder="Email Address" required
                                                value="{{ old('email') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        </div>
                                        <div>
                                            <input type="tel" name="phone" placeholder="Phone Number" required
                                                value="{{ old('phone') }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <input type="url" name="linkedin"
                                            placeholder="LinkedIn Profile URL (Optional)"
                                            value="{{ old('linkedin') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>
                                </div>

                                <!-- Position Details -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Position
                                        Details</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <select name="position_applied" required
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="">Select Position</option>
                                                <option value="production_supervisor"
                                                    {{ old('position_applied') == 'production_supervisor' ? 'selected' : '' }}>
                                                    Production Supervisor</option>
                                                <option value="quality_inspector"
                                                    {{ old('position_applied') == 'quality_inspector' ? 'selected' : '' }}>
                                                    Quality Inspector</option>
                                                <option value="maintenance_tech"
                                                    {{ old('position_applied') == 'maintenance_tech' ? 'selected' : '' }}>
                                                    Maintenance Technician</option>
                                                <option value="hr_assistant"
                                                    {{ old('position_applied') == 'hr_assistant' ? 'selected' : '' }}>
                                                    HR Assistant</option>
                                                <option value="warehouse_staff"
                                                    {{ old('position_applied') == 'warehouse_staff' ? 'selected' : '' }}>
                                                    Warehouse Staff</option>
                                                <option value="machine_operator"
                                                    {{ old('position_applied') == 'machine_operator' ? 'selected' : '' }}>
                                                    Machine Operator</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select name="source" required
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <option value="">How did you hear about us?</option>
                                                <option value="linkedin"
                                                    {{ old('source') == 'linkedin' ? 'selected' : '' }}>LinkedIn
                                                </option>
                                                <option value="job_portal"
                                                    {{ old('source') == 'job_portal' ? 'selected' : '' }}>Job Portal
                                                </option>
                                                <option value="referral"
                                                    {{ old('source') == 'referral' ? 'selected' : '' }}>Referral
                                                </option>
                                                <option value="social_media"
                                                    {{ old('source') == 'social_media' ? 'selected' : '' }}>Social
                                                    Media</option>
                                                <option value="company_website"
                                                    {{ old('source') == 'company_website' ? 'selected' : '' }}>Company
                                                    Website</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Available Start
                                            Date</label>
                                        <input type="date" name="available_start_date" required
                                            value="{{ old('available_start_date') }}"
                                            class="w-full md:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Required Documents</h3>
                            </div>

                            <div class="space-y-6">
                                {{-- <!-- Resume -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Resume / CV <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 hover:bg-blue-50 transition">
                            <div class="text-center">
                                <i class="fas fa-file-pdf text-3xl text-blue-400 mb-3"></i>
                                <p class="text-gray-600 mb-3">Upload your resume (PDF, DOC, DOCX)</p>
                                <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" required
                                    class="w-full max-w-xs mx-auto file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-gray-400 text-sm mt-3">Maximum file size: 5MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cover Letter (Optional)</label>
                        <textarea name="cover_letter" rows="4" placeholder="Write your cover letter here..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('cover_letter') }}</textarea>
                    </div> --}}

                                <!-- Government Documents -->
                                <div>
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="h-8 w-8 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-id-card text-white text-sm"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800">Government Documents (Optional)
                                        </h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- SSS -->
                                        <div
                                            class="border border-gray-200 rounded-xl p-4 hover:border-blue-400 hover:shadow-sm transition">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">SSS ID</label>
                                            <input type="file" name="sss_document" id="sss_document"
                                                accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                                            <div class="text-center">
                                                <i class="fas fa-landmark text-2xl text-gray-400 mb-2"></i>
                                                <p class="text-gray-500 text-sm mb-3">Upload SSS document</p>
                                                <button type="button"
                                                    onclick="document.getElementById('sss_document').click()"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                                                    <i class="fas fa-upload mr-1.5"></i> Upload
                                                </button>
                                                <p id="sss_file_name" class="text-xs text-green-600 mt-2 truncate">
                                                </p>
                                            </div>
                                        </div>

                                        <!-- PhilHealth -->
                                        <div
                                            class="border border-gray-200 rounded-xl p-4 hover:border-blue-400 hover:shadow-sm transition">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">PhilHealth
                                                ID</label>
                                            <input type="file" name="philhealth_document" id="philhealth_document"
                                                accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                                            <div class="text-center">
                                                <i class="fas fa-heartbeat text-2xl text-gray-400 mb-2"></i>
                                                <p class="text-gray-500 text-sm mb-3">Upload PhilHealth document</p>
                                                <button type="button"
                                                    onclick="document.getElementById('philhealth_document').click()"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                                                    <i class="fas fa-upload mr-1.5"></i> Upload
                                                </button>
                                                <p id="philhealth_file_name"
                                                    class="text-xs text-green-600 mt-2 truncate"></p>
                                            </div>
                                        </div>

                                        <!-- Pag-IBIG -->
                                        <div
                                            class="border border-gray-200 rounded-xl p-4 hover:border-blue-400 hover:shadow-sm transition">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">Pag-IBIG
                                                ID</label>
                                            <input type="file" name="pagibig_document" id="pagibig_document"
                                                accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                                            <div class="text-center">
                                                <i class="fas fa-home text-2xl text-gray-400 mb-2"></i>
                                                <p class="text-gray-500 text-sm mb-3">Upload Pag-IBIG document</p>
                                                <button type="button"
                                                    onclick="document.getElementById('pagibig_document').click()"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                                                    <i class="fas fa-upload mr-1.5"></i> Upload
                                                </button>
                                                <p id="pagibig_file_name"
                                                    class="text-xs text-green-600 mt-2 truncate"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-400 text-xs mt-4 text-center">Supported formats: PDF, JPG, PNG
                                        | Max size: 5MB each</p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Additional Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Expected Salary -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Expected Salary
                                        (Optional)</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">₱</span>
                                        </div>
                                        <input type="text" name="expected_salary" placeholder="e.g., 25,000"
                                            value="{{ old('expected_salary') }}"
                                            class="pl-8 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>
                                </div>

                                <!-- Notice Period -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notice Period
                                        (Optional)</label>
                                    <select name="notice_period"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option value="">Select notice period</option>
                                        <option value="immediate"
                                            {{ old('notice_period') == 'immediate' ? 'selected' : '' }}>Immediate
                                        </option>
                                        <option value="1_week"
                                            {{ old('notice_period') == '1_week' ? 'selected' : '' }}>1 Week</option>
                                        <option value="2_weeks"
                                            {{ old('notice_period') == '2_weeks' ? 'selected' : '' }}>2 Weeks</option>
                                        <option value="1_month"
                                            {{ old('notice_period') == '1_month' ? 'selected' : '' }}>1 Month</option>
                                    </select>
                                </div>

                                <!-- Experience -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Relevant
                                        Experience</label>
                                    <div class="flex space-x-6">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="experience" value="yes"
                                                {{ old('experience') == 'yes' ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-gray-700">Yes, I have relevant experience</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="experience" value="no"
                                                {{ old('experience') == 'no' ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-gray-700">No experience yet</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center">
                                <div class="mb-4 sm:mb-0">
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-exclamation-circle text-gray-400 mr-1"></i>
                                        Fields marked with <span class="text-red-500">*</span> are required
                                    </p>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" onclick="window.history.back()"
                                        class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm">
                                        <i class="fas fa-save mr-2"></i> Save Applicant
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- JavaScript for file upload display -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Function to handle file input display
                        function setupFileInput(fileInputId, displayId) {
                            const fileInput = document.getElementById(fileInputId);
                            const display = document.getElementById(displayId);

                            if (fileInput && display) {
                                fileInput.addEventListener('change', function(e) {
                                    if (this.files && this.files[0]) {
                                        display.textContent = this.files[0].name;
                                        display.classList.remove('hidden');
                                    } else {
                                        display.classList.add('hidden');
                                        display.textContent = '';
                                    }
                                });
                            }
                        }

                        // Setup all file inputs
                        setupFileInput('resume', 'resume_file_name');
                        setupFileInput('sss_document', 'sss_file_name');
                        setupFileInput('philhealth_document', 'philhealth_file_name');
                        setupFileInput('pagibig_document', 'pagibig_file_name');

                        // Add today's date as default for available start date
                        const startDateInput = document.querySelector('input[name="available_start_date"]');
                        if (startDateInput && !startDateInput.value) {
                            const today = new Date().toISOString().split('T')[0];
                            startDateInput.value = today;
                        }

                        // Form validation enhancement
                        const form = document.getElementById('applicant-form');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                const requiredFields = form.querySelectorAll('[required]');
                                let isValid = true;

                                requiredFields.forEach(field => {
                                    if (!field.value.trim()) {
                                        field.classList.add('border-red-300', 'bg-red-50');
                                        isValid = false;
                                    } else {
                                        field.classList.remove('border-red-300', 'bg-red-50');
                                    }
                                });

                                if (!isValid) {
                                    e.preventDefault();
                                    // Scroll to first error
                                    const firstError = form.querySelector('.border-red-300');
                                    if (firstError) {
                                        firstError.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'center'
                                        });
                                        firstError.focus();
                                    }
                                }
                            });
                        }
                    });
                </script>

                <style>
                    /* Custom scrollbar for textareas */
                    textarea {
                        scrollbar-width: thin;
                        scrollbar-color: #cbd5e0 #f7fafc;
                    }

                    textarea::-webkit-scrollbar {
                        width: 8px;
                    }

                    textarea::-webkit-scrollbar-track {
                        background: #f7fafc;
                        border-radius: 4px;
                    }

                    textarea::-webkit-scrollbar-thumb {
                        background-color: #cbd5e0;
                        border-radius: 4px;
                    }

                    /* File input styling */
                    input[type="file"]::file-selector-button {
                        border: none;
                        background: linear-gradient(to right, #3b82f6, #2563eb);
                        color: white;
                        padding: 0.5rem 1rem;
                        border-radius: 9999px;
                        cursor: pointer;
                        transition: all 0.2s;
                    }

                    input[type="file"]::file-selector-button:hover {
                        background: linear-gradient(to right, #2563eb, #1d4ed8);
                    }

                    /* Focus styles */
                    input:focus,
                    select:focus,
                    textarea:focus {
                        outline: none;
                        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                    }

                    /* Smooth transitions */
                    input,
                    select,
                    textarea,
                    button {
                        transition: all 0.2s ease-in-out;
                    }

                    /* Hover effects */
                    .hover-lift:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }
                </style>
            </div>
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

            // Modal functionality
            const encodeBtn = document.getElementById('encode-applicant-btn');
            const modal = document.getElementById('encode-applicant-modal');
            const closeModal = document.getElementById('close-modal');
            const cancelForm = document.getElementById('cancel-form');
            const applicantForm = document.getElementById('applicant-form');

            // Create encode button if not exists in DOM
            if (!encodeBtn) {
                const newEncodeBtn = document.createElement('button');
                newEncodeBtn.className = 'btn btn-primary';
                newEncodeBtn.id = 'encode-applicant-btn';
                newEncodeBtn.innerHTML = '<i class="fas fa-plus mr-2"></i> Encode New Applicant';
                document.querySelector('.header-actions .flex').prepend(newEncodeBtn);
            }

            const encodeBtnElement = document.getElementById('encode-applicant-btn');

            encodeBtnElement.addEventListener('click', () => {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            closeModal.addEventListener('click', () => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });

            cancelForm.addEventListener('click', () => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });

            // Close modal when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Form submission
            applicantForm.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Applicant information saved successfully!');
                modal.classList.remove('active');
                document.body.style.overflow = '';
                applicantForm.reset();
            });

            // Action functions
            function scheduleInterview(id) {
                if (confirm('Schedule interview for this applicant?')) {
                    alert(`Interview scheduled for applicant #${id}`);
                    // Update UI here - call backend API
                }
            }

            function rejectApplication(id) {
                if (confirm('Reject this application?')) {
                    alert(`Application #${id} rejected`);
                    // Update UI here - call backend API
                }
            }

            document.querySelectorAll('.sidebar-item').forEach(l => l.addEventListener('click', e => {
                e.preventDefault();
                setTimeout(() => window.location.href = l.getAttribute('href'), 300)
            }));
        </script>
</body>

</html>
