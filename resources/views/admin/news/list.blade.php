@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <main>

    <style>
        /* Custom DataTables styling with Tailwind */
        .dataTables_wrapper {
            font-family: inherit;
        }

        .dataTables_length select,
        .dataTables_filter input {
            @apply border border-gray-300 rounded px-2 py-1 text-sm;
        }

        .dataTables_paginate .paginate_button {
            @apply px-3 py-1 mx-1 text-sm border border-gray-300 rounded text-gray-700;
        }

        .dataTables_paginate .paginate_button.current {
            @apply bg-blue-500 text-white border-blue-500;
        }

        .dataTables_paginate .paginate_button:hover {
            @apply bg-gray-100;
        }

        .dataTables_info {
            @apply text-sm text-gray-600;
        }

        table.dataTable thead th {
            border-bottom: none !important;
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Page Content -->
    <main class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 pb-6 border-b border-gray-200">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-chart-area text-blue-500 mr-3"></i>

                    <span class="font-light text-gray-500 ml-2">Hospital Management</span>
                </h1>
                <p class="text-gray-600 mt-1">Manage hospital information and locations</p>
            </div>

            <div class="flex flex-wrap gap-3">
             <a href="{{ route('news.create-news') }}">
                <button   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i>
                    Add New
                </button>
            </a>
                <button onclick="viewAll()" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-list mr-2"></i>
                    View All
                </button>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-hospital-alt text-blue-500 mr-2"></i>
                    Hospital
                    <span class="font-light text-gray-500 ml-2 italic">List</span>
                </h2>
            </div>

            <!-- Card Content -->
            <div class="p-6">
                <!-- Table Container with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <table id="dt-basic-example" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-16">
                                    #
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-48">
                                    Hospital Name
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-32">
                                    Longitude
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-32">
                                    Latitude
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-36">
                                    Contact No
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-24">
                                    Edit
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-24">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider min-w-24">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Sample Data Row 1 -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4 text-center text-sm font-medium text-gray-900">1</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    <div class="max-w-48 truncate" title="General Hospital Colombo">
                                        General Hospital Colombo
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">79.8612</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">6.9271</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">+94 11 2691111</td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="editHospital(1)" class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></div>
                                        Active
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="deleteHospital(1)" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Sample Data Row 2 -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4 text-center text-sm font-medium text-gray-900">2</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    <div class="max-w-48 truncate" title="National Hospital of Sri Lanka">
                                        National Hospital of Sri Lanka
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">79.8590</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">6.9167</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">+94 11 2691111</td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="editHospital(2)" class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></div>
                                        Active
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="deleteHospital(2)" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Sample Data Row 3 -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4 text-center text-sm font-medium text-gray-900">3</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    <div class="max-w-48 truncate" title="Teaching Hospital Kandy">
                                        Teaching Hospital Kandy
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">80.6337</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">7.2906</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">+94 81 2222261</td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="editHospital(3)" class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1"></div>
                                        Inactive
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="deleteHospital(3)" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Sample Data Row 4 -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4 text-center text-sm font-medium text-gray-900">4</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    <div class="max-w-48 truncate" title="Base Hospital Galle">
                                        Base Hospital Galle
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">80.2170</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">6.0535</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">+94 91 2232261</td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="editHospital(4)" class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></div>
                                        Active
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="deleteHospital(4)" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Sample Data Row 5 -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4 text-center text-sm font-medium text-gray-900">5</td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    <div class="max-w-48 truncate" title="District General Hospital Negombo">
                                        District General Hospital Negombo
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">79.8358</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">7.2084</td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600 font-mono">+94 31 2229861</td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="editHospital(5)" class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1"></div>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="deleteHospital(5)" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-hospital text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Hospitals</p>
                        <p class="text-2xl font-bold text-gray-900">5</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Active Hospitals</p>
                        <p class="text-2xl font-bold text-gray-900">3</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Review</p>
                        <p class="text-2xl font-bold text-gray-900">1</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#dt-basic-example').DataTable({
                processing: true,
                ordering: false,
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                language: {
                    processing: "Processing...",
                    search: "Search hospitals:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ hospitals",
                    infoEmpty: "Showing 0 to 0 of 0 hospitals",
                    infoFiltered: "(filtered from _MAX_ total hospitals)",
                    paginate: {
                        first: "First",
                        previous: "Previous",
                        next: "Next",
                        last: "Last"
                    },
                    emptyTable: "No hospitals found in the system"
                },
                columnDefs: [
                    { orderable: false, targets: [2, 3, 4, 5, 6, 7] },
                    { searchable: false, targets: [5, 6, 7] },
                    { className: "text-center", targets: "_all" }
                ],
                dom: '<"flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4"<"mb-2 lg:mb-0"l><"mb-2 lg:mb-0"f>>rtip',
                initComplete: function() {
                    // Add Tailwind classes to DataTables elements
                    $('.dataTables_length').addClass('text-sm');
                    $('.dataTables_filter').addClass('text-sm');
                    $('.dataTables_info').addClass('text-sm text-gray-600 mt-4');
                    $('.dataTables_paginate').addClass('mt-4');
                }
            });

            // Add fade-in animation to table rows
            $('#dt-basic-example tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's').addClass('animate-fade-in');
            });
        });





        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-slide-up');
                    }
                });
            }, observerOptions);

            // Observe stats cards
            document.querySelectorAll('.grid > div').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>




    </main>
@endsection
