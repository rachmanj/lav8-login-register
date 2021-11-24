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
        @if (Session::has('success'))
          <div class="alert alert-success">
            {{ Session::get('success') }}
          </div>
        @endif
        <h5 class="card-title">{{ $nama_report }}</h5>
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
      </div>
      <div class="card-header">
        <div class="col-6">
          <p><b>Document No</b></p>
          <div class="input-group input-group-sm">
            <input type="text" name="document_no" class="form-control" value="{{ $doktam->document_no }}">
            <span class="input-group-append">
              <button type="submit" class="btn btn-info btn-flat">Submit</button>
            </span>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="document_no">Document No</label>
              <input type="text" class="form-control" value="{{ $doktam->document_no }}" disabled>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="doctype">Document Type</label>
              <input type="text" class="form-control" value="{{ $doktam->doctype->docdesc }}" disabled>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="document_date">Document Date</label>
              <input type="text" class="form-control" value="{{ date('d-M-Y', strtotime($doktam->receive_date)) }}" disabled>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="invoice_no">Invoice No</label>
              <input type="text" class="form-control" value="{{ $doktam->invoice ? $doktam->invoice->inv_no : null }}" disabled>
            </div>
          </div>
          <div class="col-8">
            <form action="{{ route('reports.report98.update', $doktam->id) }}" method="POST">
              @csrf @method('PUT')
              <div class="form-group">
                <label>New Invoice No <small>Only invoices from same vendor and already has SPI are visible</small></label>
                <select name="invoices_id" id="invoices_id" class="form-control select2bs4" autofocus>
                  <option value="">-- select Invoice --</option>
                  @foreach ($invoices as $invoice)
                      <option value="{{ $invoice->inv_id }}">{{ $invoice->inv_no . ' - ' . $invoice->vendor->vendor_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-primary">
              <i class="fas fa-save"></i> Save
            </button>
          </div>
        </form>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('styles')
    <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    }) 
  </script>
@endsection