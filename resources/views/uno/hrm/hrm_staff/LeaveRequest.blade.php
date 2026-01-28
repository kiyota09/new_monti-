<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Leave Requests - Monti Textile HRM</title>

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
        
        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
        }
        
        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.3s ease-out;
            z-index: 1001;
        }
        
        .dark .modal {
            background-color: #374151;
            color: #f9fafb;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to { 
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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
            
            .modal {
                width: 95%;
                margin: 1rem;
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
    <!-- Mobile Sidebar Overlay -->
    <div class="mobile-sidebar-overlay" id="mobile-overlay"></div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modal-overlay">
        <!-- Modal Content -->
        <div class="modal">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white">Create New Leave Request (HR)</h3>
                    <button id="close-modal-btn" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="leave-request-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Employee Details -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Employee Name *</label>
                            <input type="text" id="employee-name" class="input-field" placeholder="Enter employee full name" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Employee ID</label>
                            <input type="text" id="employee-id" class="input-field" placeholder="Employee ID (optional)">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department *</label>
                            <select id="department-select" class="input-field" required>
                                <option value="">Select Department</option>
                                <option value="production">Production</option>
                                <option value="quality-control">Quality Control</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="hr">Human Resources</option>
                                <option value="finance">Finance</option>
                                <option value="logistics">Logistics</option>
                                <option value="admin">Administration</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Leave Type *</label>
                            <select id="leave-type" class="input-field" required>
                                <option value="">Select Leave Type</option>
                                <option value="vacation">Vacation Leave</option>
                                <option value="sick">Sick Leave</option>
                                <option value="maternity">Maternity Leave</option>
                                <option value="paternity">Paternity Leave</option>
                                <option value="emergency">Emergency Leave</option>
                                <option value="bereavement">Bereavement Leave</option>
                                <option value="personal">Personal Leave</option>
                                <option value="unpaid">Unpaid Leave</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date *</label>
                            <input type="date" id="start-date" class="input-field" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date *</label>
                            <input type="date" id="end-date" class="input-field" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Explanation / Reason *</label>
                        <textarea id="explanation" class="input-field" rows="4" placeholder="Enter detailed explanation for the leave request..." required></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Notes (Optional)</label>
                        <textarea id="additional-notes" class="input-field" rows="2" placeholder="Any additional information..."></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-4">
                        <button type="button" id="cancel-form-btn" class="px-6 py-3 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-teal-theme hover:bg-teal-700 text-white rounded-lg font-medium">
                            <i class="fas fa-paper-plane mr-2"></i>Submit to HR Manager
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    @include('uno.hrm.hrm_staff.SideBarHrStaff')

    <!-- Content Loading Overlay -->
    <div id="content-loading-overlay" class="content-loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-content">
            <h3>Monti Textile HRM</h3>
            <p>Loading leave requests content...</p>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white header-title">All Leave Requests</h1>
                    <p class="text-gray-500 dark:text-gray-400 hidden md:block">View and manage all employee leave requests by department</p>
                </div>
                
                <div class="flex items-center space-x-4 header-actions">
                    <div class="flex items-center space-x-3">
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-search-toggle">
                            <i class="fas fa-search"></i>
                        </button>
                        
                        <button class="relative p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">48</span>
                        </button>
                        
                        <button class="md:hidden p-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300" id="mobile-menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900 flex items-center justify-center text-teal-700 dark:text-teal-300 font-medium hidden md:flex">
                            HR
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto custom-scrollbar">
            <!-- Department Filter Tabs -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2 mb-6 content-fade-in">
                    <button class="nav-tab active" data-department="all">All Departments</button>
                    <button class="nav-tab" data-department="production">Production</button>
                    <button class="nav-tab" data-department="quality-control">Quality Control</button>
                    <button class="nav-tab" data-department="maintenance">Maintenance</button>
                    <button class="nav-tab" data-department="hr">Human Resources</button>
                    <button class="nav-tab" data-department="finance">Finance</button>
                    <button class="nav-tab" data-department="logistics">Logistics</button>
                </div>
                
                <!-- Search and Filter Bar -->
                <div class="card p-4 mb-6 content-fade-in stagger-delay-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" placeholder="Search employee name, leave type, or department..." class="input-field pl-10">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <select class="input-field">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <button class="px-4 py-2 bg-blue-theme hover:bg-blue-700 text-white rounded-lg font-medium">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <button id="create-leave-request-btn" class="px-4 py-2 bg-teal-theme hover:bg-teal-700 text-white rounded-lg font-medium">
                                <i class="fas fa-plus mr-2"></i>Create Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Requests Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stats-grid">
                <div class="card p-6 flex items-center content-fade-in stagger-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900 flex items-center justify-center mr-4">
                        <i class="fas fa-hourglass-half text-orange-600 dark:text-orange-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Pending</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">18</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Approved</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">156</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900 flex items-center justify-center mr-4">
                        <i class="fas fa-times-circle text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Rejected</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">24</div>
                    </div>
                </div>
                
                <div class="card p-6 flex items-center content-fade-in stagger-delay-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-day text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total This Month</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">48</div>
                    </div>
                </div>
            </div>

            <!-- All Leave Requests Table -->
            <div class="card p-6 content-fade-in stagger-delay-1">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white">All Leave Requests</h3>
                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-download mr-2"></i>Export
                        </button>
                        <button class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-print mr-2"></i>Print
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Leave Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date Range</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Days</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Explanation</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Production Department -->
                            <tr class="department-production">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-medium">
                                            JD
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">John Dela Cruz</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">EMP-00123</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        Production
                                    </span>
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
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">Applied: Nov 10</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                    6 days
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" title="Family vacation to visit relatives in the province. Need to attend family reunion.">
                                        Family vacation to visit relatives in the province...
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="leave-status-badge leave-status-pending">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3 approve-btn">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 reject-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 ml-3 view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Quality Control Department -->
                            <tr class="department-quality-control">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-medium">
                                            MS
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Maria Santos</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">EMP-00145</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                        Quality Control
                                    </span>
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
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">Applied: Nov 12</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                    3 days
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" title="Doctor advised complete rest due to severe flu and fever. Medical certificate attached.">
                                        Doctor advised complete rest due to severe flu...
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="leave-status-badge leave-status-approved">
                                        Approved
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Maintenance Department -->
                            <tr class="department-maintenance">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-300 font-medium">
                                            RG
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Robert Garcia</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">EMP-00167</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Maintenance
                                    </span>
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
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">Applied: Nov 15</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                    1 day
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" title="Emergency house repair due to water pipe burst. Need to be present for plumber.">
                                        Emergency house repair due to water pipe burst...
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="leave-status-badge leave-status-rejected">
                                        Rejected
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- HR Department -->
                            <tr class="department-hr">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-pink-100 dark:bg-pink-900 flex items-center justify-center text-pink-600 dark:text-pink-300 font-medium">
                                            AG
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Anna Gomez</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">EMP-00189</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300">
                                        Human Resources
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center mr-2">
                                            <i class="fas fa-heart text-red-600 dark:text-red-300 text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white">Maternity</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    Dec 1 - Jan 31, 2024<br>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">Applied: Nov 5</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                    62 days
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" title="Maternity leave as per doctor's advice. Expected delivery date: Dec 5, 2023.">
                                        Maternity leave as per doctor's advice. Expected...
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="leave-status-badge leave-status-approved">
                                        Approved
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Finance Department -->
                            <tr class="department-finance">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center text-yellow-600 dark:text-yellow-300 font-medium">
                                            MT
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Michael Tan</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">EMP-00201</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        Finance
                                    </span>
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
                                    Nov 28 - Dec 5, 2023<br>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">Applied: Nov 18</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                    8 days
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-white max-w-xs">
                                    <div class="truncate" title="Annual family vacation to Boracay. Planned and booked 6 months in advance.">
                                        Annual family vacation to Boracay. Planned and...
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="leave-status-badge leave-status-pending">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3 approve-btn">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 reject-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 ml-3 view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 px-4 py-3 mt-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">48</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    1
                                </a>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    2
                                </a>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    3
                                </a>
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    10
                                </a>
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Summary -->
            {{-- <div class="mt-8">
                <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-6">Leave Requests by Department</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Production Department</h4>
                            <span class="text-sm text-gray-500 dark:text-gray-400">25 employees</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Pending Requests</span>
                                <span class="font-medium text-gray-900 dark:text-white">8</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Approved This Month</span>
                                <span class="font-medium text-gray-900 dark:text-white">12</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Average Leave Days</span>
                                <span class="font-medium text-gray-900 dark:text-white">4.2 days</span>
                            </div>
                        </div>
                        <button class="w-full mt-4 py-2 border border-blue-theme text-blue-theme rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                            View All Production Requests
                        </button>
                    </div>
                    
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Quality Control</h4>
                            <span class="text-sm text-gray-500 dark:text-gray-400">15 employees</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Pending Requests</span>
                                <span class="font-medium text-gray-900 dark:text-white">3</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Approved This Month</span>
                                <span class="font-medium text-gray-900 dark:text-white">8</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Average Leave Days</span>
                                <span class="font-medium text-gray-900 dark:text-white">3.5 days</span>
                            </div>
                        </div>
                        <button class="w-full mt-4 py-2 border border-purple-600 text-purple-600 dark:text-purple-400 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900 transition-colors">
                            View All QC Requests
                        </button>
                    </div>
                    
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Human Resources</h4>
                            <span class="text-sm text-gray-500 dark:text-gray-400">8 employees</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Pending Requests</span>
                                <span class="font-medium text-gray-900 dark:text-white">2</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Approved This Month</span>
                                <span class="font-medium text-gray-900 dark:text-white">5</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">Average Leave Days</span>
                                <span class="font-medium text-gray-900 dark:text-white">6.8 days</span>
                            </div>
                        </div>
                        <button class="w-full mt-4 py-2 border border-pink-600 text-pink-600 dark:text-pink-400 rounded-lg hover:bg-pink-50 dark:hover:bg-pink-900 transition-colors">
                            View All HR Requests
                        </button>
                    </div>
                </div>
            </div> --}}
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

        // Modal functionality
        const createRequestBtn = document.getElementById('create-leave-request-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelFormBtn = document.getElementById('cancel-form-btn');
        const modalOverlay = document.getElementById('modal-overlay');
        const leaveRequestForm = document.getElementById('leave-request-form');
        
        // Open modal
        createRequestBtn.addEventListener('click', () => {
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        // Close modal functions
        function closeModal() {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
            leaveRequestForm.reset();
        }
        
        closeModalBtn.addEventListener('click', closeModal);
        cancelFormBtn.addEventListener('click', closeModal);
        
        // Close modal when clicking outside
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
                closeModal();
            }
        });
        
        // Form submission
        leaveRequestForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Get form values
            const employeeName = document.getElementById('employee-name').value;
            const department = document.getElementById('department-select').value;
            const leaveType = document.getElementById('leave-type').value;
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const explanation = document.getElementById('explanation').value;
            
            // Validate dates
            if (new Date(endDate) < new Date(startDate)) {
                showToast('End date cannot be earlier than start date!', 'error');
                return;
            }
            
            // Here you would normally send the data to the server
            // For now, just show a success message
            showToast(`Leave request created for ${employeeName}`, 'success');
            
            // Reset form and close modal
            leaveRequestForm.reset();
            closeModal();
            
            // Simulate adding to table (in a real app, this would come from server)
            setTimeout(() => {
                showToast('Request has been submitted to HR Manager for approval', 'info');
            }, 1000);
        });
        
        // Department filter tabs
        const navTabs = document.querySelectorAll('.nav-tab');
        navTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const department = this.getAttribute('data-department');
                
                // Update active tab
                navTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Filter table rows
                const tableRows = document.querySelectorAll('tbody tr');
                
                if (department === 'all') {
                    tableRows.forEach(row => row.style.display = '');
                } else {
                    tableRows.forEach(row => {
                        if (row.classList.contains(`department-${department}`)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
        });
        
        // Approve/Reject buttons
        document.addEventListener('DOMContentLoaded', () => {
            // Approve button functionality
            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const employeeName = row.querySelector('.text-sm.font-medium').textContent;
                    const statusCell = row.querySelector('.leave-status-badge');
                    
                    statusCell.textContent = 'Approved';
                    statusCell.className = 'leave-status-badge leave-status-approved';
                    
                    // Change action buttons
                    const actionCell = row.querySelector('td:last-child');
                    actionCell.innerHTML = `
                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    `;
                    
                    showToast(`Leave request for ${employeeName} approved successfully!`, 'success');
                });
            });
            
            // Reject button functionality
            document.querySelectorAll('.reject-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const employeeName = row.querySelector('.text-sm.font-medium').textContent;
                    const statusCell = row.querySelector('.leave-status-badge');
                    
                    statusCell.textContent = 'Rejected';
                    statusCell.className = 'leave-status-badge leave-status-rejected';
                    
                    // Change action buttons
                    const actionCell = row.querySelector('td:last-child');
                    actionCell.innerHTML = `
                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    `;
                    
                    showToast(`Leave request for ${employeeName} rejected.`, 'info');
                });
            });
            
            // View button functionality
            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const employeeName = row.querySelector('.text-sm.font-medium').textContent;
                    const department = row.querySelector('td:nth-child(2) span').textContent;
                    const leaveType = row.querySelector('td:nth-child(3) span').textContent;
                    const dateRange = row.querySelector('td:nth-child(4)').textContent.split('\n')[0];
                    
                    // In a real app, this would open a modal with detailed view
                    showToast(`Viewing details for ${employeeName}'s ${leaveType.toLowerCase()} request`, 'info');
                    
                    // Simulate opening a detailed view modal
                    setTimeout(() => {
                        alert(`Employee: ${employeeName}\nDepartment: ${department}\nLeave Type: ${leaveType}\nDate Range: ${dateRange}\n\nDetailed view would show more information here.`);
                    }, 500);
                });
            });
        });
        
        function showToast(message, type) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 ${
                type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                type === 'error' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' :
                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
            }`;
            toast.textContent = message;
            
            // Add icon based on type
            const icon = document.createElement('i');
            icon.className = type === 'success' ? 'fas fa-check-circle mr-2' : 
                            type === 'error' ? 'fas fa-exclamation-circle mr-2' : 
                            'fas fa-info-circle mr-2';
            toast.prepend(icon);
            
            // Add to DOM
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateY(0)';
            }, 10);
            
            // Remove after 4 seconds
            setTimeout(() => {
                toast.style.transform = 'translateY(-100%)';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }
        
        // Initialize progress animations
        document.addEventListener('DOMContentLoaded', () => {
            const progressBars = document.querySelectorAll('.course-progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
            
            // Handle responsive behavior on load
            if (window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
            }
            
            // Set minimum date for date inputs to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('start-date').min = today;
            document.getElementById('end-date').min = today;
        });
        
        // Update end date min when start date changes
        document.getElementById('start-date').addEventListener('change', function() {
            document.getElementById('end-date').min = this.value;
        });
        
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