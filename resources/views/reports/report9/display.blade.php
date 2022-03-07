@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    invoices
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
        <form action="{{ route('reports.report9.display') }}" method="POST">
          @csrf
          <div class="col-5">
            <label>Select month & receive place</label>
            <div class="input-group mb-3">
              <input type="month" name="date" class="form-control rounded-0" value="{{ $date }}">
              <span class="input-group-append">
                <select name="receive_place" >
                  <option value="BPN" {{ $receive_place === 'BPN' ? 'selected' : '' }}>BPN</option>
                  <option value="JKT" {{ $receive_place === 'JKT' ? 'selected' : '' }}>JKT</option>
                </select>
              </span>
              <span class="input-group-append">
                <button type="submit" class="btn btn-success btn-flat">Go!</button>
              </span>
            </div>
          </div>
        </form>
      </div>
      <div class="card-header">
        <h5 class="card-title">{{ $report_name }}</h3>
      </div>
      <div class="card-body">
        <table id="report9" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Inv. No</th>
              <th>InvD</th>
              <th>RecD</th>
              <th>Vendor</th>
              <th>PO No</th>
              <th>Project</th>
              <th>Amount</th>
              <th>Sta</th>
              <th>SpiD</th>
              <th>days</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invoices as $invoice)
                <tr class="{{ $invoice->mailroom_bpn_date ? '' : 'text-red' }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $invoice->inv_no }}</td>
                  <td>{{ date('d-M-Y', strtotime($invoice->inv_date)) }}</td>
                  <td>{{ date('d-M-Y', strtotime($invoice->receive_date)) }}</td>
                  <td>{{ $invoice->vendor->vendor_name }}</td>
                  <td>{{ $invoice->po_no }}</td>
                  <td>{{ $invoice->project->project_code }}</td>
                  <td class="text-right">{{ number_format($invoice->inv_nominal, 0) }}</td>
                  <td>{{ $invoice->sent_status }}</td>
                  <td class="text-center">{{ $invoice->mailroom_bpn_date ? date('d-M-Y', strtotime($invoice->mailroom_bpn_date)) : '-' }}</td>
                  <td class="text-right">{{ $invoice->mailroom_bpn_date ? $invoice->days : $invoice->days_out }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
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
  $(document).ready(function() {
    $('#report9').DataTable();
  });
</script>
@endsection