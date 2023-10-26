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
            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
          <div class="card-body">
            <table id="report7" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Doc No</th>
                <th>Doc Type</th>
                <th>Receive Date</th>
                <th>PO No</th>
                <th class="text-center">Days</th>
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
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

<script>
  $(function () {
    $("#report7").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('reports.report7.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'doctype'},
        {data: 'receive_date'},
        {data: 'doktams_po_no'},
        {data: 'days'},
        {data: 'action'},
      ],
      fixedHeader: true,
      columnDefs: [
        {
          "targets": [5],
          "className": "text-right"
        }
      ],
    })
  });
</script>
@endsection
