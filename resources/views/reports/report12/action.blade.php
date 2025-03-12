@if ($model->filename)
    <a href="{{ asset('document_upload/' . $model->filename) }}" class="btn btn-info btn-xs" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
@else
    <a href="{{ route('reports.report12.edit', $model->inv_id) }}" class="btn btn-warning btn-xs">
        <i class="fas fa-paperclip"></i>
    </a>
@endif
<a href="{{ route('reports.report12.show', $model->inv_id) }}" class="btn btn-primary btn-xs">
    <i class="fas fa-info-circle"></i>
</a>
