<div class="card">
  <div class="card-header border-transparent">
    <h3 class="card-title">Monthly Receive vs Processed</h3>

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
        @foreach ($lastYearReceivedGet as $invoice)
          <tr>
            <td class="text-left">{{ date('F', strtotime('2021-' . $invoice->month . '-01')) }}</td>
            <td class="text-right">{{ $lastYear_avg->where('month', $invoice->month)->first() ? number_format($lastYear_avg->where('month', $invoice->month)->first()->avg_days, 2) : ' - ' }}</td>
            <td class="text-right">{{ $invoice->receive_count }}</td>
            {{-- <td class="text-right">{{ $invoice->month }}</td> --}}
            <td class="text-right">{{ $lastYearProcessedGetCount->where('month', $invoice->month)->first() ? number_format(($lastYearProcessedGetCount->where('month', $invoice->month)->first()->process_count / $invoice->receive_count ) * 100, 2) : ' na ' }} %</td>
          </tr>
        @endforeach
        </tbody>
        <thead>
          <tr>
            <th>Total</th>
            <th class="text-right">{{ number_format($thisYearInvAvgDayProcess, 2) }}</th>
            <th class="text-right">{{ number_format($lastYearReceiveCount, 0) }}</th>
            <th class="text-right">{{ number_format(($lastYearProcessedCount/$lastYearReceiveCount) * 100, 2) }} %</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.card-body -->
  
</div>