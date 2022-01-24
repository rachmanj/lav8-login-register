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
          <th class="text-right">Receive</th>
          <th class="text-right">Processed</th>
          <th class="text-right">%</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($thisYearReceivedGet as $inv_receive)
          <tr>
            <td class="text-left">{{ date('F', strtotime('2022-' . $inv_receive->month . '-01')) }}</td>
            <td class="text-right">{{ $inv_receive->receive_count }}</td>
            <td class="text-right">{{ $thisYearProcessedGet->where('month', $inv_receive->month)->count() }}</td>
            <td class="text-right">{{ $inv_receive->receive_count == 0 || $thisYearProcessedGet->where('month', $inv_receive->month)->count() == 0 ? null : number_format(($thisYearProcessedGet->where('month', $inv_receive->month)->count() / $inv_receive->receive_count ) * 100, 2) }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.card-body -->
  
</div>