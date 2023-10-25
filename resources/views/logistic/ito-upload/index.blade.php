@extends('templates.main')

@section('title_page')
   ITO Upload Page
@endsection

@section('breadcrumb_title')
  spis / ito
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
        @if (Session::has('error'))
          <div class="alert alert-danger">
            {{ Session::get('error') }}
          </div>
        @endif
        <h3 class="card-title">Upload ITO</h3>
        <a href="{{ route('logistic.ito-upload.undo') }}" class="btn btn-sm btn-danger float-right mx-2 {{ $itos_count == 0 ? 'disabled' : '' }}" onclick="return confirm('Are you sure you want to UNDO all just-updated records from the database?')">UNDO UPLOAD</a>
        <a href="{{ route('logistic.ito-upload.addtodb') }}" class="btn btn-sm btn-info float-right mx-2 {{ $itos_count == 0 ? 'disabled' : '' }}" onclick="return confirm('Are you sure you want to add all records to the database?')">Add To DB</a>
        <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#ito-upload"><i class="fas fa-upload"></i> Upload</button>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>ITO No.</th>
            <th>ITO Date</th>
            <th>Create Date</th>
            <th>To WH</th>
            <th>Project</th>
            <th>PO No</th>
            <th>Source</th>
            <th>Status</th>
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

{{-- MODAL UPLOAD --}}
<div class="modal fade" id="ito-upload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Upload ITO Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('logistic.ito-upload.upload') }}" enctype="multipart/form-data" method="POST">
        @csrf
      <div class="modal-body">

          <div class="form-group">
              <label>File to upload</label>
              <div class="form-group">
              <input type="file" name='file_upload' required class="form-control">
              </div>
          </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Upload</button>
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
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('logistic.ito-upload.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'document_date'},
        {data: 'ito_created_date'},
        {data: 'to_warehouse'},
        {data: 'project'},
        {data: 'doktams_po_no'},
        {data: 'source'},
        {data: 'status'},
        // {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
    })
  });
</script>
@endsection