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
        </div>
        <div class="row">
          @include('accounting.dashboard.index1.row2')
        </div> 

        <div class="row">  
          <div class="col-6">
            @include('accounting.dashboard.index1.monthly_receive')
          </div>
          <div class="col-6">
            {{-- @include('accounting.dashboard.index1.monthly_payment')  --}}
          </div>
        </div>

        <div class="row">
          @include('accounting.dashboard.index1.row4')
        </div> 


      </div>
    </div>
@endsection