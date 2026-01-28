<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Process Payroll Run - Monti Textile HRM</title>

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
        
        /* Payroll Run Specific Styles - Redesigned Table */
        .payroll-table-container {
            overflow-x: auto;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            background: white;
        }
        
        .payroll-table {
            min-width: 1800px;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .payroll-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .payroll-table th {
            background-color: #f8fafc;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e5e7eb;
            position: relative;
        }
        
        .payroll-table th.group-header {
            background-color: #e0f2fe;
            text-align: center;
            font-size: 0.7rem;
            padding: 8px 4px;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }
        
        .payroll-table th.sub-header {
            background-color: #f1f5f9;
            font-weight: 500;
            font-size: 0.7rem;
            padding: 6px 4px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .payroll-table td {
            vertical-align: middle;
            padding: 12px 8px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .payroll-table tr:hover td {
            background-color: #f8fafc;
        }
        
        .amount-input {
            width: 90px;
            text-align: right;
            font-family: 'SF Mono', Monaco, monospace;
            font-weight: 500;
            padding: 6px 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .amount-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        
        .hours-input {
            width: 70px;
            text-align: center;
            padding: 6px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .hours-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        
        .rate-input {
            width: 80px;
            text-align: right;
            padding: 6px 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .rate-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        
        .department-section {
            background: linear-gradient(to right, rgba(59, 130, 246, 0.05), rgba(59, 130, 246, 0.02));
            border-left: 4px solid #3b82f6;
        }
        
        .department-section td {
            background-color: #f0f9ff;
            font-weight: 600;
            color: #1e40af;
            padding: 12px 16px;
            border-bottom: 2px solid #3b82f6;
        }
        
        .department-section:nth-child(2) {
            border-left-color: #10b981;
        }
        
        .department-section:nth-child(2) td {
            background-color: #f0fdf4;
            color: #065f46;
            border-bottom-color: #10b981;
        }
        
        .department-section:nth-child(3) {
            border-left-color: #f59e0b;
        }
        
        .department-section:nth-child(3) td {
            background-color: #fef3c7;
            color: #92400e;
            border-bottom-color: #f59e0b;
        }
        
        .department-section:nth-child(4) {
            border-left-color: #8b5cf6;
        }
        
        .department-section:nth-child(4) td {
            background-color: #f5f3ff;
            color: #5b21b6;
            border-bottom-color: #8b5cf6;
        }
        
        .total-row {
            background-color: #fef3c7;
            font-weight: 600;
            border-top: 2px solid #fbbf24;
        }
        
        .total-row td {
            padding: 14px 8px;
            border-bottom: none;
        }
        
        .dark .total-row {
            background-color: #78350f;
            border-top-color: #d97706;
        }
        
        .approval-status {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .net-pay {
            font-weight: 700;
            color: #059669;
            font-size: 0.95rem;
        }
        
        .deduction {
            color: #dc2626;
        }
        
        .addition {
            color: #059669;
        }
        
        .employee-checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        .section-label {
            font-size: 0.7rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
            display: block;
        }
        
        /* Column grouping styles */
        .col-group {
            position: relative;
        }
        
        .col-group::after {
            content: '';
            position: absolute;
            right: -1px;
            top: 0;
            bottom: 0;
            width: 1px;
            background-color: #e5e7eb;
        }
        
        /* Dark mode table styles */
        .dark .payroll-table-container {
            background-color: #1f2937;
            border-color: #374151;
        }
        
        .dark .payroll-table th {
            background-color: #374151;
            border-color: #4b5563;
            color: #d1d5db;
        }
        
        .dark .payroll-table th.group-header {
            background-color: #1e3a8a;
            border-color: #374151;
        }
        
        .dark .payroll-table th.sub-header {
            background-color: #2d3748;
            border-color: #4b5563;
        }
        
        .dark .payroll-table td {
            border-color: #374151;
            color: #d1d5db;
        }
        
        .dark .payroll-table tr:hover td {
            background-color: #2d3748;
        }
        
        .dark .amount-input,
        .dark .hours-input,
        .dark .rate-input {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        
        .dark .department-section td {
            background-color: rgba(59, 130, 246, 0.1);
            color: #93c5fd;
        }
        
        .dark .department-section:nth-child(2) td {
            background-color: rgba(16, 185, 129, 0.1);
            color: #6ee7b7;
        }
        
        .dark .department-section:nth-child(3) td {
            background-color: rgba(245, 158, 11, 0.1);
            color: #fcd34d;
        }
        
        .dark .department-section:nth-child(4) td {
            background-color: rgba(139, 92, 246, 0.1);
            color: #c4b5fd;
        }
        
        /* Fixed columns for better readability */
        .fixed-column {
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 5;
            border-right: 1px solid #e5e7eb;
        }
        
        .dark .fixed-column {
            background-color: #1f2937;
            border-right-color: #374151;
        }
        
        .fixed-column-employee {
            position: sticky;
            left: 40px; /* Width of checkbox column */
            background-color: white;
            z-index: 5;
            border-right: 1px solid #e5e7eb;
            min-width: 200px;
        }
        
        .dark .fixed-column-employee {
            background-color: #1f2937;
            border-right-color: #374151;
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
            
            .payroll-table {
                min-width: 2200px;
            }
            
            .fixed-column,
            .fixed-column-employee {
                position: static;
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
            
            .payroll-summary-cards {
                grid-template-columns: 1fr;
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
            
            .payroll-action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .payroll-action-buttons button {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <!-- Mobile Overlay -->
    <div class="mobile-sidebar-overlay" id="mobile-overlay"></div>

    <!-- Sidebar (Loads immediately) -->
    @include('uno.hrm.hrm_staff.SideBarHrStaff')

    <!-- Content Loading Overlay -->
    <div id="content-loading-overlay" class="content-loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-content">
            <h3>Monti Textile HRM</h3>
            <p>Loading payroll processing...</p>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">Process Payroll Run</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">Set employee rates and submit for HR approval</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-medium hidden md:flex">
                            PO
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Payroll Run Header -->
            <div class="card p-6 mb-8 content-fade-in stagger-delay-1">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">November 2023 Payroll Run</h2>
                        <div class="flex items-center flex-wrap gap-4">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-theme mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-400">Pay Period: Nov 1 - Nov 30, 2023</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users text-blue-theme mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-400">Employees: 245</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave text-blue-theme mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-400">Total Estimated: ₱850,250</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 payroll-action-buttons">
                        <a href="{{ route('hrm.staff.payroll') }}" class="px-4 py-2.5 bg-white border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payroll
                        </a>
                        <button id="submit-for-approval" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Submit for HR Approval
                        </button>
                    </div>
                </div>
                
                <!-- Progress Indicator -->
                <div class="mt-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Payroll Processing Progress</span>
                        <span class="text-blue-theme font-medium">65% Complete</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 65%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                        <span>160 Employees Processed</span>
                        <span>85 Employees Pending</span>
                    </div>
                </div>
            </div>

            <!-- Quick Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 payroll-summary-cards">
                <div class="card p-6 content-fade-in stagger-delay-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm">Basic Salary Total</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₱720,500</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <i class="fas fa-money-bill text-blue-600 dark:text-blue-300 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6 content-fade-in stagger-delay-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm">Overtime Total</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₱45,750</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 dark:text-yellow-300 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6 content-fade-in stagger-delay-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm">Deductions Total</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₱127,538</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center">
                            <i class="fas fa-minus-circle text-red-600 dark:text-red-300 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6 content-fade-in stagger-delay-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm">Net Pay Total</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">₱638,712</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center">
                            <i class="fas fa-hand-holding-usd text-green-600 dark:text-green-300 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Tabs -->
            <div class="mb-6 content-fade-in stagger-delay-1">
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="px-4 py-2 rounded-lg bg-blue-theme text-white font-medium department-tab active" data-department="all">
                        All Departments
                    </button>
                    <button class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium department-tab" data-department="production">
                        Production
                    </button>
                    <button class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium department-tab" data-department="quality">
                        Quality Control
                    </button>
                    <button class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium department-tab" data-department="maintenance">
                        Maintenance
                    </button>
                    <button class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium department-tab" data-department="warehouse">
                        Warehouse
                    </button>
                </div>
                
                <!-- Bulk Actions -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all" class="employee-checkbox h-4 w-4 text-blue-600 rounded border-gray-300">
                            <label for="select-all" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Select All</label>
                        </div>
                        
                        <select class="input-field text-sm py-1.5" id="bulk-action">
                            <option value="">Bulk Actions</option>
                            <option value="apply-bonus">Apply 13th Month Bonus</option>
                            <option value="increase-5">Increase 5%</option>
                            <option value="apply-overtime">Apply Overtime</option>
                            <option value="reset">Reset to Default</option>
                        </select>
                        
                        <button id="apply-bulk-action" class="px-4 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-medium hover:bg-blue-200 dark:hover:bg-blue-800">
                            Apply
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-lg text-sm font-medium hover:bg-yellow-200 dark:hover:bg-yellow-800">
                            <i class="fas fa-download mr-2"></i> Export
                        </button>
                        <button class="px-4 py-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg text-sm font-medium hover:bg-green-200 dark:hover:bg-green-800">
                            <i class="fas fa-calculator mr-2"></i> Recalculate All
                        </button>
                    </div>
                </div>
            </div>

            <!-- Payroll Table -->
            <div class="payroll-table-container content-fade-in stagger-delay-2">
                <table class="payroll-table">
                    <thead>
                        <!-- Group Headers Row -->
                        <tr>
                            <th class="py-3 px-4 text-left" rowspan="2">
                                <input type="checkbox" id="select-all-header" class="employee-checkbox">
                            </th>
                            <th class="py-3 px-4 text-left fixed-column-employee" rowspan="2">Employee</th>
                            <th class="py-3 px-4 text-left" rowspan="2">Department</th>
                            <th class="py-3 px-4 text-left" rowspan="2">Basic Rate</th>
                            
                            <th class="py-3 px-4 text-center group-header col-group" colspan="3">Night Differential</th>
                            <th class="py-3 px-4 text-center group-header col-group" colspan="3">Overtime</th>
                            <th class="py-3 px-4 text-center group-header col-group" colspan="3">Sunday/Special Holiday</th>
                            <th class="py-3 px-4 text-center group-header col-group" colspan="3">Regular Holiday</th>
                            <th class="py-3 px-4 text-center group-header col-group" colspan="3">Late Deductions</th>
                            
                            <th class="py-3 px-4 text-left" rowspan="2">SSS</th>
                            <th class="py-3 px-4 text-left" rowspan="2">PhilHealth</th>
                            <th class="py-3 px-4 text-left" rowspan="2">Pag-IBIG</th>
                            
                            <th class="py-3 px-4 text-left" rowspan="2">Gross Pay</th>
                            <th class="py-3 px-4 text-left" rowspan="2">Total Deductions</th>
                            <th class="py-3 px-4 text-left" rowspan="2">Net Pay</th>
                            <th class="py-3 px-4 text-left" rowspan="2">Status</th>
                        </tr>
                        
                        <!-- Sub Headers Row -->
                        <tr>
                            <!-- Night Differential Subheaders -->
                            <th class="sub-header text-center">Hours</th>
                            <th class="sub-header text-center">Rate</th>
                            <th class="sub-header text-center">Amount</th>
                            
                            <!-- Overtime Subheaders -->
                            <th class="sub-header text-center">Hours</th>
                            <th class="sub-header text-center">Rate</th>
                            <th class="sub-header text-center">Amount</th>
                            
                            <!-- Sunday/Special Holiday Subheaders -->
                            <th class="sub-header text-center">Hours</th>
                            <th class="sub-header text-center">Rate</th>
                            <th class="sub-header text-center">Amount</th>
                            
                            <!-- Regular Holiday Subheaders -->
                            <th class="sub-header text-center">Hours</th>
                            <th class="sub-header text-center">Rate</th>
                            <th class="sub-header text-center">Amount</th>
                            
                            <!-- Late Deductions Subheaders -->
                            <th class="sub-header text-center">Minutes</th>
                            <th class="sub-header text-center">Rate/Min</th>
                            <th class="sub-header text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Production Department -->
                        <tr class="department-section">
                            <td colspan="25" class="py-3 px-4">
                                <i class="fas fa-industry mr-2"></i> Production Department (85 Employees)
                            </td>
                        </tr>
                        
                        <!-- Employee Rows -->
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="py-4 px-4 fixed-column">
                                <input type="checkbox" class="employee-checkbox h-4 w-4 text-blue-600 rounded border-gray-300">
                            </td>
                            <td class="py-4 px-4 fixed-column-employee">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-medium text-sm mr-3">
                                        JD
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">John Dela Cruz</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">EMP-2023-001</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 text-xs rounded-full">Production</span>
                            </td>
                            
                            <!-- Basic Rate -->
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="18500" class="amount-input pl-8" data-type="basic">
                                </div>
                            </td>
                            
                            <!-- Night Differential -->
                            <td class="py-4 px-2">
                                <input type="text" value="8" class="hours-input" data-type="night-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="100" class="rate-input pl-6" data-type="night-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="800" class="amount-input pl-8 addition" data-type="night-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Overtime -->
                            <td class="py-4 px-2">
                                <input type="text" value="4" class="hours-input" data-type="ot-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="150" class="rate-input pl-6" data-type="ot-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="600" class="amount-input pl-8 addition" data-type="ot-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Sunday/Special Holiday -->
                            <td class="py-4 px-2">
                                <input type="text" value="0" class="hours-input" data-type="sunday-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="200" class="rate-input pl-6" data-type="sunday-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="0" class="amount-input pl-8 addition" data-type="sunday-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Regular Holiday -->
                            <td class="py-4 px-2">
                                <input type="text" value="0" class="hours-input" data-type="holiday-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="250" class="rate-input pl-6" data-type="holiday-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="0" class="amount-input pl-8 addition" data-type="holiday-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Late Deductions -->
                            <td class="py-4 px-2">
                                <input type="text" value="15" class="hours-input" data-type="late-minutes">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="5" class="rate-input pl-6" data-type="late-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="75" class="amount-input pl-8 deduction" data-type="late-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Statutory Deductions -->
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="750" class="amount-input pl-8 deduction" data-type="sss">
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="300" class="amount-input pl-8 deduction" data-type="philhealth">
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="100" class="amount-input pl-8 deduction" data-type="pagibig">
                                </div>
                            </td>
                            
                            <!-- Totals -->
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900 dark:text-white gross-pay">₱19,900</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-medium text-red-600 dark:text-red-400 total-deductions">₱1,225</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="net-pay font-bold">₱18,675</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="approval-status status-pending">Pending</span>
                            </td>
                        </tr>
                        
                        <!-- Additional sample employee -->
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="py-4 px-4 fixed-column">
                                <input type="checkbox" class="employee-checkbox h-4 w-4 text-blue-600 rounded border-gray-300">
                            </td>
                            <td class="py-4 px-4 fixed-column-employee">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 font-medium text-sm mr-3">
                                        MS
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Maria Santos</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">EMP-2023-045</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 text-xs rounded-full">Production</span>
                            </td>
                            
                            <!-- Basic Rate -->
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="21300" class="amount-input pl-8" data-type="basic">
                                </div>
                            </td>
                            
                            <!-- Night Differential -->
                            <td class="py-4 px-2">
                                <input type="text" value="12" class="hours-input" data-type="night-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="100" class="rate-input pl-6" data-type="night-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="1200" class="amount-input pl-8 addition" data-type="night-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Overtime -->
                            <td class="py-4 px-2">
                                <input type="text" value="8" class="hours-input" data-type="ot-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="150" class="rate-input pl-6" data-type="ot-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="1200" class="amount-input pl-8 addition" data-type="ot-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Sunday/Special Holiday -->
                            <td class="py-4 px-2">
                                <input type="text" value="4" class="hours-input" data-type="sunday-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="200" class="rate-input pl-6" data-type="sunday-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="800" class="amount-input pl-8 addition" data-type="sunday-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Regular Holiday -->
                            <td class="py-4 px-2">
                                <input type="text" value="0" class="hours-input" data-type="holiday-hours">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="250" class="rate-input pl-6" data-type="holiday-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="0" class="amount-input pl-8 addition" data-type="holiday-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Late Deductions -->
                            <td class="py-4 px-2">
                                <input type="text" value="0" class="hours-input" data-type="late-minutes">
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-xs text-gray-400">₱</span>
                                    <input type="text" value="5" class="rate-input pl-6" data-type="late-rate">
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="0" class="amount-input pl-8 deduction" data-type="late-amount" readonly>
                                </div>
                            </td>
                            
                            <!-- Statutory Deductions -->
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="800" class="amount-input pl-8 deduction" data-type="sss">
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="350" class="amount-input pl-8 deduction" data-type="philhealth">
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400">₱</span>
                                    <input type="text" value="100" class="amount-input pl-8 deduction" data-type="pagibig">
                                </div>
                            </td>
                            
                            <!-- Totals -->
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900 dark:text-white gross-pay">₱24,500</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-medium text-red-600 dark:text-red-400 total-deductions">₱1,250</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="net-pay font-bold">₱23,250</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="approval-status status-pending">Pending</span>
                            </td>
                        </tr>

                        <!-- Totals Row -->
                        <tr class="total-row">
                            <td class="py-4 px-4 font-bold" colspan="4">TOTALS (245 Employees)</td>
                            <td class="py-4 px-2 font-bold">1,240 hrs</td>
                            <td class="py-4 px-2"></td>
                            <td class="py-4 px-2 font-bold addition">₱124,000</td>
                            
                            <td class="py-4 px-2 font-bold">980 hrs</td>
                            <td class="py-4 px-2"></td>
                            <td class="py-4 px-2 font-bold addition">₱147,000</td>
                            
                            <td class="py-4 px-2 font-bold">320 hrs</td>
                            <td class="py-4 px-2"></td>
                            <td class="py-4 px-2 font-bold addition">₱64,000</td>
                            
                            <td class="py-4 px-2 font-bold">120 hrs</td>
                            <td class="py-4 px-2"></td>
                            <td class="py-4 px-2 font-bold addition">₱30,000</td>
                            
                            <td class="py-4 px-2 font-bold">2,450 min</td>
                            <td class="py-4 px-2"></td>
                            <td class="py-4 px-2 font-bold deduction">₱12,250</td>
                            
                            <td class="py-4 px-4 font-bold deduction">₱42,500</td>
                            <td class="py-4 px-4 font-bold deduction">₱18,375</td>
                            <td class="py-4 px-4 font-bold deduction">₱6,125</td>
                            
                            <td class="py-4 px-4 font-bold text-xl">₱1,085,500</td>
                            <td class="py-4 px-4 font-bold text-xl deduction">₱127,250</td>
                            <td class="py-4 px-4 font-bold text-xl text-green-600 dark:text-green-400">₱958,250</td>
                            <td class="py-4 px-4"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Submission Section -->
            <div class="card p-6 mt-8 content-fade-in stagger-delay-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Submit for HR Manager Approval</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select HR Manager</label>
                            <select class="input-field w-full">
                                <option value="">Choose HR Manager</option>
                                <option value="1" selected>Anna Gomez - HR Director</option>
                                <option value="2">Mark Reyes - HR Manager</option>
                                <option value="3">Lisa Cruz - HR Supervisor</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Date</label>
                            <input type="date" class="input-field w-full" value="2023-11-30">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                            <select class="input-field w-full">
                                <option value="bank">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes for HR Manager</label>
                            <textarea class="input-field w-full h-32" placeholder="Add any special notes or instructions for the HR manager..."></textarea>
                        </div>
                        
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="send-email" class="h-4 w-4 text-blue-600 rounded border-gray-300">
                            <label for="send-email" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send email notification to HR Manager</label>
                        </div>
                        
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="generate-payslips" class="h-4 w-4 text-blue-600 rounded border-gray-300" checked>
                            <label for="generate-payslips" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Generate payslips automatically</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="lock-payroll" class="h-4 w-4 text-blue-600 rounded border-gray-300" checked>
                            <label for="lock-payroll" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Lock payroll after submission</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="button" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 mr-4">
                        Save as Draft
                    </button>
                    <button id="final-submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i> Submit for Approval
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Approval Confirmation Modal -->
    <div id="approval-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 dark:bg-green-900 rounded-full mb-4">
                    <i class="fas fa-check text-green-600 dark:text-green-300 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white text-center mb-2">Submit for Approval?</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                    You are about to submit the November 2023 payroll for HR Manager approval. This action cannot be undone.
                </p>
                
                <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4 mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-blue-800 dark:text-blue-200">Total Employees:</span>
                        <span class="font-medium">245</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-blue-800 dark:text-blue-200">Gross Pay Total:</span>
                        <span class="font-medium">₱1,085,500</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-blue-800 dark:text-blue-200">Total Deductions:</span>
                        <span class="font-medium">₱127,250</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-800 dark:text-blue-200">Net Pay Total:</span>
                        <span class="font-medium">₱958,250</span>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-blue-800 dark:text-blue-200">HR Manager:</span>
                        <span class="font-medium">Anna Gomez</span>
                    </div>
                </div>
                
                <div class="flex justify-center space-x-4">
                    <button id="cancel-approval" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button id="confirm-approval" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        Confirm Submission
                    </button>
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

        // Original paylist functionality
        // Department Tab Functionality
        const departmentTabs = document.querySelectorAll('.department-tab');
        departmentTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                departmentTabs.forEach(t => t.classList.remove('active', 'bg-blue-theme', 'text-white'));
                departmentTabs.forEach(t => t.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300'));
                
                tab.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                tab.classList.add('active', 'bg-blue-theme', 'text-white');
                
                const department = tab.dataset.department;
                // Filter functionality would go here
            });
        });
        
        // Select All Checkbox
        const selectAllCheckbox = document.getElementById('select-all');
        const selectAllHeader = document.getElementById('select-all-header');
        const employeeCheckboxes = document.querySelectorAll('.employee-checkbox');
        
        function updateSelectAll() {
            const allChecked = Array.from(employeeCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllHeader.checked = allChecked;
        }
        
        selectAllCheckbox.addEventListener('change', () => {
            employeeCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            selectAllHeader.checked = selectAllCheckbox.checked;
        });
        
        selectAllHeader.addEventListener('change', () => {
            employeeCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllHeader.checked;
            });
            selectAllCheckbox.checked = selectAllHeader.checked;
        });
        
        employeeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAll);
        });
        
        // Bulk Action
        const bulkActionSelect = document.getElementById('bulk-action');
        const applyBulkActionBtn = document.getElementById('apply-bulk-action');
        
        applyBulkActionBtn.addEventListener('click', () => {
            const action = bulkActionSelect.value;
            if (!action) {
                alert('Please select a bulk action first');
                return;
            }
            
            const selectedEmployees = Array.from(employeeCheckboxes).filter(cb => cb.checked);
            if (selectedEmployees.length === 0) {
                alert('Please select at least one employee');
                return;
            }
            
            // Apply bulk action logic
            switch(action) {
                case 'apply-bonus':
                    alert(`Applying 13th month bonus to ${selectedEmployees.length} employees`);
                    break;
                case 'increase-5':
                    alert(`Increasing salary by 5% for ${selectedEmployees.length} employees`);
                    break;
                case 'apply-overtime':
                    alert(`Applying overtime to ${selectedEmployees.length} employees`);
                    break;
                case 'reset':
                    alert(`Resetting ${selectedEmployees.length} employees to default rates`);
                    break;
            }
            
            bulkActionSelect.value = '';
        });
        
        // Calculate amount when hours/rates change
        function calculateAmounts(row) {
            // Night Differential
            const nightHours = parseFloat(row.querySelector('input[data-type="night-hours"]').value) || 0;
            const nightRate = parseFloat(row.querySelector('input[data-type="night-rate"]').value) || 0;
            const nightAmount = nightHours * nightRate;
            row.querySelector('input[data-type="night-amount"]').value = nightAmount.toFixed(2);
            
            // Overtime
            const otHours = parseFloat(row.querySelector('input[data-type="ot-hours"]').value) || 0;
            const otRate = parseFloat(row.querySelector('input[data-type="ot-rate"]').value) || 0;
            const otAmount = otHours * otRate;
            row.querySelector('input[data-type="ot-amount"]').value = otAmount.toFixed(2);
            
            // Sunday/Special Holiday
            const sundayHours = parseFloat(row.querySelector('input[data-type="sunday-hours"]').value) || 0;
            const sundayRate = parseFloat(row.querySelector('input[data-type="sunday-rate"]').value) || 0;
            const sundayAmount = sundayHours * sundayRate;
            row.querySelector('input[data-type="sunday-amount"]').value = sundayAmount.toFixed(2);
            
            // Regular Holiday
            const holidayHours = parseFloat(row.querySelector('input[data-type="holiday-hours"]').value) || 0;
            const holidayRate = parseFloat(row.querySelector('input[data-type="holiday-rate"]').value) || 0;
            const holidayAmount = holidayHours * holidayRate;
            row.querySelector('input[data-type="holiday-amount"]').value = holidayAmount.toFixed(2);
            
            // Late Deductions
            const lateMinutes = parseFloat(row.querySelector('input[data-type="late-minutes"]').value) || 0;
            const lateRate = parseFloat(row.querySelector('input[data-type="late-rate"]').value) || 0;
            const lateAmount = lateMinutes * lateRate;
            row.querySelector('input[data-type="late-amount"]').value = lateAmount.toFixed(2);
            
            // Calculate totals
            calculateNetPay(row);
        }
        
        // Auto-calculate net pay when inputs change
        const allInputs = document.querySelectorAll('.hours-input, .rate-input, .amount-input');
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                const row = this.closest('tr');
                if (row && !row.classList.contains('total-row')) {
                    calculateAmounts(row);
                }
            });
        });
        
        function calculateNetPay(row) {
            if (row.classList.contains('total-row')) return;
            
            const basic = parseFloat(row.querySelector('input[data-type="basic"]').value) || 0;
            const nightAmount = parseFloat(row.querySelector('input[data-type="night-amount"]').value) || 0;
            const otAmount = parseFloat(row.querySelector('input[data-type="ot-amount"]').value) || 0;
            const sundayAmount = parseFloat(row.querySelector('input[data-type="sunday-amount"]').value) || 0;
            const holidayAmount = parseFloat(row.querySelector('input[data-type="holiday-amount"]').value) || 0;
            const lateAmount = parseFloat(row.querySelector('input[data-type="late-amount"]').value) || 0;
            const sss = parseFloat(row.querySelector('input[data-type="sss"]').value) || 0;
            const philhealth = parseFloat(row.querySelector('input[data-type="philhealth"]').value) || 0;
            const pagibig = parseFloat(row.querySelector('input[data-type="pagibig"]').value) || 0;
            
            const grossPay = basic + nightAmount + otAmount + sundayAmount + holidayAmount - lateAmount;
            const totalDeductions = sss + philhealth + pagibig + lateAmount;
            const netPay = grossPay - totalDeductions;
            
            row.querySelector('.gross-pay').textContent = `₱${grossPay.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            row.querySelector('.total-deductions').textContent = `₱${totalDeductions.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            row.querySelector('.net-pay').textContent = `₱${netPay.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }
        
        // Initialize calculations for all rows
        document.addEventListener('DOMContentLoaded', () => {
            const employeeRows = document.querySelectorAll('tbody tr:not(.department-section):not(.total-row)');
            employeeRows.forEach(row => {
                calculateAmounts(row);
            });
        });
        
        // Approval Modal
        const submitForApprovalBtn = document.getElementById('submit-for-approval');
        const finalSubmitBtn = document.getElementById('final-submit');
        const approvalModal = document.getElementById('approval-modal');
        const cancelApprovalBtn = document.getElementById('cancel-approval');
        const confirmApprovalBtn = document.getElementById('confirm-approval');
        
        function showApprovalModal() {
            approvalModal.classList.remove('hidden');
        }
        
        function hideApprovalModal() {
            approvalModal.classList.add('hidden');
        }
        
        submitForApprovalBtn.addEventListener('click', showApprovalModal);
        finalSubmitBtn.addEventListener('click', showApprovalModal);
        cancelApprovalBtn.addEventListener('click', hideApprovalModal);
        
        confirmApprovalBtn.addEventListener('click', () => {
            // Submit form logic here
            alert('Payroll submitted successfully for HR Manager approval!');
            hideApprovalModal();
            
            // Redirect to payroll page after submission
            setTimeout(() => {
                window.location.href = "{{ route('hrm.staff.payroll') }}";
            }, 1500);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>