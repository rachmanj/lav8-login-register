@extends('templates.main')

@section('title_page')
    SPI
@endsection

@section('breadcrumb_title')
    spi
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('spis.create.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-undo"></i> Back</a>
        {{-- <a href="{{ route('accounting.spi_print_pdf', $spi->id) }}" class="btn btn-sm btn-success" target="_blank">View PDF</a> --}}
      </div>
      <div class="card-header">
        <dl class="row">
          <dt class="col-sm-2">Nomor</dt>
          <dd class="col-sm-10">: {{ $spi->nomor }}</dd>
          <dt class="col-sm-2">Tanggal</dt>
          <dd class="col-sm-10">: {{ date('d-M-Y', strtotime($spi->date)) }}</dd>
          <dt class="col-sm-2">Created by</dt>
          <dd class="col-sm-10">: {{ $spi->created_by }}</dd>
        </dl>
        <div class="col-5">
          <p><b>Receive Date</b></p>
          <form action="{{ route('spis_receive.update', $spi->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="input-group">
              <input type="date" name="received_date" id="received_date" class="form-control @error('received_date') is-invalid @enderror" autofocus>
              <span class="input-group-append">
                <button type="submit" class="btn btn-info btn-flat">Save</button>
              </span>
              @error('received_date')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
            </div>
          </form>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>INVOICE NO.</th>
              <th>INVOICE DATE</th>
              <th>VENDOR</th>
              <th>PO NO</th>
              <th>PROJECT</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($spi->invoices as $invoice)
                <tr>
                  <th>{{ $loop->iteration }}</th>
                  <th>{{ $invoice->inv_no }}</th>
                  <th>{{ date('d-M-Y', strtotime($invoice->inv_date)) }}</th>
                  <th>{{ $invoice->vendor->vendor_name }}</th>
                  <th>{{ $invoice->po_no }}</th>
                  <th>{{ $invoice->project->project_code }}</th>
                </tr>
                  @if ($invoice->doktams->count() > 0)
                    <thead>
                      <tr>
                        <th colspan="2" class="text-right">Additional Docs:</th>
                        <th>Document Type</th>
                        <th colspan="2">Dokumen No</th>
                      </tr>
                    </thead>
                      <tbody>
                        @foreach ($invoice->doktams as $doktam)
                          <tr>
                            <td colspan="2"></td>
                            <td>{{ $doktam->doctype->docdesc }}</td>
                            <td colspan="2">{{ $doktam->document_no }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
@endsection

