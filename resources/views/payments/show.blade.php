@extends('templates.main')

@section('title_page')
    Payments
@endsection

@section('breadcrumb_title')
    payments
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-undo"></i> Back</a>
        {{-- <a href="{{ route('spi_pdf') }}" class="btn btn-md btn-success" target="_blank">View PDF</a> --}}
      </div>
      <div class="card-header">
        <dl class="row">
          <dt class="col-sm-2">Date</dt>
          <dd class="col-sm-10">: {{ date('d F Y', strtotime($payment->date)) }}</dd>
          <dt class="col-sm-2">Remarks</dt>
          <dd class="col-sm-10">: {{ $payment->remarks }}</dd>
        </dl>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Inv No</th>
              <th>Inv Date</th>
              <th>Vendor</th>
              <th>PO No</th>
              <th>Project</th>
              <th class="text-center">IDR</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($payment->payment_details as $details)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $details->invoice->inv_no }}</td>
                  <td>{{ date('d-M-Y', strtotime($details->invoice->inv_date)) }}</td>
                  <td>{{ $details->invoice->vendor->vendor_name }}</td>
                  <td>{{ $details->invoice->po_no }}</td>
                  <td>{{ $details->invoice->project->project_code }}</td>
                  <td class="text-right">{{ number_format($details->invoice->inv_nominal, 0) }}</td>
                </tr>
            @endforeach
            <tr>
              <th colspan="6" class="text-right">Total</th>
              <th class="text-right">{{ number_format($payment->invoices_total, 0) }}</th>
            </tr>
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