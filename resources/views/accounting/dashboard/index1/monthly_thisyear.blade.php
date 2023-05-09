<div class="card">
  <div class="card-header border-transparent">
    <h3 class="card-title">Monthly Receive vs Processed <small>(This Year)</small></h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table m-0">
        <thead>
        <tr>
          <th class="text-left">Month</th>
          <th class="text-right">Avg (days)</th>
          <th class="text-right">Receive</th>
          <th class="text-right">Processed</th>
          {{-- <th class="text-right">%</th> --}}
        </tr>
        </thead>
        <tbody>
        @foreach ($thisYearReceivedGet as $receive)
          <tr>
            <td class="text-left">{{ date('F', strtotime('2023-' . $receive->month . '-01')) }}</td>
            <td class="text-right">{{ $monthly_avg->where('month', $receive->month)->first() ? number_format($monthly_avg->where('month', $receive->month)->first()->avg_days, 2) : ' - ' }}</td>
            <td class="text-right">{{ $receive->receive_count }}</td>
            <td class="text-right">{{ $receive->receive_count == 0 || $thisYearProcessedGet->where('month', $receive->month)->count() == 0 ? null : number_format(($thisYearProcessedGet->where('month', $receive->month)->first()->processed_count / $receive->receive_count ) * 100, 2) }} %</td>
          </tr>
        @endforeach
        </tbody>
        <thead>
          <tr>
            <th>Total</th>
            <th class="text-right">{{ number_format($thisYearInvAvgDayProcess, 2) }}</th>
            <th class="text-right">{{ $thisYearReceiveCount }}</th>
            {{-- <th class="text-right">{{ number_format(($thisYearProcessedCount/$thisYearReceiveCount) * 100, 2) }} %</th> --}}
            <th class="text-right">{{ $process_index }} %</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.card-body -->
  
</div>