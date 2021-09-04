<form action="{{ route('accounting.lpd.addto_cart', $model->inv_id) }}" method="POST">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-plus"></i></button>
</form>