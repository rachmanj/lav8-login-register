<form action="{{ route('payment_details.remove_fromcart', $model->inv_id) }}" method="POST">
  @csrf @method('PUT')
  <button type="submit" class="btn btn-xs btn-primary"><i class="fas fa-arrow-up"></i></button>
</form>