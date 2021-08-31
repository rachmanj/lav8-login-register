@extends('templates.main')

@section('title_page')
    New SPI
@endsection

@section('breadcrumb_title')
    spi
@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Create SPI</h3>
      </div>
      <div class="card-header">
        <h3 class="card-title"><a href="{{ route('view_spi') }}" class="btn btn-primary"> Back</a></h3>
      </div>
      <form action="{{ route('store_spi') }}" method="POST">
        @csrf 
        <div class="card-body">
          <div class="form-group">
            <label>SPI No</label>
            <input name="nomor"  value="{{ old('nomor') }}" class="form-control @error('nomor') is-invalid @enderror">
            @error('nomor')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Date</label>
            <input name='date' type="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror">
            @error('date')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        
          <div class="form-group">
            <label>Send to</label>
            <select name="to_projects_id" class="form-control select2bs4 @error('to_projects_id') is-invalid @enderror" style="width: 100%;">
              <option value="">-- select recipient --</option>
              @foreach ($projects as $project)
                <option {{ old('to_projects_id') == $project->project_id ? "selected" : "" }} value="{{ $project->project_id }}">{{ $project->project_code }}</option>
              @endforeach
            </select>
            @error('to_projects_id')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Expedisi</label>
            <input name="expedisi" type="text" value="{{ old('expedisi') }}" class="form-control @error('expedisi') is-invalid @enderror">
            @error('expedisi')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>  Save</button>
              </div>
            </div>
          </div>

        </div>
      </form>

      </div>
      
    </div>
  </div>
</div>
@endsection

@section('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    }) 
  </script>
@endsection