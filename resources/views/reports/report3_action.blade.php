@if (Auth()->user()->role == 'SUPERADMIN' || Auth()->user()->role == 'ADMINACC')
<form action="{{ route('recaddoc.copy_to_doktams') }}" method="POST">
  @csrf @method('PUT')
  <input type="hidden" name="recaddoc_id" value="{{ $model->recaddoc_id }}">
  <button type="submit" class="btn btn-xs btn-primary">Copy to Doktams</button>
</form>
@endif
