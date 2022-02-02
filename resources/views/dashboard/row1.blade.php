<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    {{-- <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span> --}}
    <span class="info-box-icon {{ $doktams_count < 10 ? 'bg-success' : 'bg-danger' }} bg-info elevation-1"><i class="fas fa-file-alt"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Pendings</span>
      <h4><b>{{ number_format($doktams_count, 0) }}</b> <small>Documents</small></h4>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    <span class="info-box-icon {{ $this_month_avg < 10 ? 'bg-success' : 'bg-danger' }} elevation-1"><i class="fas {{ $this_month_avg < 10 ? 'fa-thumbs-up' : 'fa-thumbs-down' }}"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Average This Month</span>
      <h4><b>{{ number_format($this_month_avg, 2) }}</b> <small>Days</small></h4>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->

<!-- fix for small devices only -->
<div class="clearfix hidden-md-up"></div>

<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    <span class="info-box-icon {{ $this_year_average < 10 ? 'bg-success' : 'bg-danger' }}  elevation-1">{{ number_format($this_year_average, 2) }}</span>

    <div class="info-box-content">
      <span class="info-box-text">Average This Year</span>
      <h4><b>{{ number_format($this_year_average, 2) }}</b> <small>Days</small></h4>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->