@extends('templates.main')

@section('title_page')
    Invoice Payment
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Select invoice/s to pay</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="to_pay" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Inv. No</th>
            <th>Inv.Date</th>
            <th>Vendor</th>
            <th>PO No</th>
            <th>Project</th>
            <th>IDR</th>
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

<div class="row">
  <div class="col-12">

    <div class="card">
      
      <!-- /.card-header -->
      <div class="card-body">
        <table id="topay_incart" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Inv. No</th>
            <th>Inv.Date</th>
            <th>Vendor</th>
            <th>PO No</th>
            <th>Project</th>
            <th>IDR</th>
            <th></th>
          </tr>
          </thead>
        </table>
        <div class="card-footer">
          <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary">Make Payment</a>
        </div>
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
    $("#to_pay").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('payment_details.invtopay.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'inv_no'},
        {data: 'inv_date'},
        {data: 'vendor'},
        {data: 'po_no'},
        {data: 'project'},
        {data: 'nominal'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
      columnDefs: [
        {
          "targets": 6,
          "className": "text-right"
        }
      ],
    })

    $("#topay_incart").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('payment_details.inv_incart.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'inv_no'},
        {data: 'inv_date'},
        {data: 'vendor'},
        {data: 'po_no'},
        {data: 'project'},
        {data: 'nominal'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
      columnDefs: [
        {
          "targets": 6,
          "className": "text-right"
        }
      ],
    })
  });
</script>
@endsection
