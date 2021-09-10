<form action="{{ route('invoices.removefrom_invoice', $model->id) }}" method="POST">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-xs btn-warning"><i class="fas fa-plus"></i></button>
</form>