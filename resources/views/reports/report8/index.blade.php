@extends('templates.main')

@section('title_page')
    Reports
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
                        <div class="alert alert-success alert-dismissible">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                    @endif
                    <h5 class="card-title">{{ $nama_report }}</h5>
                    <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i
                            class="fas fa-undo"></i> Back</a>
                </div>

                <!-- Search Form -->
                <div class="card-body">
                    <form id="searchForm" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inv_no">Invoice Number</label>
                                    <input type="text" class="form-control" id="inv_no" name="inv_no"
                                        placeholder="Enter invoice number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="po_no">PO Number</label>
                                    <input type="text" class="form-control" id="po_no" name="po_no"
                                        placeholder="Enter PO number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vendor_id">Vendor Name</label>
                                    <select class="form-control select2" id="vendor_id" name="vendor_id">
                                        <option value="">-- Select Vendor --</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor['id'] }}">{{ $vendor['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="project_code">Project</label>
                                    <input type="text" class="form-control" id="project_code" name="project_code"
                                        placeholder="Enter project code">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
                                <button type="button" id="resetBtn" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </form>

                    <table id="report8" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Inv No</th>
                                <th>Inv Date</th>
                                <th>Vendor</th>
                                {{-- <th>Branch</th> --}}
                                <th>Receive</th>
                                <th>at</th>
                                <th>PO</th>
                                <th>Project</th>
                                <th>Amount</th>
                                <th>action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            var table = $("#report8").DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                deferRender: true,
                ajax: {
                    url: '{{ route('reports.report8.data') }}',
                    type: 'GET',
                    data: function(d) {
                        d.inv_no = $('#inv_no').val();
                        d.po_no = $('#po_no').val();
                        d.vendor_id = $('#vendor_id').val();
                        d.project_code = $('#project_code').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'inv_no'
                    },
                    {
                        data: 'inv_date'
                    },
                    {
                        data: 'vendor'
                    },
                    // {data: 'branch'},
                    {
                        data: 'receive_date'
                    },
                    {
                        data: 'receive_place'
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
                        data: 'action'
                    },
                ],
                fixedHeader: true,
                columnDefs: [{
                    "targets": [8],
                    "className": "text-right"
                }],
                order: [
                    [4, 'desc']
                ] // Order by receive date by default
            });

            // Search button click
            $('#searchBtn').on('click', function() {
                table.draw();
            });

            // Reset button click
            $('#resetBtn').on('click', function() {
                $('#searchForm')[0].reset();
                $('#vendor_id').val('').trigger('change'); // Reset Select2
                table.draw();
            });

            // Enter key in search fields
            $('#searchForm input').keypress(function(e) {
                if (e.which == 13) { // Enter key
                    e.preventDefault();
                    table.draw();
                }
            });
        });
    </script>
@endsection
