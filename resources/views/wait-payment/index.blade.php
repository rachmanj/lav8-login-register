@extends('templates.main')

@section('title_page')
    Invoice Wait Payment
@endsection

@section('breadcrumb_title')
    wait-payment
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
        <h3 class="card-title">Send to Payreq-System</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="payments" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Inv No</th>
            <th>Vendor</th>
            <th>ReceiveD</th>
            <th>Amount</th>
            <th>Days</th>
            <th>action</th>
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
    $("#payments").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('wait-payment.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'inv_no'},
        {data: 'vendor'},
        {data: 'receive_date'},
        {data: 'inv_nominal'},
        {data: 'days'},
        {data: 'action'},
      ],
      fixedHeader: true,
      columnDefs: [
        {
          "targets": [4, 5],
          "className": "text-right"
        }
      ],
    })
  });
</script>
@endsection