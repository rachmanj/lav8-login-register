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
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
        <form action="{{ route('reports.report10.display') }}" method="POST">
          @csrf
          <div class="col-6">
            <label>Document No </label>
            <div class="input-group mb-3">
              <input type="text" name="document_no" class="form-control rounded-0">
              <span class="input-group-append">
                <button type="submit" class="btn btn-success btn-flat">Go!</button>
              </span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection