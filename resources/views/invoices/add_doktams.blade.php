@extends('templates.main')

@section('title_page')
    Invoice
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        @if (Session::has('status'))
          <div class="alert alert-success">
            {{ Session::get('status') }}
          </div>
        @endif
        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
        <h3 class="card-title">Invoice No. <b>{{ $invoice->inv_no }}</b> | PO No. <b>{{ $invoice->po_no ? $invoice->po_no : '' }}</b> | <b>{{ $invoice->vendor->vendor_name }}</b></h3>
      </div>
      <div class="card-header">        
        <h3 class="card-title">Additional Docs with Related PO</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="possible_doktams" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Document No.</th>
            <th>Doc. Type</th>
            <th>PO No</th>
            <th>Receive Date</th>
            <th>action</th>
          </tr>
          </thead>
          <tbody> 
            @if (!$doktams)
              <tr>
                <th colspan="6" class="text-center">Data not found</th>
              </tr>
            @else
              @foreach ($doktams as $doktam)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $doktam->document_no }}</td>
                  <td>{{ $doktam->doctype->docdesc }}</td>
                  <td>{{ $doktam->doktams_po_no }}</td>
                  <td>@if ($doktam->receive_date)
                    {{ date('d-M-Y', strtotime($doktam->receive_date)) }}
                      @else
                      -
                      @endif
                  </td>
                  <td>
                    <form action="{{ route('invoices.addto_invoice', $doktam->id) }}" method="POST">
                      @csrf @method('PUT')
                      <input type="hidden" name="invoices_id" value="{{ $invoice->inv_id }}">
                      <button type="submit" title="add to invoice" class="btn btn-xs btn-primary"><i class="fas fa-arrow-down"></i></button>
                    </form>
                  </td>
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

<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Additional Docs belongs to the Invoice</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Document No.</th>
            <th>Doc. Type</th>
            <th>PO No</th>
            <th>Receive Date</th>
            <th>action</th>
          </tr>
          </thead>
          <tbody> 
            @if (!$doktams)
              <tr>
                <th colspan="6" class="text-center">Data not found</th>
              </tr>
            @else
              @foreach ($invoice->doktams as $doktam)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $doktam->document_no }}</td>
                  <td>{{ $doktam->doctype->docdesc }}</td>
                  <td>{{ $doktam->doktams_po_no }}</td>
                  <td>@if ($doktam->receive_date)
                    {{ date('d-M-Y', strtotime($doktam->receive_date)) }}
                      @else
                      -
                      @endif
                  </td>
                  <td>
                    <form action="{{ route('invoices.removefrom_invoice', $doktam->id) }}" method="POST">
                      @csrf @method('PUT')
                      <input type="hidden" name="invoices_id" value="{{ $invoice->inv_id }}">
                      <button type="submit" title="remove from invoice" class="btn btn-xs btn-primary"><i class="fas fa-arrow-up"></i></button>
                    </form>
                  </td>
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
@endsection


