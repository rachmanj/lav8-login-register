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
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <a href="{{ route('reports.report12.index') }}">With Attachment</a> |
                    <a href=""><b>No Attachment</b></a>
                    <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i
                            class="fas fa-undo"></i> Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Inv. No</th>
                                <th>Inv.Date</th>
                                <th>Vendor</th>
                                <th>PO No</th>
                                <th>Project</th>
                                <th>Amount</th>
                                <th>attachment</th>
                            </tr>
                        </thead>
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
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                deferRender: true,
                ajax: {
                    url: '{{ route('reports.report12.nodocs_index.data') }}',
                    type: 'GET'
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
                columnDefs: [{
                    "targets": 6,
                    "className": "text-right"
                }],
                order: [
                    [2, 'desc']
                ]
            });
        });
    </script>
@endsection
