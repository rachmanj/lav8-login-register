<div class="card">
  <div class="card-header border-transparent">
    <h3 class="card-title">Monthly Inv Average Processing Days</h3>

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
          <th class="text-right">Average</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($monthly_avg as $item)
          <tr>
            <td class="text-left">{{ date('F', strtotime('2022-' . $item->month . '-01')) }}</td>
            <td class="text-right">{{ number_format($item->days, 2) }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.card-body -->
  
</div>