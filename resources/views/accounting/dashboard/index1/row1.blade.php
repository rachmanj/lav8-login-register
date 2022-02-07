<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    {{-- <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span> --}}
    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-alt"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Received This Month (HO)</span>
      <h4><b>{{ number_format($thisMonthReceiveCount, 0) }}</b> <small>Invoices</small></h4>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-envelope-open"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Sent This Month</span>
      <h4><b>{{ number_format($invoiceSentThisMonth, 0) }}</b> <small>Invoices</small></h4>
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
    <span class="info-box-icon {{ $thisMontAvgDayProcess < 6.5 ? 'bg-success' : 'bg-danger' }}  elevation-1"><i class="fas {{ $thisMontAvgDayProcess < 6.5 ? 'fa-thumbs-up' : 'fa-frown' }} "></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Avg Processing This Month</span>
      <h4><b>{{ number_format($thisMontAvgDayProcess, 2) }}</b> <small>Days</small></h4>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->