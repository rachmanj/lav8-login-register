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
        <a href="{{ route('spis.general.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
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
          <form action="{{ route('spis.general.receive.update', $spi->id) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="form_type" value="lpd">
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
            @foreach ($spi->doktams as $doktam)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $doktam->document_no }}</td>
                    <td>{{ $doktam->doctype->docdesc }}</td>
                    <td>
                      @if ($doktam->doktams_po_no)
                        {{ $doktam->doktams_po_no }}
                      @elseif ($doktam->invoice)
                          {{ $doktam->invoice->po_no }}
                      @endif 
                    </td>
                    <td>
                      @if ($doktam->project_id)
                          {{ $doktam->project->project_code }}
                      @elseif ($doktam->invoice)
                          {{ $doktam->invoice->project->project_code }}
                      @endif
                    </td>
                    <td>
                    @if ($doktam->invoice)
                        {{ $doktam->invoice->vendor->vendor_name }}
                    @endif
                    </td>
                  </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
@endsection

