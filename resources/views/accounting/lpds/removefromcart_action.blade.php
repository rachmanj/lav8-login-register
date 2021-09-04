<form action="{{ route('accounting.lpd.removefrom_cart', $model->inv_id) }}" method="POST">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-xs btn-warning"><i class="fas fa-minus"></i></button>
</form>