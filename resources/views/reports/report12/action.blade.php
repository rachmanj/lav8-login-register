@if ($model->filename)
  <a href="{{ asset('document_upload/'. $model->filename) }}" class="btn btn-info btn-xs" target="_blank">show</a>
@else
  <a href="{{ route('reports.report12.edit', $model->inv_id) }}" class="btn btn-warning btn-xs">attach</a>
@endif