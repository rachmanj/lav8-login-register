@if (Auth()->user()->role == 'SUPERADMIN' || Auth()->user()->role == 'ADMINACC')
<a href="{{ route('reports.report2.show', $model->inv_id) }}" class="btn btn-xs btn-success" title="Show">show</a>
@endif
