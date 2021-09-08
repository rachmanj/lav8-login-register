@extends('templates.main')

@section('title_page')
    SPI
@endsection

@section('breadcrumb_title')
    spi
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('accounting.spi_index') }}" class="btn btn-sm btn-primary">Back</a>
        <a href="{{ route('accounting.spi_print_pdf', $spi->id) }}" class="btn btn-sm btn-success" target="_blank">View PDF</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>INVOICE NO.</th>
              <th>INVOICE DATE</th>
              <th>VENDOR</th>
              <th>PO NO</th>
              <th>PROJECT</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($spi->invoices as $invoice)
                <tr>
                  <th>{{ $loop->iteration }}</th>
                  <th>{{ $invoice->inv_no }}</th>
                  <th>{{ date('d-M-Y', strtotime($invoice->inv_date)) }}</th>
                  <th>{{ $invoice->vendor->vendor_name }}</th>
                  <th>{{ $invoice->po_no }}</th>
                  <th>{{ $invoice->project->project_code }}</th>
                </tr>
                  @if ($invoice->doktams->count() > 0)
                    <thead>
                      <tr>
                        <th colspan="2" class="text-right">Additional Docs:</th>
                        <th>Document Type</th>
                        <th colspan="2">Dokumen No</th>
                      </tr>
                    </thead>
                      <tbody>
                        @foreach ($invoice->doktams as $doktam)
                          <tr>
                            <td colspan="2"></td>
                            <td>{{ $doktam->doctype->docdesc }}</td>
                            <td colspan="2">{{ $doktam->document_no }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
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
      ajax: '{{ route('accountingInvoices.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'inv_no'},
        {data: 'inv_date'},
        {data: 'vendor'},
        {data: 'po_no'},
        {data: 'project', orderable: false, searchable: false},
        {data: 'amount'},
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