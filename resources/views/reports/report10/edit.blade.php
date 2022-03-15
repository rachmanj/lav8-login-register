@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    additional_docs
@endsection

@section('content')
    <div class="row">
      <div class="col-10">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Attach Documents</h3>
            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-4">Document No</dt>
              <dd class="col-sm-8">: {{ $document->document_no }}</dd>
              <dt class="col-sm-4">Type</dt>
              <dd class="col-sm-8">: {{ $document->doctype->docdesc }}</dd>
              <dt class="col-sm-4">Receive Date</dt>
              <dd class="col-sm-8">: {{ $document->receive_date ? date('d-M-Y', strtotime($document->receive_date)) : ' - ' }}</dd>
              <dt class="col-sm-4">Vendor</dt>
              <dd class="col-sm-8">: {{ $document->invoice->vendor->vendor_name }}</dd>
              <dt class="col-sm-4">Invoice No</dt>
              <dd class="col-sm-8">: {{ $document->invoice->inv_no }}</dd>
              <dt class="col-sm-4">Project</dt>
              <dd class="col-sm-8">: {{ $document->invoice->project->project_code }}</dd>
            </dl>
          </div>
          <div class="card-footer">
            <button class="btn btn-sm btn-primary mx-2" data-toggle="modal" data-target="#modal-upload"><i class="fas fa-upload"></i> Upload</button>
          </div>
        </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-upload">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Document Upload</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('reports.report10.update', $document->id) }}" enctype="multipart/form-data" method="POST">
            @csrf @method('PUT')

          <div class="modal-body">
              <label>Pilih file </label>
              <div class="form-group">
                <input type="file" name='file_upload' required class="form-control" autofocus>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm"> Upload</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection