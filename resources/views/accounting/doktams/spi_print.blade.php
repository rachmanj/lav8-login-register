@extends('templates.main')

@section('title_page')
    Invoices (Doktam)
@endsection

@section('breadcrumb_title')
    invoices
@endsection

@section('content')
<div class="row">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Inv.No</th>
        <th>Inv.Date</th>
        <th>Vendor</th>
        <th>PO</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($invoices as $invoice)
          <tr>
            <th>{{ $loop->iteration }}</th>
            <th>{{ $invoice->inv_no }}</th>
            <th>{{ $invoice->inv_date }}</th>
            <th>{{ $invoice->vendor->vendor_name }}</th>
            <th>{{ $invoice->po_no }}</th>
          </tr>
            @if ($invoice->doktams->count() > 0)
              <thead>
                <tr>
                  <td class="text-right">Additional Docs:</td>
                  <td>Type</td>
                  <td>Dokumen No</td>
                </tr>
              </thead>
                <tbody>
                  @foreach ($invoice->doktams as $doktam)
                    <tr>
                      <td></td>
                      <td>{{ $doktam->doctype->docdesc }}</td>
                      <td>{{ $doktam->document_no }}</td>
                    </tr>
                @endforeach
                </tbody>
            @endif
      @endforeach
    </tbody>
  </table>
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