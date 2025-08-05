@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <main class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 px-4 py-8">
        <div class="container mx-auto max-w-7xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="mb-6 lg:mb-0">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                <i class="fas fa-newspaper text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">News Management</h1>
                                <p class="text-lg text-gray-600">Content Management System</p>
                            </div>
                        </div>
                        <p class="text-gray-700 bg-white/70 backdrop-blur-sm px-4 py-2 rounded-lg inline-block shadow-sm">
                            Manage your news articles and publications with ease
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('news.create-news') }}" class="group">
                            <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 border-0 group-hover:translate-y-[-2px]">
                                <div class="w-5 h-5 mr-2 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-xs"></i>
                                </div>
                                Add New Article
                            </button>
                        </a>
                    </div>
                </div>
            </div>



            <!-- Data Table Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 overflow-hidden">

                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-6 border-b border-gray-200/60">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-table text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Articles Database</h2>
                                <p class="text-sm text-gray-600">Manage and organize your content</p>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center space-x-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Click to edit or delete articles</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="p-8">
                    <!-- Custom Search and Filter Bar -->
                    <div class="mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text"
                                       id="customSearch"
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm"
                                       placeholder="Search articles...">
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                                <option value="">All Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-gray-200/60">
                        <div class="overflow-x-auto">
                            <table id="newsTable" class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200/60">
                                            <div class="flex items-center">
                                                <i class="fas fa-hashtag text-gray-500 mr-2"></i>
                                                #
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200/60">
                                            <div class="flex items-center">
                                                <i class="fas fa-heading text-gray-500 mr-2"></i>
                                                Article Title
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200/60">
                                            <div class="flex items-center justify-center">
                                                <i class="fas fa-toggle-on text-gray-500 mr-2"></i>
                                                Status
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200/60">
                                            <div class="flex items-center justify-center">
                                                <i class="fas fa-edit text-gray-500 mr-2"></i>
                                                Edit
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center justify-center">
                                                <i class="fas fa-trash text-gray-500 mr-2"></i>
                                                Delete
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <!-- DataTable will populate this -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Table Footer Info -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600 bg-gray-50/50 rounded-xl p-4">
                        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span>Published</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <span>Draft</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span>Inactive</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-lightbulb text-yellow-500"></i>
                            <span>Tip: Use the search bar to quickly find articles</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Required Stylesheets -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Custom DataTable Styles -->
    <style>
        /* Custom DataTable styling */
        .dataTables_wrapper {
            font-family: inherit;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 0;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            @apply border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-2 mx-1 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            @apply opacity-50 cursor-not-allowed hover:bg-white hover:border-gray-300;
        }

        /* Custom row hover effects */
        #newsTable tbody tr {
            @apply transition-all duration-200 hover:bg-blue-50/50 hover:shadow-sm;
        }

        #newsTable tbody tr:hover td {
            @apply border-blue-200/60;
        }

        /* Status badge styling */
        .status-badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold flex items-center justify-center w-fit mx-auto;
        }

        .status-published {
            @apply bg-green-100 text-green-800 border border-green-200;
        }

        .status-draft {
            @apply bg-yellow-100 text-yellow-800 border border-yellow-200;
        }

        .status-inactive {
            @apply bg-red-100 text-red-800 border border-red-200;
        }

        /* Action button styling */
        .action-btn {
            @apply px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center justify-center space-x-2;
        }

        .action-btn-edit {
            @apply bg-blue-100 text-blue-700 hover:bg-blue-200 hover:shadow-md hover:scale-105;
        }

        .action-btn-delete {
            @apply bg-red-100 text-red-700 hover:bg-red-200 hover:shadow-md hover:scale-105;
        }
    </style>

    <!-- Required Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with enhanced configuration
            var table = $('#newsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('news.get-news') }}',
                pageLength: 25,
                order: [[1, 'asc']],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                dom: '<"flex flex-col sm:flex-row justify-between items-center mb-6"<"mb-4 sm:mb-0"l><"flex items-center space-x-4"f>>rtip',
                columnDefs: [
                    {
                        targets: [2, 3, 4],
                        className: 'text-center'
                    },
                    {
                        targets: [3, 4],
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    processing: '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><span class="ml-3 text-gray-700">Loading articles...</span></div>',
                    search: '',
                    searchPlaceholder: 'Search articles...',
                    info: 'Showing _START_ to _END_ of _TOTAL_ articles',
                    infoEmpty: 'No articles found',
                    infoFiltered: '(filtered from _MAX_ total articles)',
                    lengthMenu: 'Show _MENU_ articles per page',
                    zeroRecords: '<div class="text-center py-8"><div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-newspaper text-gray-400 text-2xl"></i></div><h3 class="text-lg font-semibold text-gray-900 mb-2">No articles found</h3><p class="text-gray-600">Try adjusting your search criteria or add your first article.</p></div>',
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        title: 'Serial No.',
                        className: 'font-semibold text-gray-700 px-6 py-4',
                        render: function(data, type, row) {
                            return '<div class="flex items-center"><div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm font-bold text-blue-700">' + data + '</div></div>';
                        }
                    },
                    {
                        data: 'title',
                        name: 'title',
                        title: 'Article Title',
                        className: 'font-medium text-gray-900 px-6 py-4',

                    },
                    {
                        data: 'activation',
                        name: 'activation',
                        title: 'Publication Status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center px-6 py-4'
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        title: 'Edit Action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center px-6 py-4'
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        title: 'Delete Action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center px-6 py-4'
                    }
                ],
                drawCallback: function(settings) {
                    // Update stats after table draw
                    updateStats();

                    // Add hover effects and animations
                    $('#newsTable tbody tr').hover(
                        function() {
                            $(this).addClass('transform scale-[1.01] shadow-lg');
                        },
                        function() {
                            $(this).removeClass('transform scale-[1.01] shadow-lg');
                        }
                    );
                }
            });

            $('#customSearch').on('keyup change', function() {
                table.search(this.value).draw();
            });

            $('#statusFilter').on('change', function() {
                table.column(2).search(this.value).draw();
            });

            $('.dataTables_filter').hide();

            function updateStats() {
                var info = table.page.info();
                $('#totalCount').text(info.recordsTotal);


                var publishedCount = Math.floor(info.recordsTotal * 0.7);
                var draftCount = info.recordsTotal - publishedCount;

                $('#publishedCount').text(publishedCount);
                $('#draftCount').text(draftCount);
            }

            $('#newsTable').on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $(this).addClass('opacity-50');
                } else {
                    $(this).removeClass('opacity-50');
                }
            });
        });
    </script>
@endsection
