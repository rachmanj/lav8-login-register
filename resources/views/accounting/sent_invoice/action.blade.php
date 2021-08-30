<form action="{{ route('add_tocart', $model->inv_id) }}" method="POST">
  @csrf @method('DELETE')
  <input type="hidden" name="sent_status" value="CART">
  <button type="submit" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></button>
</form>