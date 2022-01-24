<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    {{-- <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span> --}}
    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Invoice Received (HO)</span>
      <span class="info-box-number">
        {{ number_format($thisMonthReceiveCount, 0) }}
        <small> this month</small>
      </span>
      <span class="info-box-number">
        {{ number_format($thisYearReceiveCount, 0) }}
        <small> this year</small>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-12 col-sm-6 col-md-4">
  <div class="info-box mb-3">
    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Invoice Processed Count</span>
      <span class="info-box-number">
        {{ number_format($thisMonthProcessed, 0) }}
        <small> this month</small>
      </span>
      <span class="info-box-number">
        {{ number_format($thisYearProcessedCount, 0) }}
        <small> this year</small>
      </span>
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
    <span class="info-box-icon {{ $thisYearInvAvgDayProcess < 6.5 ? 'bg-success' : 'bg-danger' }}  elevation-1">{{ number_format($thisYearInvAvgDayProcess, 2) }}</span>

    <div class="info-box-content">
      <span class="info-box-text">Average Processing Days</span>
      <span class="info-box-number">
        {{ number_format($thisMontAvgDayProcess, 2) }}
        <small> this month</small>
      </span>
      <span class="info-box-number">
        {{ number_format($thisYearInvAvgDayProcess, 2) }}
        <small> this year</small>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->