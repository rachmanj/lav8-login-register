@extends('templates.main')

@section('title_page')
    Invoices
@endsection

@section('breadcrumb_title')
    invoices
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <h3 class="card-title float-right">Invoices in Process</h3>
                    <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                        Invoice</a>
                </div>
                <!-- /.card-header -->

                <!-- Search Filters -->
                <div class="card-body border-bottom">
                    <form id="searchForm" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inv_no">Invoice Number</label>
                                    <input type="text" class="form-control form-control-sm" id="inv_no" name="inv_no"
                                        placeholder="Enter invoice number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vendor_id">Vendor</label>
                                    <select class="form-control form-control-sm select2" id="vendor_id" name="vendor_id">
                                        <option value="">-- Select Vendor --</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="po_no">PO Number</label>
                                    <input type="text" class="form-control form-control-sm" id="po_no" name="po_no"
                                        placeholder="Enter PO number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <select class="form-control form-control-sm select2" id="project_id" name="project_id">
                                        <option value="">-- Select Project --</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->project_id }}">{{ $project->project_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="searchBtn" class="btn btn-sm btn-primary float-right">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-sm btn-default float-right mr-2">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.search filters -->

                <div class="card-body">
                    <table id="invoicesTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Invoice</th>
                                <th width="10%">Receive Date</th>
                                <th width="20%">Vendor</th>
                                <th width="12%">PO No</th>
                                <th width="10%">Project</th>
                                <th width="10%">Amount</th>
                                <th width="8%">Days</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 31px;
        }

        .dataTables_processing {
            z-index: 999;
            background-color: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: middle;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .select2-container--bootstrap4 .select2-selection--single {
            padding-top: 2px;
            padding-bottom: 2px;
        }
    </style>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            // Initialize Select2 with lazy loading for better performance
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                minimumResultsForSearch: 10 // Only show search box when there are at least 10 options
            });

            // Initialize DataTable with optimized settings
            var table = $("#invoicesTable").DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                retrieve: true,
                stateSave: true, // Save the state of the table
                searching: false, // Disable built-in search as we have custom filters
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                pageLength: 25,
                ajax: {
                    url: '{{ route('invoices.data') }}',
                    data: function(d) {
                        d.inv_no = $('#inv_no').val();
                        d.vendor_id = $('#vendor_id').val();
                        d.po_no = $('#po_no').val();
                        d.project_id = $('#project_id').val();
                    },
                    error: function(xhr, error, thrown) {
                        console.log('Ajax error:', error);
                        $('#invoicesTable_processing').hide();
                        alert('Error loading data. Please try again.');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'invoice_info',
                        name: 'invoice_info'
                    },
                    {
                        data: 'receive_date'
                    },
                    {
                        data: 'vendor'
                    },
                    {
                        data: 'po_no'
                    },
                    {
                        data: 'project'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'days_diff',
                        render: function(data) {
                            if (data === null) return 'N/A';
                            // Add color based on the number of days
                            if (data > 30) {
                                return '<span class="badge badge-danger">' + data + '</span>';
                            } else if (data > 14) {
                                return '<span class="badge badge-warning">' + data + '</span>';
                            } else {
                                return '<span class="badge badge-success">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [7, 'desc']
                ], // Order by days by default (oldest first)
                responsive: true,
                fixedHeader: {
                    header: true,
                    headerOffset: $('.main-header').outerHeight()
                },
                columnDefs: [{
                    "targets": 6,
                    "className": "text-right"
                }],
                drawCallback: function() {
                    // Initialize tooltips
                    $('[data-toggle="tooltip"]').tooltip();
                },
                initComplete: function() {
                    // Hide the processing indicator after initial load
                    $('#invoicesTable_processing').hide();
                }
            });

            // Optimize search button click event with debounce
            var searchTimeout;
            $('#searchBtn').on('click', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    table.draw();
                }, 300);
            });

            // Reset button click event
            $('#resetBtn').on('click', function() {
                $('#searchForm')[0].reset();
                $('.select2').val('').trigger('change');
                table.draw();
            });

            // Enter key press in search fields
            $('#searchForm input').keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#searchBtn').click();
                }
            });

            // Optimize Select2 initialization
            $(document).on('select2:open', function() {
                document.querySelector('.select2-search__field').focus();
            });

            // Preload the most common data
            setTimeout(function() {
                $.ajax({
                    url: '{{ route('invoices.data') }}',
                    data: {
                        preload: true,
                        length: 10
                    },
                    dataType: 'json'
                });
            }, 1000);
        });
    </script>
@endsection
