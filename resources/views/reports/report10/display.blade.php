@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    additional_docs
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Additional Documents</h3>
            <a href="{{ route('reports.report10.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>No</th>
                  <th>Type</th>
                  <th>Receive Date</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                @if ($documents)
                  @foreach ($documents as $document)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $document->document_no }}</td>
                      <td>{{ $document->doctype->docdesc }}</td>
                      <td>{{ $document->receive_date ? date('d-m-Y', strtotime($document->receive_date)) : '' }}</td>
                      <td>
                        <a href="{{ route('reports.report10.edit', $document->id) }}" class="btn btn-warning btn-xs"><i class="fas fa-file-import"></i> Attach Docs</a>
                        <a href="{{ asset('document_upload/'. $document->filename) }}" class="btn btn-info btn-xs" target="_blank"><i class="fas fa-search"></i> Preview</a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" class="text-center">No data available</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection