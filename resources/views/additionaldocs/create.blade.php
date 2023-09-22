@extends('templates.main')

@section('title_page')
    Additional Documents
@endsection

@section('breadcrumb_title')
    addocs
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title float-right">New Additional Document</h3>
            <a href="{{ route('additionaldocs.receive.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
          <div class="card-body">

            <form action="{{ route('additionaldocs.receive.store') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-8">
  
                  <div class="form-group">
                    <label>Document No</label>
                    <input type="text" name="document_no" class="form-control @error('document_no') is-invalid @enderror" autofocus>
                    @error('document_no')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                  </div>
  
                  <div class="form-group">
                    <label>Document Type</label>
                    <select name="doctypes_id" class="form-control select2bs4 @error('doctypes_id') is-invalid @enderror" style="width: 100%;">
                      <option value="">-- select type --</option>
                      @foreach ($doctypes as $doctype)
                        <option {{ old('doctypes_id') == $doctype->doctype_id ? "selected" : "" }} value="{{ $doctype->doctype_id }}">{{ $doctype->docdesc }}</option>
                      @endforeach
                    </select>
                    @error('doctypes_id')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
  
                  <div class="form-group">
                    <label>PO No</label>
                    <input type="text" name="doktams_po_no" class="form-control @error('doktams_po_no') is-invalid @enderror">
                    @error('doktams_po_no')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                  </div>

                  <div class="form-group">
                    <label>Receive Date</label>
                    <input type="date" name="receive_date" class="form-control @error('receive_date') is-invalid @enderror">
                    @error('receive_date')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                  </div>
  
                  <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
                  </div>
  
                </div> <!-- .col-8 -->
              </div> <!-- .row -->
            </form>

          </div>
        </div>
      </div>
    </div>
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