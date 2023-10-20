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
        <form action="{{ route('spis.logistic.destroy', $spi->id) }}" method="POST">
          <a href="{{ route('spis.logistic.print', $spi->id) }}" class="btn btn-sm btn-info" target="_blank">View / Print PDF</a>
          @if ($spi->flag === "NOTSENT")
          <a href="{{ route('spis.logistic.sent', $spi->id) }}" class="btn btn-sm btn-success">SENT This</a>
          @endif
          <a href="{{ route('spis.logistic.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
          @csrf @method('DELETE')
          @if ($spi->flag === "NOTSENT")
          <button type="submit" class="btn btn-sm btn-danger float-right mx-2" onclick="return confirm('Are you sure you want to delete this record?')">delete</button>
          @endif
        </form>
      </div>
      <div class="card-header">
        <h3 class="card-title">SPI No. <b>{{ $spi->nomor }}</b> | To : <b>{{ $spi->to_department . ' - ' . $spi->to_project->project_code . ', ' . $spi->to_person; }}</b></h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>DOC NO</th>
                <th>DOC TYPE</th>
                <th>PO NO</th>
                <th>PROJECT</th>
                <th>VENDOR</th>
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

@section('styles')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

@endsection