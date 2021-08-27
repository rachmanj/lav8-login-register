<form action="{{ route('accounting.destroy_addoc', $model->addoc_id) }}" method="POST">
  @csrf @method('DELETE')
  <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> </button>
</form>