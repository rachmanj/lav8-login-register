@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    reconcile
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data Reconciliation</h3>
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
        <a href="{{ route('reports.reconcile.delete_mine') }}" class="btn btn-sm btn-danger float-right mr-2" onclick="return confirm('Yakin nih mau menghapus data? Ga bisa dibalikin lagi lho datanya..')"><i class="fas fa-trash"></i> Delete All</a>
        <a href="{{ route('reports.reconcile.export') }}" class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-print"></i> Export</a>
        <button class="btn btn-sm btn-success float-right mr-2" data-toggle="modal" data-target="#reconcile-upload"><i class="fas fa-upload"></i> Upload</button>
      </div>

      <div class="card-body">
        <table id="reconcile-data" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>InvoiceNo</th>
            <th>VName</th>
            <th>ReceiveD</th>
            <th>Amount</th>
            <th>SPINo</th>
            <th>SPIDate</th>
          </tr>
          </thead>
        </table>
      </div>

    </div>
  </div>
</div>

{{-- MODAL UPLOAD --}}
<div class="modal fade" id="reconcile-upload">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Upload Data to reconciled</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('reports.reconcile.upload') }}" enctype="multipart/form-data" method="POST">
          @csrf
        <div class="modal-body">

            {{-- <div class="form-group">
                <label for="vendor_id">Vendor Name</label>
                  <select name="vendor_id" id="vendor_id" class="form-control select2bs4">
                    <option value="">-- select vendor --</option>
                    @foreach (\App\Models\Vendor::orderBy('vendor_name', 'asc')->get() as $vendor)
                      <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }}</option>
                    @endforeach
                  </select>
              </div> --}}
            <div class="form-group">
                <label>Data to upload</label>
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
        $("#reconcile-data").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('reports.reconcile.data') }}',
            columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'invoice_no'},
            {data: 'vendor_name'},
            {data: 'receive_date'},
            {data: 'amount'},
            {data: 'spi_no'},
            {data: 'spi_date'},
            ],
            fixedHeader: true,
            columnDefs: [
                {
                    "targets": [4],
                    "className": "text-right"
                }
            ]
        })
    });
  </script>
@endsection