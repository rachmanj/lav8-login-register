<form action="{{ route('payment_details.add_tocart', $model->inv_id) }}" method="POST">
  @csrf @method('PUT')
  <button type="submit" class="btn btn-xs btn-primary"><i class="fas fa-arrow-down"></i></button>
</form>