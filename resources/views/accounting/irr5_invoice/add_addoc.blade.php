@extends('templates.main')

@section('title')
    Additional Documents
@endsection

@section('breadcrumb_title')
    addocs
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-new_addoc"><i class="fas fa-plus"></i>
          Additional Document
        </button>
        {{-- <a href="{{ route('accounting.') }}"></a> --}}
        <h3 class="card-title  float-right">Invoice No. <b>{{ $invoice->inv_no }}</b> | PO No. <b>{{ $invoice->po_no ? $invoice->po_no : '' }}</b></h3>
        </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Doc No</th>
            <th>Doc Type</th>
            <th>Receive D</th>
            <th>Creator</th>
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


<div class="modal fade" id="modal-new_addoc">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Additional Doc</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('accounting.store_addoc', $invoice->inv_id) }}" method="POST">
        @csrf
      <div class="modal-body">
        <div class="form-group">
          <label>Document No</label>
          <input class="form-control" name="docnum">
        </div>
        <div class="form-group">
          <label>Document Type</label>
          <select name="doctype" class="form-control">
            <option value="">-- select --</option>
            @foreach ($doctypes as $doctype)
                <option value="{{ $doctype->doctype_id }}">{{ $doctype->docdesc }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Receive Date</label>
          <input type="date" class="form-control" name="docreceive">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>  Save</button>
      </div>
    </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('addocsByInvoice.data', $inv_id) }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'docnum'},
        {data: 'doctype'},
        {data: 'docreceive'},
        {data: 'created_by'},
        {data: 'action'},
      ],
      fixedHeader: true,
    })
  });
</script>
@endsection