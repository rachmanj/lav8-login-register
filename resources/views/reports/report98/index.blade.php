@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    invoices
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        @if (Session::has('success'))
          <div class="alert alert-success">
            {{ Session::get('success') }}
          </div>
        @endif
        @if (Session::has('error'))
          <div class="alert alert-danger">
            {{ Session::get('error') }}
          </div>
        @endif
        <h5 class="card-title">{{ $nama_report }}</h5>
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
      </div>
      <div class="card-header">
        <div class="col-6">
          <p><b>Document No</b></p>
          <form action="{{ route('reports.report98_display') }}" method="POST">
            @csrf
            <div class="input-group input-group-sm">
              <input type="text" name="document_no" class="form-control">
              <span class="input-group-append">
                <button type="submit" class="btn btn-info btn-flat">Submit</button>
              </span>
            </div>
          </form>
        </div>
      </div>
      <!-- /.card-header -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection
