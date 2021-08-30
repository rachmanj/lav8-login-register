@extends('templates.main')

@section('title_page')
    Send Invoice
@endsection




@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        @if (Session::has('status'))
          <div class="alert alert-success">
            {{ Session::get('status') }}
          </div>
        @endif
        <h3 class="card-title">Invoices to Send</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="to_send" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Inv. No</th>
            <th>Inv.Date</th>
            <th>Vendor</th>
            <th>PO No</th>
            <th>Project</th>
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
      <div class="card-header">
        <div class="col-md-6">
          <a href="{{ route('view_spi') }}" class="btn btn-md btn-primary">View SPI</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="invoice_incart" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Inv. No</th>
            <th>Inv.Date</th>
            <th>Vendor</th>
            <th>PO No</th>
            <th>Project</th>
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
    $("#to_send").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('tosent_index.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'inv_no'},
        {data: 'inv_date'},
        {data: 'vendor'},
        {data: 'po_no'},
        {data: 'project', orderable: false, searchable: false},
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

    $("#invoice_incart").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('cart_index.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'inv_no'},
        {data: 'inv_date'},
        {data: 'vendor'},
        {data: 'po_no'},
        {data: 'project', orderable: false, searchable: false},
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

