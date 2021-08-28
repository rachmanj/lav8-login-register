<form action="{{ route('user.deactivate_update', $model->id) }}" method="POST">
  @csrf @method('PUT')
  <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">
    deactivate
  </button>
</form>