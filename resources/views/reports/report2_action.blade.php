@if (Auth()->user()->role == 'SUPERADMIN' || Auth()->user()->role == 'ADMINACC')
<a href="{{ route('invoices.add_doktams', $model->inv_id) }}" class="btn btn-xs btn-success"><i class="fas fa-file-medical"></i></a>
@endif
