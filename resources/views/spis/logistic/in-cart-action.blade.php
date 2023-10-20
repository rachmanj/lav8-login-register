<form action="{{ route('spis.logistic.remove_fromcart') }}" method="POST">
    @csrf
    <input type="hidden" name="document_id" value="{{ $model->id }}">
    <button type="submit" class="btn btn-xs btn-primary" title="remove to cart"><i class="fas fa-arrow-up"></i></button>
</form>