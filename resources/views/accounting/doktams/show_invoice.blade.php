@extends('templates.main')

@section('title_page')
Invoices Detail <h6 class="text-success">(connect with table doktams)</h6>
@endsection

@section('breadcrumb_title')
    invoice
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        <div class="row">
          {{-- <h3 class="card-title">Invoice No. <b>{{ $invoice->inv_no }}</b> | PO No. <b>{{ $invoice->po_no ? $invoice->po_no : '' }}</b></h3> --}}
          <dl class="row">
            <dt class="col-sm-4">Invoice No.</dt>
            <dd class="col-sm-8">: {{ $invoice->inv_no }}</dd>
            <dt class="col-sm-4">Invoice Date</dt>
            <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($invoice->inv_date)) }}</dd>
            <dt class="col-sm-4">PO No</dt>
            <dd class="col-sm-8">: {{ $invoice->po_no ? $invoice->po_no : '- ' }}</dd>
            <dt class="col-sm-4">Vendor</dt>
            <dd class="col-sm-8">: {{ $invoice->vendor->vendor_name }}</dd>
          </dl>
        </div>
        <hr>
        <div class="row mt-1">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-new_doktam">
            Add Additional Document
          </button>
        </div>
        </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Document Type</th>
            <th>Document No</th>
            <th>Receive Date</th>
            <th>Creator</th>
            <th>action</th>
          </tr>
          </thead>
          <tbody>
            @if (! $invoice->doktams->count())
              <tr>
                <td colspan="6" class="text-center text-red"><b>Data not found</b></td>
              </tr>
              @else
              @foreach ($invoice->doktams as $doktam)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $doktam->doctype->docdesc }}</td>
                  <td>{{ $doktam->document_no }}</td>
                  <td>{{ $doktam->receive_date ? date('d-M-Y', strtotime($doktam->receive_date)) : ' - ' }}</td>
                  <td>{{ $doktam->created_by }}</td>
                  <td>
                    <a href="{{ route('edit_doktam', $doktam) }}" class="btn btn-xs btn-warning">edit</a>
                    <form action="{{ route('accounting.doktam_delete', $doktam->id) }}" method="POST">
                      @csrf @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete?')" type="submit" class="btn btn-xs btn-danger"> delete</button>
                  </form></td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


<div class="modal fade" id="modal-new_doktam">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Additional Doc</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('accounting.doktam.add', $invoice->inv_id) }}" method="POST">
        @csrf
      <div class="modal-body">
        <div class="form-group">
          <label>Document No</label>
          <input class="form-control @error('document_no') is-invalid @enderror" name="document_no" value="{{ old('document_no') }}">
          @error('document_no')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label>Document Type</label>
          <select name="doctypes_id" class="form-control select2bs4">
            <option value="">-- select --</option>
            @foreach ($doctypes as $doctype)
                <option value="{{ $doctype->doctype_id }}">{{ $doctype->docdesc }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Receive Date</label>
          <input type="date" class="form-control" name="receive_date">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>  Save</button>
      </div>
    </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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

