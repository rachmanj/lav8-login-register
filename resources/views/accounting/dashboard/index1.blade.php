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
          @include('accounting.dashboard.index1.row1')
        </div> <!-- row -->
        <!-- /.row -->

        <div class="row">
          
          <div class="col-4">
            @include('accounting.dashboard.index1.monthly_avg')
          </div>
          <div class="col-4">
            @include('accounting.dashboard.index1.monthly_receive')
          </div>

        </div>
      </div>
    </div>
@endsection