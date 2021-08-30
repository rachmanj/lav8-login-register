<form action="{{ route('remove_fromcart', $model->inv_id) }}" method="POST">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></button>
</form>