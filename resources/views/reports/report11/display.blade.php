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
            <h3 class="card-title">Invoices</h3>
            <a href="{{ route('reports.report11.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>invoice No</th>
                  <th>PO</th>
                  <th>Date</th>
                  <th class="text-right">IDR</th>
                  <th>Vendor</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                @if ($invoices)
                  @foreach ($invoices as $invoice)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $invoice->inv_no }}</td>
                      <td>{{ $invoice->po_no }}</td>
                      <td>{{ $invoice->inv_date ? date('d-m-Y', strtotime($invoice->inv_date)) : '' }}</td>
                      <td class="text-right">{{ $invoice->inv_nominal ? number_format($invoice->inv_nominal, 0) : '-' }}</td>
                      <td>{{ $invoice->vendor->vendor_name }}</td>
                      <td>
                        <a href="{{ route('reports.report11.edit', $invoice->inv_id) }}" class="btn btn-warning btn-xs"><i class="fas fa-file-import"></i> Attach Docs</a>
                        <a href="{{ asset('document_upload/'. $invoice->filename) }}" class="btn btn-info btn-xs" target="_blank"><i class="fas fa-search"></i> Preview</a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" class="text-center">No data available</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection