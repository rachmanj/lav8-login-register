<form action="{{ route('add_tocart', $model->inv_id) }}" method="POST">
  @csrf @method('DELETE')
  <input type="hidden" name="sent_status" value="CART">
  <button type="submit" class="btn btn-xs btn-primary" title="move to cart"><i class="fas fa-arrow-down"></i></button>
</form>