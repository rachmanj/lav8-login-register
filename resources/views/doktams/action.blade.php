<a href="{{ route('doktams.show', $model->id) }}" class="btn btn-xs btn-default">
  <i class="fas fa-comments"></i>
</a>
@if (Auth()->user()->role === 'ADMINACC')
<a href="{{ route('doktams.edit', $model->id) }}" class="btn btn-xs btn-warning float-right"><i class="fas fa-edit"></i></a>
@endif
@if (auth()->user()->role === 'SUPERADMIN')
  <a href="{{ route('doktams.in_activate', $model->id) }}" role="button" onclick="return confirm('Are you sure you want to inactivate this document?')" class="btn btn-xs btn-danger float-right" title="inactivate"><i class="fas fa-trash-alt"></i>
  </a>
@endif