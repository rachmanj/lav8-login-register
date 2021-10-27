@extends('templates.main')

@section('title_page')
    Additional Document
@endsection

@section('breadcrumb_title')
    doktams
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Document</h3>
            <a href="{{ route('reports.report5') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <form action="{{ route('reports.report5.update', $ito->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">

              <div class="col-6">
                <div class="form-group">
                  <label>Document No</label>
                  <input type="text" value="{{ $ito->document_no }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Document Type</label>
                  <input type="text" value="{{ $ito->doctype->docdesc }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label for="doktams_po_no">PO No</label>
                  <input type="text" name="doktams_po_no" class="form-control">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection