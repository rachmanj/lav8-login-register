@extends('templates.main')

@section('title_page')
    Dashboard
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('content')
    <div class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
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
                  {{ number_format($thisYearProcessed, 0) }}
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
              <span class="info-box-icon bg-success elevation-1">{{ number_format($thisYearInvAvgDayProcess, 2) }}</span>

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
        </div>
        <!-- /.row -->

        <div class="row">
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Monthly Average Inv Processing</h3>

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
          <!-- /.card -->
        </div>
      </div>
    </div>
@endsection