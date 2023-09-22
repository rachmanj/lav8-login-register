@extends('templates.main')

@section('title_page')
    Additional Documents
@endsection

@section('breadcrumb_title')
    search
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        @if (Session::has('danger'))
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('danger') }}
            </div>
        @endif
        <h3 class="card-title">Search for Documents</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form accept="{{ route('additionaldocs.search.search_result') }}" class="form-horizontal" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Document No</label>
                <div class="col-sm-10">
                <input type="text" name="document_no" class="form-control" placeholder="Document No" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Invoice No</label>
                <div class="col-sm-10">
                    <input type="text" name="invoice_no" class="form-control" placeholder="Invoice No" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">PO No</label>
                <div class="col-sm-10">
                    <input type="text" name="po_no" class="form-control" placeholder="PO No" autocomplete="off">
                </div>
            </div>
            {{-- <div class="form-group row">
                <label class="col-sm-2 col-form-label">Document Type</label>
                <div class="col-sm-10">
                    <select name="document_type_id" id="" class="form-control select2bs4">
                    <option value="">-- select document type --</option>
                    @foreach ($document_types as $item)
                        <option value="{{ $item->doctype_id }}">{{ $item->docdesc }}</option>
                    @endforeach
                    </select>
                </div>
            </div> --}}
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info btn-sm">Search</button>
        </div>
        <!-- /.card-footer -->
    </form>
</div>
@endsection

{{-- @section('styles')
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
@endsection --}}