@extends('templates.main')

@section('title_page')
   Add Documents
@endsection

@section('breadcrumb_title')
    lpd
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    {{-- @if ($select_all_button)
                    <a href="{{ route('spis.logistic.move_all_tocart') }}" class="btn btn-sm btn-warning">Select All Documents to Send</a>
                    @endif --}}
                    <a href="{{ route('spis.logistic.index') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="card-body">
                    <table id="to_cart" class="table table-borderd-table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DocNo</th>
                                <th>DocType</th>
                                <th>Project</th>
                                <th>PONo</th>
                                <th>InvNo</th>
                                <th>Vendor</th>
                                <th>action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">CART</h3>
                    @if ($remove_all_button)
                    <a href="#" class="btn btn-sm btn-success float-right" role="button" data-toggle="modal" data-target="#modal-create-lpd">Save LPD</a>
                    <a href="{{ route('spis.logistic.remove_all_fromcart') }}" class="btn btn-sm btn-warning float-right mr-2">Remove All From Cart</a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="in_cart" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DocNo</th>
                                <th>DocType</th>
                                <th>Project</th>
                                <th>PONo</th>
                                <th>InvNo</th>
                                <th>Vendor</th>
                                <th>action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{-- MODAL CREATE LPD --}}
<div class="modal fade" id="modal-create-lpd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-title">
                <div class="modal-header">
                    <h4 class="modal-title">Edit LPD</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('spis.logistic.update', $lpd->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nomor">Nomor LPD</label>
                        <input name="nomor" id="nomor" value={{ $lpd->nomor }} class="form-control @error('nomor') is-invalid @enderror" placeholder="Nomor LPD">
                        @error('nomor')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                   
                    <div class="form-group">
                        <label for="to_person">To</label>
                        <input name="to_person" id="to_person" value="{{ $lpd->to_person }}" class="form-control @error('to_person') is-invalid @enderror" placeholder="To whom this LPD is sent">
                        @error('to_person')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer float-left">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CREATE LPD --}}

@endsection

@section('styles')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>


<script>
  $(function () {
    // AVAILABLE DOCUMENTS
    $("#to_cart").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('spis.logistic.to_cart.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'document_type'},
        {data: 'project_code'},
        {data: 'po_no'},
        {data: 'invoice_no'},
        {data: 'vendor_name'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
    })

    // DOCUMENTS IN CART
    $("#in_cart").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('spis.logistic.in_cart_data_edit.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'document_no'},
        {data: 'document_type'},
        {data: 'project_code'},
        {data: 'po_no'},
        {data: 'invoice_no'},
        {data: 'vendor_name'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
    })
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  }) 
</script>
@endsection