@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    reconcile
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Reconciliation</h3>
          <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
          <a href="{{ route('reports.reconcile.delete_mine') }}" class="btn btn-sm btn-danger float-right mr-2" onclick="return confirm('Yakin nih mau menghapus data? Ga bisa dibalikin lagi lho datanya..')"><i class="fas fa-trash"></i> Delete All</a>
          <a href="{{ route('reports.reconcile.export') }}" class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-print"></i> Export</a>
          <button class="btn btn-sm btn-success float-right mr-2" data-toggle="modal" data-target="#reconcile-upload"><i class="fas fa-upload"></i> Upload</button>
        </div>

        <div class="card-body">
          <table id="reconcile-data" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>InvoiceNo</th>
                <th>InvoiceIRR</th>
                <th>VendorN</th>
                <th class="text-center">ReceiveD</th>
                <th class="text-right">Amount</th>
                <th>SPINo</th>
                <th class="text-center">SPIDate</th>
              </tr>
            </thead>
            <tbody>
              @if ($reconciles->count() > 0)
                @foreach ($reconciles as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->invoice_no }}</td>
                  <td>{{ $item->invoice_irr }}</td>
                  <td>{{ $item->vendor }}</td>
                  <td class="text-center">{{ $item->receive_date !== null ? date('d-M-Y', strtotime($item->receive_date)) : null }}</td>
                  <td class="text-right">{{ $item->amount !== null ? number_format($item->amount, 2) : null }}</td>
                  <td>{{ $item->spi_no }}</td>
                  <td class="text-center">{{ $item->spi_date !== null ? date('d-M-Y', strtotime($item->spi_date)) : null }}</td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="8" class="text-center">No data found</td>
                </tr>
              @endif              
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

  {{-- MODAL UPLOAD --}}
  <div class="modal fade" id="reconcile-upload">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Upload Data to reconciled</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('reports.reconcile.upload') }}" enctype="multipart/form-data" method="POST">
          @csrf
        <div class="modal-body">

            <div class="form-group">
                <label>Data to upload</label>
                <div class="form-group">
                <input type="file" name='file_upload' required class="form-control">
                </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"> Upload</button>
        </div>
      </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection
