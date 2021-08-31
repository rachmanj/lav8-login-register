@extends('templates.main')

@section('title_page')
Invoices Detail <h6 class="text-success">(connect with table doktams)</h6>
@endsection

@section('breadcrumb_title')
    doktam
@endsection

@section('content')
<div class="row">
  <div class="col-md-10">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Receive Additional Document</h3>
      </div>
      <div class="card-header">
        <a class="btn btn-primary" href="{{ route('accounting.doktam_invoices.show', $doktam->invoices_id) }}"> Back</a>
      </div>
      <form action="{{ route('update_doktam', $doktam->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Document No</label>
                <input class="form-control" value="{{ $doktam->document_no }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Document Type</label>
                <input class="form-control" value="{{ $doktam->doctype->docdesc }}" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label><b>RECEIVE DATE</b></label>
                <input type="date" name="receive_date" class="form-control" value="{{ old('receive_date', $doktam->receive_date) }}">
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