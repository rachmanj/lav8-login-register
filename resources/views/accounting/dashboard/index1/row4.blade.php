<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    {{-- <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span> --}}
    <span class="info-box-icon {{ $doktamNoInvoiceOldCount < 20 ? 'bg-success' : 'bg-danger' }}  elevation-1"><i class="fas fa-folder-open"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Doktams without invoice > 60 days</span>
      <h4><b><a href="{{ route('reports.report7.index') }}">{{ number_format($doktamNoInvoiceOldCount, 0) }}</a></b> <small>Documents</small></h4>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>


