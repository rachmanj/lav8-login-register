<form action="{{ route('additionaldocs.destroy', $model->id) }}" method="POST">
  @csrf @method('DELETE')
  <a href="{{ route('additionaldocs.edit', $model->id) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
  <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Kamu yakin mau menghapus data?')"><i class="fas fa-trash"></i></button>
</form>