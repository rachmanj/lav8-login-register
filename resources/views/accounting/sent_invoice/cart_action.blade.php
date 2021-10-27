<form action="{{ route('remove_fromcart', $model->inv_id) }}" method="POST">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-xs btn-primary" title="remove from cart"><i class="fas fa-arrow-up"></i></button>
</form>