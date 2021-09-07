<a href="{{ route('doktams.show', $model->id) }}" class="btn btn-xs btn-default">
  <i class="fas fa-comments"></i>
</a>
@if (Auth()->user()->role === 'ADMINACC')
<a href="{{ route('doktams.edit', $model->id) }}" class="btn btn-xs btn-warning float-right"><i class="fas fa-edit"></i></a>
@endif