@extends('templates.main')

@section('title_page')
    Dashboard <small>(Project: {{ $project }})</small>
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('content')
    <div class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          @include('dashboard.row1')
        </div> <!-- row -->
        <!-- /.row -->

        <div class="row">
          
          <div class="col-4">
            {{-- @include('dashboard.monthly_avg') --}}
          </div>
          <div class="col-4">
            {{-- @include('dashboard.monthly_receive') --}}
          </div>

        </div>
      </div>
    </div>
@endsection