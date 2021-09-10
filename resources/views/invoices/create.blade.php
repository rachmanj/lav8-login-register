@extends('templates.main')

@section('title_page')
    Invoices
@endsection

@section('breadcrumb_title')
    invoice
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">New Invoice</h5>
          </div>
          <div class="card-body">

            <form action="{{ route('invoices.store') }}" method="POST">
              @csrf
            <div class="row">
              <div class="col-5">
                <div class="form-group">
                  <label>Vendor</label>
                  <select name="vendor_id" id="vendor" class="form-control select2bs4 @error('vendor_id') is-invalid @enderror" autofocus>
                    <option value="">-- pilih vendor --</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }}</option>
                    @endforeach
                  </select>
                  @error('vendor_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label>Cabang</label>
                  <select name="vendor_branch" id="branch" class="form-control @error('vendor_branch') is-invalid @enderror">
                  </select>
                    @error('vendor_branch')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <label>Payment Place</label>
                  <select name="payment_place" class="form-control">
                    <option value="JKT">JKT</option>
                    <option value="BPN">BPN</option>
                  </select>
                </div>
              </div>
            </div>
            

            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>Invoice No.</label>
                  <input type="text" name="inv_no" class="form-control">
                </div>
              </div>
              <div class="col-4">
                <label>Invoice Date</label>
                  <input type="date" name="inv_date" class="form-control">
              </div>
              <div class="col-4">
                <label>Receive Date</label>
                  <input type="date" name="receive_date" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>PO No.</label>
                  <input type="text" name="po_no" class="form-control">
                </div>
              </div>
              <div class="col-4">
                <label>Category</label>
                  <select name="inv_type" class="form-control">
                    <option value="">-- select category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->invtype_id }}">{{ $category->invtype_name }}</option>
                    @endforeach
                  </select>
              </div>

              <div class="col-4">
                <label>Project</label>
                <select name="inv_project" class="form-control select2bs4">
                  <option value="">-- select project --</option>
                  @foreach ($projects as $project)
                      <option value="{{ $project->project_id }}">{{ $project->project_code }} - {{ $project->project_location }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>Receive Place</label>
                  <select name="receive_place" class="form-control">
                    <option value="BPN">BPN</option>
                    <option value="JKT">JKT</option>
                  </select>
                </div>
              </div>
              <div class="col-4">
                <label>Currency</label>
                <select name="inv_currency" class="form-control">
                  <option value="IDR">IDR</option>
                  <option value="USD">USD</option>
                </select>
              </div>
              <div class="col-4">
                <label>Nominal</label>
                <input name="inv_nominal" type="number" step="any" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" class="form-control" cols="5" rows="3"></textarea>
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

@section('styles')
    <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    $("#vendor").change(function() {
      $.ajax({
        url: "{{ route('get_branch') }}?vendor_id=" + $(this).val(),
        method: 'GET',
        success: function(data) {
          $('#branch').html(data.html);
        }
      });
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