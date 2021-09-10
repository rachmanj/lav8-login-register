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
        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-undo"></i> Back</a>
        <h3 class="card-title float-right">Add Additional Docs to Invoice</h3>
      </div>
      <div class="card-header">
        <h3 class="card-title">Invoice No. <b>{{ $invoice->inv_no }}</b> | PO No. <b>{{ $invoice->po_no ? $invoice->po_no : '' }}</b> | <b>{{ $invoice->vendor->vendor_name }}</b></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="possible_doktams" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Document No.</th>
            <th>Doc. Type</th>
            <th>PO No</th>
            <th>Receive Date</th>
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
        <table id="doktams_of_invoice" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Document No.</th>
            <th>Doc. Type</th>
            <th>PO No</th>
            <th>Receive Date</th>
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
    $("#possible_doktams").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('invoices.possible_data', $invoice->inv_id) }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'doctype'},
        {data: 'po_no'},
        {data: 'receive_date'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
    })

    $("#doktams_of_invoice").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('invoices.doktams_of_invoice.data', $invoice->inv_id) }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'doctype'},
        {data: 'po_no'},
        {data: 'receive_date'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
    })
  });
</script>
@endsection

