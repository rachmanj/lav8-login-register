@extends('templates.main')

@section('title_page')
   ITO Monitoring
@endsection

@section('breadcrumb_title')
  logistic / ito-monitoring
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
        <h3 class="card-title">ITO</h3>
        <button class="btn btn-sm btn-info float-right mx-2" data-toggle="modal" data-target="#update-many"> Update Many</button>
        {{-- <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#update-all"> Update All</button> --}}
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>ITO No.</th>
            <th>ITO Date</th>
            <th>DeliveryD</th>
            <th>To WH</th>
            <th>PO No</th>
            <th>TA No</th>
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

{{-- UPDATE MANY --}}
<div class="modal fade" id="update-many">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Many ITOs</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('logistic.ito-monitoring.update_many') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="receiveback_date">Payment Date</label>
            <input type="date" name="receiveback_date" id="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
          </div>
          <div class="form-group">
            <label>Select ITOs to Update</label>
            <div class="select2-purple">
              <select name="ito_ids[]" class="select2 form-control" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select ITOs" style="width: 100%;">
                @foreach ($itos as $item)
                  <option value="{{ $item->id }}">{{ $item->document_no . ' | ' . $item->project->project_code }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('logistic.ito-monitoring.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'document_date'},
        {data: 'delivery_date'},
        {data: 'to_warehouse', orderable: false, searchable: false},
        {data: 'doktams_po_no'},
        {data: 'ta_no'},
        {data: 'days'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
      columnDefs: [
        {
          "targets": [7],
          "className": "text-right"
        }
      ]
    })
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  }) 
</script>
@endsection