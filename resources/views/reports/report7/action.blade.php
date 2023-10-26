<form action="{{ route('reports.report7.destroy', $model->id) }}" method="POST" class="d-inline">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this record? this action cannot be undone!')">cancel</button>
</form>