@extends('templates.main')

@section('title_page')
   Reports
@endsection

@section('breadcrumb_title')
    doktams
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Change Additional Doc Status (doktams table) to <b>"CANCEL"</b></h5>
              <a href="{{ route('reports.report7.index') }}" class="btn btn-sm btn-success float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">

            <form action="{{ route('reports.report7.update', $doktam->id) }}" method="POST">
              @csrf @method('PUT')
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>Document No.</label>
                  <input type="text" value="{{ $doktam->document_no }}" class="form-control" readonly>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Document Type</label>
                  <input type="text" value="{{ $doktam->doctype->docdesc }}" class="form-control" readonly>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Receive Date</label>
                  <input type="text" value="{{ date('d-M-Y', strtotime($doktam->receive_date)) }}" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>PO No</label>
                  <input type="text" class="form-control" value="{{ $doktam->doktams_po_no }}" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Delete Reason</label>
                  <textarea name="delete_reason" class="form-control" cols="5" rows="3"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
              </div>
            </div>
          </form>

          </div>
        </div>
      </div>
    </div>
@endsection
