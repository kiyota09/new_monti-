<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schedule Training - Monti Textile HRM</title>

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

    <!-- Custom color overrides for blue/purple theme -->
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
        .bg-purple-theme { background-color: #7c3aed; }
        .bg-indigo-theme { background-color: #4f46e5; }
        .text-blue-theme { color: #2563eb; }
        .text-purple-theme { color: #7c3aed; }
        .text-indigo-theme { color: #4f46e5; }
        .border-blue-theme { border-color: #2563eb; }
        .border-purple-theme { border-color: #7c3aed; }
        .border-indigo-theme { border-color: #4f46e5; }
        .hover\:bg-blue-theme:hover { background-color: #1d4ed8; }
        .hover\:bg-purple-theme:hover { background-color: #6d28d9; }
        .hover\:bg-indigo-theme:hover { background-color: #4338ca; }
        .dark .bg-blue-theme { background-color: #1e40af; }
        .dark .bg-purple-theme { background-color: #5b21b6; }
        .dark .bg-indigo-theme { background-color: #3730a3; }
        .dark .text-blue-theme { color: #60a5fa; }
        .dark .text-purple-theme { color: #a78bfa; }
        .dark .text-indigo-theme { color: #818cf8; }
        
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
        
        .training-status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .training-status-completed {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .training-status-ongoing {
            background-color: #fef9c3;
            color: #854d0e;
        }
        
        .training-status-upcoming {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .training-status-expired {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .certification-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .certification-valid {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .certification-expired {
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
        
        .dark .training-status-completed {
            background-color: #14532d;
            color: #86efac;
        }
        
        .dark .training-status-ongoing {
            background-color: #713f12;
            color: #fde047;
        }
        
        .dark .training-status-upcoming {
            background-color: #1e3a8a;
            color: #93c5fd;
        }
        
        .dark .training-status-expired {
            background-color: #7f1d1d;
            color: #fca5a5;
        }
        
        .dark .certification-valid {
            background-color: #14532d;
            color: #86efac;
        }
        
        .dark .certification-expired {
            background-color: #7f1d1d;
            color: #fca5a5;
        }
        
        /* New Styles for Training Schedule Page */
        .applicant-status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .applicant-status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .applicant-status-in-training {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .applicant-status-evaluating {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .applicant-status-approved {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .applicant-status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .applicant-status-on-hold {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        
        .department-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }
        
        .department-production {
            background-color: #3b82f6;
            color: white;
        }
        
        .department-quality {
            background-color: #8b5cf6;
            color: white;
        }
        
        .department-maintenance {
            background-color: #10b981;
            color: white;
        }
        
        .department-warehouse {
            background-color: #f59e0b;
            color: white;
        }
        
        .department-admin {
            background-color: #ef4444;
            color: white;
        }
        
        .department-hr {
            background-color: #ec4899;
            color: white;
        }
        
        .progress-tracker {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 1.5rem 0;
        }
        
        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            width: 100px;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .step-icon.completed {
            background-color: #10b981;
            color: white;
        }
        
        .step-icon.current {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }
        
        .step-icon.pending {
            background-color: #e5e7eb;
            color: #6b7280;
        }
        
        .progress-line {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 2px;
            background-color: #e5e7eb;
            z-index: 0;
        }
        
        .progress-line-fill {
            height: 100%;
            background-color: #10b981;
            transition: width 0.5s ease;
        }
        
        .evaluation-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .evaluation-card.passed {
            border-left-color: #10b981;
        }
        
        .evaluation-card.failed {
            border-left-color: #ef4444;
        }
        
        .evaluation-card.pending {
            border-left-color: #f59e0b;
        }
        
        .skill-meter {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
            overflow: hidden;
            margin-top: 0.5rem;
        }
        
        .skill-meter-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        
        .skill-meter-fill.excellent {
            background-color: #10b981;
        }
        
        .skill-meter-fill.good {
            background-color: #3b82f6;
        }
        
        .skill-meter-fill.average {
            background-color: #f59e0b;
        }
        
        .skill-meter-fill.poor {
            background-color: #ef4444;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-overlay.active {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease;
        }
        
        .dark .modal-content {
            background-color: #374151;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .filter-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
        }
        
        .filter-pill.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        .dark .filter-pill {
            border-color: #4b5563;
        }
        
        .dark .filter-pill.active {
            background-color: #2563eb;
            border-color: #2563eb;
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
            
            .progress-tracker {
                overflow-x: auto;
                padding-bottom: 1rem;
            }
            
            .progress-step {
                min-width: 80px;
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
            
            .filter-pills-container {
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }
            
            .filter-pills {
                display: flex;
                flex-wrap: nowrap;
                gap: 0.5rem;
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
            <p>Loading training schedule...</p>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Schedule New Training</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Manage newly hired applicants & track their training progress</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-search-toggle">
                            <i class="fas fa-search"></i>
                        </button>
                        
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">0</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-medium hidden md:flex">
                            HR
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Training Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-4">
                        <i class="fas fa-user-plus text-purple-600 dark:text-purple-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">New Applicants</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white" id="new-applicants-count">0</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                        <i class="fas fa-user-graduate text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">In Training</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white" id="in-training-count">0</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Approved</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white" id="approved-count">0</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                        <i class="fas fa-hourglass-half text-yellow-600 dark:text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Pending Review</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white" id="pending-review-count">0</div>
                    </div>
                </div>
            </div>

            <!-- Department Filter & Actions -->
            <div class="card p-6 mb-8 content-fade-in stagger-delay-1">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <div>
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-2">Newly Hired Applicants by Department</h3>
                        <p class="text-gray-500 dark:text-gray-400">Track training progress and make placement decisions</p>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button id="add-applicant-btn" class="px-4 py-2.5 bg-blue-theme hover:bg-blue-700 text-white rounded-xl font-medium transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add Applicant
                        </button>
                        <button id="export-btn" class="px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center">
                            <i class="fas fa-download mr-2"></i> Export
                        </button>
                    </div>
                </div>
                
                <!-- Department Filter Pills -->
                <div class="mb-6">
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Filter by Department:</div>
                    <div class="filter-pills-container">
                        <div class="filter-pills flex flex-wrap gap-2">
                            <div class="filter-pill active" data-department="all">All Departments (0)</div>
                            <div class="filter-pill" data-department="production">Production (0)</div>
                            <div class="filter-pill" data-department="quality">Quality Control (0)</div>
                            <div class="filter-pill" data-department="maintenance">Maintenance (0)</div>
                            <div class="filter-pill" data-department="warehouse">Warehouse (0)</div>
                            <div class="filter-pill" data-department="admin">Administration (0)</div>
                        </div>
                    </div>
                </div>
                
                <!-- Search and Status Filter -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="applicant-search" placeholder="Search applicants by name or ID..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <select id="status-filter" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="pending">Pending Training</option>
                            <option value="in-training">In Training</option>
                            <option value="evaluating">Under Evaluation</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Applicants Table -->
            <div class="mb-8 content-fade-in stagger-delay-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white">Applicant Training Records</h3>
                    <div class="text-sm text-gray-500 dark:text-gray-400" id="applicant-count-info">
                        Showing <span class="font-medium text-gray-900 dark:text-white">0</span> of <span class="font-medium text-gray-900 dark:text-white">0</span> applicants
                    </div>
                </div>
                
                <div class="card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Applicant</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hire Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Training Progress</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Evaluation</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="applicant-records" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Applicant data will be loaded here -->
                                <tr id="no-applicant-data">
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-user-graduate text-4xl mb-4 text-gray-300 dark:text-gray-600"></i>
                                        <p>No applicant records found</p>
                                        <p class="text-sm mt-2">Click "Add Applicant" to add new applicants</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400" id="applicant-pagination-info">
                        Showing 0 to 0 of 0 applicants
                    </div>
                    <div class="flex items-center space-x-2" id="applicant-pagination-controls">
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700" disabled>
                            Previous
                        </button>
                        <button class="px-3 py-1.5 bg-blue-theme text-white rounded-lg">1</button>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700" disabled>
                            Next
                        </button>
                    </div>
                </div>
            </div>

            <!-- Training Progress Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 content-fade-in stagger-delay-3">
                <!-- Training Progress by Department -->
                <div class="card p-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-6">Training Progress by Department</h3>
                    <div id="department-progress-container" class="space-y-6">
                        <!-- Department progress will be loaded here -->
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-chart-bar text-4xl mb-4 text-gray-300 dark:text-gray-600"></i>
                            <p>No training progress data available</p>
                        </div>
                    </div>
                </div>
                
                <!-- Upcoming Training Schedule -->
                <div class="card p-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Upcoming Training Schedule</h3>
                        <a href="#" class="text-blue-theme text-sm font-medium hover:text-blue-700 dark:hover:text-blue-400">View Calendar</a>
                    </div>
                    
                    <div id="upcoming-training-container" class="space-y-4">
                        <!-- Upcoming training sessions will be loaded here -->
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-calendar-alt text-3xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p>No upcoming training sessions</p>
                        </div>
                    </div>
                    
                    <button id="schedule-training-btn" class="w-full mt-6 py-3 bg-blue-theme hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">
                        Schedule New Training Session
                    </button>
                </div>
            </div>

            <!-- Evaluation Summary -->
            <div class="card p-6 mb-8 content-fade-in stagger-delay-4">
                <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-6">Training Evaluation Summary</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-5">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 mr-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Passed Training</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="passed-training-count">0</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            0% success rate
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-5">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center text-yellow-600 dark:text-yellow-300 mr-3">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Under Evaluation</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="under-evaluation-count">0</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Awaiting HR decision
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-5">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300 mr-3">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">Failed/Rejected</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="failed-rejected-count">0</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Requires re-training
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Recent Evaluations</h4>
                    <div id="recent-evaluations-container" class="space-y-3">
                        <!-- Recent evaluations will be loaded here -->
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-clipboard-check text-3xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p>No recent evaluations</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Applicant Detail Modal -->
    <div class="modal-overlay" id="applicant-modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-2xl text-gray-900 dark:text-white">Applicant Details</h3>
                    <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" id="close-modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Modal content will be loaded here -->
                <div id="modal-content">
                    <!-- Content loaded dynamically -->
                </div>
            </div>
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
        
        // Department Filter Functionality
        const filterPills = document.querySelectorAll('.filter-pill');
        const applicantRows = document.querySelectorAll('.applicant-row');
        
        filterPills.forEach(pill => {
            pill.addEventListener('click', function() {
                // Remove active class from all pills
                filterPills.forEach(p => p.classList.remove('active'));
                // Add active class to clicked pill
                this.classList.add('active');
                
                const department = this.getAttribute('data-department');
                
                // Show/hide applicant rows based on filter
                applicantRows.forEach(row => {
                    if (department === 'all' || row.getAttribute('data-department') === department) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        
        // Applicant Detail Modal
        const applicantModal = document.getElementById('applicant-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const viewApplicantBtns = document.querySelectorAll('.view-applicant-btn');
        const modalContent = document.getElementById('modal-content');
        
        // Function to open modal with applicant details
        function openApplicantModal(applicantId) {
            // Implement your backend logic here to fetch applicant details
            console.log('Open applicant modal for ID:', applicantId);
            
            modalContent.innerHTML = `
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-user-circle text-5xl mb-4 text-gray-300 dark:text-gray-600"></i>
                    <p>Loading applicant details...</p>
                </div>
            `;
            
            // Open modal
            applicantModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        // Function to close modal
        function closeModal() {
            applicantModal.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Event listeners for modal
        closeModalBtn.addEventListener('click', closeModal);
        applicantModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Function to approve applicant
        function approveApplicant(applicantId) {
            // Implement your backend logic here
            console.log('Approve applicant:', applicantId);
        }
        
        // Function to reject applicant
        function rejectApplicant(applicantId) {
            // Implement your backend logic here
            console.log('Reject applicant:', applicantId);
        }
        
        // Schedule training button functionality
        document.querySelectorAll('.schedule-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const applicantId = this.getAttribute('data-id');
                console.log('Schedule training for applicant:', applicantId);
            });
        });
        
        // Toast notification function
        function showToast(message, type) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : type === 'error' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'}`;
            toast.textContent = message;
            
            // Add to DOM
            document.body.appendChild(toast);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
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
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && applicantModal.classList.contains('active')) {
                closeModal();
            }
        });
    </script>
</body>
</html>