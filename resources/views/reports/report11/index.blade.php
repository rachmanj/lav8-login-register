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
        @if (Session::has('error'))
          <div class="alert alert-danger">
            {{ Session::get('error') }}
          </div>
        @endif
        <h3 class="card-title">Search Invoices by Invoice No or PO No</h3>
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
      </div>
      <div class="card-body">
        <form action="{{ route('reports.report11.display') }}" method="POST">
          @csrf
          <div class="col-6">
            <div class="form-group">
            <label>Invoice No</label>
            <input type="text" name="invoice_no" class="form-control">
            </div>
          </div>
          <label>OR</label>
          <div class="col-6">
            <div class="form-group">
              <label>PO No</label>
              <input type="text" name="po_no" class="form-control">
            </div>
          </div>
          <div class="card-footer">
            <button type="reset" class="btn btn-sm btn-warning">Clear</button>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection