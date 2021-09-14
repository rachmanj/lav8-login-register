@extends('templates.main')

@section('title_page')
    Additional Documents
@endsection

@section('breadcrumb_title')
    pendingDocs
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
        <h3 class="card-title">Pending Documents</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Doc No</th>
            <th>Doc Type</th>
            <th>Inv No</th>
            <th>Inv Date</th>
            <th>PO No</th>
            <th>Project</th>
            <th>Vendor</th>
            <th>Days</th>
            <th><i class="fas fa-comments"></i></th>
            <th></th>
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
    $("#example1").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('doktams.index.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'doctype'},
        {data: 'inv_no'},
        {data: 'inv_date'},
        {data: 'po_no'},
        {data: 'project'},
        {data: 'vendor'},
        {data: 'days'},
        {data: 'comments'},
        {data: 'action', orderable: false, searchable: false},
      ],
      rowCallback: function(row, data, index) {
        if(data.days > 5) {
          $(row).css('color','red')
        }
      },
      fixedHeader: true,
      columnDefs: [
        {
          "targets": 8,
          "className": "text-right"
        },
        {
          "targets": 9,
          "className": "text-center"
        },
      ],
    })
  });
</script>
@endsection