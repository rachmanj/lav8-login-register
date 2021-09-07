@extends('templates.main')

@section('title_page')
  Additional Documents
@endsection

@section('breadcrumb_title')
    pendingDocs
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Receive Document</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>Document No</label>
                  <input type="text" class="form-control" value="{{ $doktam->document_no }}" readonly>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Document Type</label>
                  <input type="text" class="form-control" value="{{ $doktam->doctype->docdesc }}" readonly>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Invoice No.</label>
                  <input type="text" class="form-control" value="{{ $doktam->invoice->inv_no }}" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  <label>PO No</label>
                  <input type="text" class="form-control" value="{{ $doktam->invoice->po_no }}" readonly>
                </div>
              </div>
              <div class="col-9">
                <div class="form-group">
                  <label>Vendor</label>
                  <input type="text" class="form-control" value="{{ $doktam->invoice->vendor->vendor_name }}" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <form action="{{ route('doktams.update', $doktam->id) }}" method="POST">
                  @csrf @method('PUT')
                  <div class="input-group input-group-md">
                    <input type="date" name="receive_date" class="form-control" autofocus>
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-info btn-flat"><i class="fas fa-save"></i> Save</button>
                    </span>
                  </div>
                </form>
              </div>              
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection