<form action="{{ route('additionaldocs.receive.destroy', $model->id) }}" method="POST">
  @csrf @method('DELETE')
  <a href="{{ route('additionaldocs.receive.edit', $model->id) }}" class="btn btn-xs btn-warning">edit</i></a>
  @if (Auth()->user()->role == 'SUPERADMIN' || Auth()->user()->role == 'ADMINACC')
  <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Kamu yakin mau menghapus data?')">delete</button>
  @endif
</form>