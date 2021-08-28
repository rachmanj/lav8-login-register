<form action="{{ route('user.activate_update', $model->id) }}" method="POST">
  @csrf @method('PUT')
  <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-success">
    activate
  </button>
</form>