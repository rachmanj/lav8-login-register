@extends('templates.main')

@section('title_page')
    Additional Documents
@endsection

@section('breadcrumb_title')
    addocs
@endsection

@section('content')
<div class="row">
  <div class="col-md-10">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Receive Additional Document</h3>
      </div>
      <form action="{{ route('accounting.update_addoc', $addoc->addoc_id) }}" method="POST">
        @csrf @method('PUT')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Document No</label>
                <input class="form-control" value="{{ $addoc->docnum }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Document Type</label>
                <input class="form-control" value="{{ $addoc->addoctype->docdesc }}" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label><b>RECEIVE DATE</b></label>
                <input type="date" name="docreceive" class="form-control" value="{{ old('docreceive') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Invoice No</label>
                <input class="form-control" value="{{ $addoc->invoice->inv_no }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Invoice Date</label>
                <input class="form-control" value="{{ date('d-M-Y', strtotime($addoc->invoice->inv_date)) }}" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>PO No</label>
                <input class="form-control" value="{{ $addoc->invoice->po_no }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Project</label>
                <input class="form-control" value="{{ $addoc->invoice->project->project_code }}" readonly>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>  Save</button>
            </div>
          </div>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection