@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <main class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 pb-6 border-b border-gray-300">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-chart-area text-blue-600 mr-3"></i>
                    News Management System
                    <span class="font-normal text-gray-600 ml-2">News Edit Panel</span>
                </h1>
                <p class="text-gray-700 mt-2 font-medium">Comprehensive news information and location management</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('news.create-news') }}">
                    <button class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-all duration-200 hover:shadow-lg border border-blue-600">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Entry
                    </button>
                </a>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-300">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-newspaper text-blue-600 mr-3"></i>
                    News Articles Database
                    <span class="font-medium text-gray-600 ml-2">| Content Management</span>
                </h2>
            </div>

            <!-- Table Content -->
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="newsTable" class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-300">
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">#</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Title</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Status</th>
                                <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider border-r border-gray-200">Edit</th>
                                <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- DataTable will populate this -->
                        </tbody>
                    </table>
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
            $('#newsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('news.index.json') }}',
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[0, 'asc']],
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
                    processing: "Processing request...",
                    search: "Search records:",
                    lengthMenu: "Display _MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No records available",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columns: [
                    {
                        data: 'index',
                        name: 'index',
                        title: 'Serial No.',
                        className: 'font-medium'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        title: 'Article Title',
                        className: 'font-medium'
                    },
                    {
                        data: 'activation',
                        name: 'activation',
                        title: 'Publication Status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        title: 'Edit Action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        title: 'Delete Action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
        });
    </script>

    <style>
        /* Custom formal styling for DataTable */
        #newsTable_wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #newsTable thead th {
            background-color: #f8fafc;
            font-weight: 700;
        }

        #newsTable tbody tr:hover {
            background-color: #f1f5f9;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 0;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }
    </style>
@endsection
