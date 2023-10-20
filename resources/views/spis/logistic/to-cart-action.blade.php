    <form action="{{ route('spis.logistic.add_tocart') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="document_id" value="{{ $model->id }}">
        <button type="submit" class="btn btn-xs btn-primary" title="move to cart"><i class="fas fa-arrow-down"></i></button>
    </form>
    @if ($model->user_id === auth()->user()->id)
    <form action="{{ route('spis.logistic.destroy_doktam') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record? this action cannot be undone!') }}" class="d-inline">
        @csrf
        <input type="hidden" name="document_id" value="{{ $model->id }}">
        <button type="submit" class="btn btn-xs btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
    </form>
    @endif
