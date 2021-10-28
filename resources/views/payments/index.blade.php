@extends('templates.main')

@section('title_page')
    Invoice Payment
@endsection

@section('breadcrumb_title')
    payment
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
        <a href="{{ route('payment_details.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Payment</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="payments" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Date</th>
            <th>Count</th>
            <th>Total</th>
            <th>Creator</th>
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
      ajax: '{{ route('payments.index.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'date'},
        {data: 'count_inv'},
        {data: 'invoices_total'},
        {data: 'creator'},
        {data: 'action'},
      ],
      fixedHeader: true,
      columnDefs: [
        {
          "targets": [2,3],
          "className": "text-right"
        }
      ],
    })
  });
</script>
@endsection