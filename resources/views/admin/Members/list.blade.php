@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <main class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 px-4 py-8">
        <div class="container mx-auto max-w-7xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="mb-6 lg:mb-0 flex flex-col items-center lg:items-start text-center lg:text-left">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Member Management</h1>
                            </div>
                        </div>
                        <p class="text-gray-700 bg-white/70 backdrop-blur-sm px-4 py-2 rounded-lg inline-block shadow-sm">
                            Manage your members effectively
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3 justify-center lg:justify-end">
                        <a href="{{ route('member.create-member') }}" class="group">
                            <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 border-0 group-hover:translate-y-[-2px]">
                                <div class="w-5 h-5 mr-2 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-xs"></i>
                                </div>
                                Add New Member
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Table Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 overflow-hidden">



                <div class="p-8">
                    <div class="mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <div class="flex items-center justify-center sm:justify-start space-x-4 w-full sm:w-auto">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text"
                                       id="customSearch"
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm"
                                       placeholder="Search members...">
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-gray-200/60">
                        <div class="overflow-x-auto">
                            <table id="memberTable" class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200/60">
                                            <div class="flex items-center justify-center">
                                                <i class="fas fa-hashtag text-gray-500 mr-2"></i>
                                                #
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200/60">
                                            <div class="flex items-center justify-center">
                                                <i class="fas fa-user text-gray-500 mr-2"></i>
                                                Member Name
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
                </div>
            </div>
        </div>
    </main>

    <!-- Required Stylesheets -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Required Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with enhanced configuration
            var table = $('#memberTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('member.get-member') }}',
                    type: 'GET',
                    error: function (xhr, error, code) {
                        console.log('Ajax error:', xhr.responseText);
                        alert('Error loading data: ' + xhr.responseText);
                    }
                },
                pageLength: 25,
                order: [[1, 'asc']],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                dom: '<"flex flex-col sm:flex-row justify-between items-center mb-6"<"mb-4 sm:mb-0"l><"flex items-center space-x-4"f>>rtip',
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 4],
                        className: 'text-center'
                    },
                    {
                        targets: [3, 4],
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    processing: '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><span class="ml-3 text-gray-700">Loading members...</span></div>',
                    search: '',
                    searchPlaceholder: 'Search members...',
                    info: 'Showing _START_ to _END_ of _TOTAL_ members',
                    infoEmpty: 'No members found',
                    infoFiltered: '(filtered from _MAX_ total members)',
                    lengthMenu: 'Show _MENU_ members per page',
                    zeroRecords: '<div class="text-center py-8"><div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-users text-gray-400 text-2xl"></i></div><h3 class="text-lg font-semibold text-gray-900 mb-2">No members found</h3><p class="text-gray-600">Try adjusting your search criteria or add your first member.</p></div>',
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
                        className: 'font-semibold text-gray-700 px-6 py-4 text-center',
                        render: function(data, type, row) {
                            return '<div class="flex items-center justify-center"><div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm font-bold text-blue-700">' + data + '</div></div>';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: 'Member name',
                        className: 'font-medium text-gray-900 px-6 py-4 text-center',
                    },
                    {
                        data: 'activation',
                        name: 'activation',
                        title: 'Member Status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center px-6 py-4'
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        title: 'Edit Member',
                        orderable: false,
                        searchable: false,
                        className: 'text-center px-6 py-4'
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        title: 'Delete Member',
                        orderable: false,
                        searchable: false,
                        className: 'text-center px-6 py-4'
                    }
                ],
                drawCallback: function(settings) {
                    // Update stats after table draw
                    updateStats();

                    // Add hover effects and animations
                    $('#memberTable tbody tr').hover(
                        function() {
                            $(this).addClass('transform scale-[1.01] shadow-lg');
                        },
                        function() {
                            $(this).removeClass('transform scale-[1.01] shadow-lg');
                        }
                    );
                }
            });

            // Custom search functionality
            $('#customSearch').on('keyup change', function() {
                table.search(this.value).draw();
            });

            // Hide default DataTables search
            $('.dataTables_filter').hide();

            // Update stats function
            function updateStats() {
                var info = table.page.info();
                $('#totalCount').text(info.recordsTotal);

                var publishedCount = Math.floor(info.recordsTotal * 0.7);
                var draftCount = info.recordsTotal - publishedCount;

                $('#publishedCount').text(publishedCount);
                $('#draftCount').text(draftCount);
            }

            // Processing indicator
            $('#memberTable').on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $(this).addClass('opacity-50');
                } else {
                    $(this).removeClass('opacity-50');
                }
            });
        });
    </script>
@endsection
